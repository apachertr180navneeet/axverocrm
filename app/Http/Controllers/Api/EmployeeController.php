<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EmployeeDetails;
use App\Models\EmployeeSkill;
use App\Models\Skill;
use App\Models\Role;
use App\Models\Team;
use App\Models\Designation;
use App\Helper\Files;
use App\Scopes\ActiveScope;
use Modules\Payroll\Entities\EmployeeMonthlySalary;

class EmployeeController extends Controller
{


    public function index()
    {
        try {

            $employees = User::with(['employeeDetail.designation', 'employeeDetail.department'])
                ->where('id', auth()->id())
                ->latest()
                ->get()
                ->map(function ($user) {

                    $salary = 0;

                    if (
                        function_exists('module_enabled') &&
                        module_enabled('Payroll') &&
                        function_exists('user_modules') &&
                        in_array('payroll', user_modules()) &&
                        class_exists(\Modules\Payroll\Entities\EmployeeMonthlySalary::class)
                    ) {
                        $salaryData = EmployeeMonthlySalary::employeeNetSalary($user->id, now());
                        $salary = $salaryData['netSalary'] ?? 0;
                    } else {
                        $salary = optional($user->employeeDetail)->hourly_rate ?? 0;
                    }

                    return [
                        'id'             => $user->id,
                        'employee_id'    => optional($user->employeeDetail)->employee_id,
                        'name'           => $user->name,
                        'email'          => $user->email,
                        'mobile'         => $user->mobile,
                        'status'         => $user->status,
                        'designation'    => optional(optional($user->employeeDetail)->designation)->name,
                        'department'     => optional(optional($user->employeeDetail)->department)->team_name,
                        'monthly_salary' => $salary,
                    ];
                });

            return response()->json([
                'status'  => true,
                'message' => 'Employees fetched successfully',
                'data'    => $employees,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

  
    public function show($id)
    {
        try {

            // Module check
            if (!in_array('employees', auth()->user()->modules)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Employees module is not enabled.',
                ], 403);
            }

        
            if (in_array('client', auth()->user()->roles->pluck('name')->toArray())) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Clients are not allowed to view employee profiles.',
                ], 403);
            }

            $viewPermission = auth()->user()->permission('view_employees');

            $employee = User::withoutGlobalScope(ActiveScope::class)
                ->with([
                    'employeeDetail.designation',
                    'employeeDetail.department',
                  
                ])
                ->findOrFail($id);
                
                $skills = EmployeeSkill::with('skill')
            ->where('user_id', $id)
            ->get()
            ->map(fn($s) => [
                'id'   => optional($s->skill)->id,
                'name' => optional($s->skill)->name,
            ])->filter()->values();


            if (
                $employee->status == 'deactive' &&
                !in_array('admin', auth()->user()->roles->pluck('name')->toArray())
            ) {
                return response()->json([
                    'status'  => false,
                    'message' => 'This employee account is deactivated.',
                ], 403);
            }

           
            $canView =
                $viewPermission == 'all'
                || ($viewPermission == 'added' && optional($employee->employeeDetail)->added_by == auth()->id())
                || ($viewPermission == 'owned' && optional($employee->employeeDetail)->user_id  == auth()->id())
                || ($viewPermission == 'both'  && (
                        optional($employee->employeeDetail)->user_id  == auth()->id() ||
                        optional($employee->employeeDetail)->added_by == auth()->id()
                   ));

            if (!$canView) {
                return response()->json([
                    'status'  => false,
                    'message' => 'You are not authorized to view this employee profile.',
                ], 403);
            }

            $salary = 0;

            if (
                function_exists('module_enabled') &&
                module_enabled('Payroll') &&
                function_exists('user_modules') &&
                in_array('payroll', user_modules()) &&
                class_exists(\Modules\Payroll\Entities\EmployeeMonthlySalary::class)
            ) {
                $salaryData = EmployeeMonthlySalary::employeeNetSalary($employee->id, now());
                $salary = $salaryData['netSalary'] ?? 0;
            } else {
                $salary = optional($employee->employeeDetail)->hourly_rate ?? 0;
            }

            return response()->json([
                'status'  => true,
                'message' => 'Employee profile fetched successfully',
                'data'    => [
                    // Basic Info
                    'id'                       => $employee->id,
                    'employee_id'              => optional($employee->employeeDetail)->employee_id,
                    'name'                     => $employee->name,
                    'email'                    => $employee->email,
                    'mobile'                   => $employee->mobile,
                    'gender'                   => $employee->gender,
                    'salutation'               => $employee->salutation,
                    'status'                   => $employee->status,
                    'image_url'                => $employee->image_url,

                    // Job Info
                    'designation'              => optional(optional($employee->employeeDetail)->designation)->name,
                    'designation_id'           => optional($employee->employeeDetail)->designation_id,
                    'department'               => optional(optional($employee->employeeDetail)->department)->team_name,
                    'department_id'            => optional($employee->employeeDetail)->department_id,
                    'employment_type'          => optional($employee->employeeDetail)->employment_type,
                    'hourly_rate'              => optional($employee->employeeDetail)->hourly_rate,
                    'monthly_salary'           => $salary,
                    'slack_username'           => optional($employee->employeeDetail)->slack_username,
                    'reporting_to'             => optional($employee->employeeDetail)->reporting_to,

                    // Personal Info
                    'address'                  => optional($employee->employeeDetail)->address,
                    'about_me'                 => optional($employee->employeeDetail)->about_me,
                    'marital_status'           => optional($employee->employeeDetail)->marital_status,
                    'date_of_birth'            => optional($employee->employeeDetail)->date_of_birth
                                                    ? optional($employee->employeeDetail)->date_of_birth->format('Y-m-d')
                                                    : null,

                    // Dates
                    'joining_date'             => optional($employee->employeeDetail)->joining_date
                                                    ? optional($employee->employeeDetail)->joining_date->format('Y-m-d')
                                                    : null,
                    'probation_end_date'       => optional($employee->employeeDetail)->probation_end_date
                                                    ? optional($employee->employeeDetail)->probation_end_date->format('Y-m-d')
                                                    : null,
                    'notice_period_start_date' => optional($employee->employeeDetail)->notice_period_start_date
                                                    ? optional($employee->employeeDetail)->notice_period_start_date->format('Y-m-d')
                                                    : null,
                    'notice_period_end_date'   => optional($employee->employeeDetail)->notice_period_end_date
                                                    ? optional($employee->employeeDetail)->notice_period_end_date->format('Y-m-d')
                                                    : null,
                    'contract_end_date'        => optional($employee->employeeDetail)->contract_end_date
                                                    ? optional($employee->employeeDetail)->contract_end_date->format('Y-m-d')
                                                    : null,

                    // Skills
                  'skills' => $skills,
                ],
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Employee not found',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


        // =========================================================
// ✅ EDIT — Naya, web jaisi permissions ke saath
// =========================================================
public function edit($id)
{
    try {

        // Module check
    

        // skills.skill HATAYA — alag se load kar rahe hain
        $employee = User::withoutGlobalScope(ActiveScope::class)
            ->with([
                'employeeDetail.designation',
                'employeeDetail.department',
            ])
            ->findOrFail($id);


        $employeeRoles = $employee->roles->pluck('name')->toArray();

    

        // Skills alag se load
        $employeeSkills = EmployeeSkill::with('skill')
            ->where('user_id', $id)
            ->get()
            ->map(fn($s) => [
                'id'   => optional($s->skill)->id,
                'name' => optional($s->skill)->name,
            ])->filter()->values();

        // Dropdowns
        $departments  = Team::all(['id', 'team_name']);
        $designations = Designation::allDesignations();
        $skills       = Skill::all(['id', 'name']);

        return response()->json([
            'status'  => true,
            'message' => 'Employee edit data fetched successfully',
            'data'    => [
                'employee' => [
                    'id'                       => $employee->id,
                    'employee_id'              => optional($employee->employeeDetail)->employee_id,
                    'name'                     => $employee->name,
                    'email'                    => $employee->email,
                    'mobile'                   => $employee->mobile,
                    'gender'                   => $employee->gender,
                    'salutation'               => $employee->salutation,
                    'image_url'                => $employee->image_url,
                    'address'                  => optional($employee->employeeDetail)->address,
                    'about_me'                 => optional($employee->employeeDetail)->about_me,
                    'department_id'            => optional($employee->employeeDetail)->department_id,
                    'designation_id'           => optional($employee->employeeDetail)->designation_id,
                    'hourly_rate'              => optional($employee->employeeDetail)->hourly_rate,
                    'slack_username'           => optional($employee->employeeDetail)->slack_username,
                    'reporting_to'             => optional($employee->employeeDetail)->reporting_to,
                    'marital_status'           => optional($employee->employeeDetail)->marital_status,
                    'employment_type'          => optional($employee->employeeDetail)->employment_type,
                    'joining_date'             => optional($employee->employeeDetail)->joining_date
                                                    ? optional($employee->employeeDetail)->joining_date->format('Y-m-d')
                                                    : null,
                    'date_of_birth'            => optional($employee->employeeDetail)->date_of_birth
                                                    ? optional($employee->employeeDetail)->date_of_birth->format('Y-m-d')
                                                    : null,
                    'probation_end_date'       => optional($employee->employeeDetail)->probation_end_date
                                                    ? optional($employee->employeeDetail)->probation_end_date->format('Y-m-d')
                                                    : null,
                    'notice_period_start_date' => optional($employee->employeeDetail)->notice_period_start_date
                                                    ? optional($employee->employeeDetail)->notice_period_start_date->format('Y-m-d')
                                                    : null,
                    'notice_period_end_date'   => optional($employee->employeeDetail)->notice_period_end_date
                                                    ? optional($employee->employeeDetail)->notice_period_end_date->format('Y-m-d')
                                                    : null,
                    'skills' => $employeeSkills,  // alag se loaded
                ],
                'departments'  => $departments,
                'designations' => $designations,
                'skills'       => $skills,
            ],
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Employee not found',
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong',
        ], 500);
    }
}


    public function store(Request $request)
    {
        try {

            $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'password'    => 'required|min:6',
                'employee_id' => 'required',
                'department'  => 'nullable|exists:teams,id',
                'designation' => 'nullable|exists:designations,id',
            ]);

            DB::beginTransaction();

            $user                    = new User();
            $user->name              = $request->name;
            $user->email             = $request->email;
            $user->password          = bcrypt($request->password);
            $user->mobile            = $request->mobile;
            $user->country_id        = $request->country;
            $user->country_phonecode = $request->country_phonecode;
            $user->gender            = $request->gender;
            $user->salutation        = $request->salutation;
            $user->locale            = $request->locale ?? 'en';
            $user->status            = 'active';
            $user->save();

            $employee                           = new EmployeeDetails();
            $employee->user_id                  = $user->id;
            $employee->employee_id              = $request->employee_id;
            $employee->address                  = $request->address;
            $employee->hourly_rate              = $request->hourly_rate;
            $employee->slack_username           = $request->slack_username;
            $employee->department_id            = $request->department;
            $employee->designation_id           = $request->designation;
            $employee->company_address_id       = $request->company_address;
            $employee->reporting_to             = $request->reporting_to;
            $employee->about_me                 = $request->about_me;
            $employee->joining_date             = $request->joining_date;
            $employee->date_of_birth            = $request->date_of_birth;
            $employee->probation_end_date       = $request->probation_end_date;
            $employee->notice_period_start_date = $request->notice_period_start_date;
            $employee->notice_period_end_date   = $request->notice_period_end_date;
            $employee->marital_status           = $request->marital_status;
            $employee->employment_type          = $request->employment_type;
            $employee->save();

            $employeeRole = Role::where('name', 'employee')->first();

            if ($employeeRole) {
                $user->roles()->attach($employeeRole->id);
            }

            if ($request->role) {
                $user->roles()->attach($request->role);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Employee created successfully',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'email'       => 'required|email|unique:users,email,' . $id,
                'department'  => 'nullable|exists:teams,id',
                'designation' => 'nullable|exists:designations,id',
            ]);

            DB::beginTransaction();

            $user = User::findOrFail($id);

            $user->name              = $request->name;
            $user->email             = $request->email;
            $user->mobile            = $request->mobile;
            $user->country_id        = $request->country;
            $user->country_phonecode = $request->country_phonecode;
            $user->gender            = $request->gender;
            $user->salutation        = $request->salutation;
            $user->locale            = $request->locale ?? 'en';

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            $employee = EmployeeDetails::where('user_id', $user->id)->first();

            if (!$employee) {
                $employee          = new EmployeeDetails();
                $employee->user_id = $user->id;
            }

            $employee->employee_id              = $request->employee_id;
            $employee->address                  = $request->address;
            $employee->hourly_rate              = $request->hourly_rate;
            $employee->slack_username           = $request->slack_username;
            $employee->department_id            = $request->department;
            $employee->designation_id           = $request->designation;
            $employee->company_address_id       = $request->company_address;
            $employee->reporting_to             = $request->reporting_to;
            $employee->about_me                 = $request->about_me;
            $employee->joining_date             = $request->joining_date;
            $employee->date_of_birth            = $request->date_of_birth;
            $employee->probation_end_date       = $request->probation_end_date;
            $employee->notice_period_start_date = $request->notice_period_start_date;
            $employee->notice_period_end_date   = $request->notice_period_end_date;
            $employee->marital_status           = $request->marital_status;
            $employee->employment_type          = $request->employment_type;
            $employee->save();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Employee updated successfully',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}