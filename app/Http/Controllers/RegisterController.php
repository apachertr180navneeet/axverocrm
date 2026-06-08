<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use App\Helper\Reply;
use App\Models\Company;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionType;
use App\Models\UserInvitation;
use App\Models\UserPermission;
use App\Models\EmployeeDetails;
use App\Models\UniversalSearch;
use App\Models\AgentRetainer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\AcceptInviteRequest;
use App\Http\Requests\User\AccountSetupRequest;
use App\Events\NewUserRegistrationViaInviteEvent;
use App\Models\GlobalSetting;
use Symfony\Component\Mailer\Exception\TransportException;

class RegisterController extends Controller
{

    public function invitation($code)
    {
        if (Auth::check()) {
            return redirect(route('dashboard'));
        }

        $this->invite = UserInvitation::where('invitation_code', $code)
            ->where('status', 'active')
            ->firstOrFail();
            
         $this->employees = User::allEmployees(null, true);   
        $this->lastEmployeeID = EmployeeDetails::count();


        $this->globalSetting = GlobalSetting::first();

        return view('auth.invitation', $this->data);
    }

   public function acceptInvite(AcceptInviteRequest $request)
{
    $invite = UserInvitation::where('invitation_code', $request->invite)
        ->where('status', 'active')
        ->first();

    $this->company = $invite->company;

    if (is_null($invite) || ($invite->invitation_type == 'email' && $request->email != $invite->email)) {
        return Reply::error('messages.acceptInviteError');
    }

    DB::beginTransaction();
    try {
        $user = new User();
        $user->name = strtolower(preg_replace('/\s+/', ' ', $request->name));
        $user->company_id = $invite->company_id;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->status = "deactive";
        $user->password = bcrypt($request->password);
        $user->save();
        $user = $user->setAppends([]);

        $lastEmployeeID = EmployeeDetails::where('company_id', $invite->company_id)->count();

        // Collision-safe unique ID
        $nextId = $lastEmployeeID + 1;
        while (EmployeeDetails::where('employee_id', $nextId)
            ->where('company_id', $invite->company_id)
            ->exists()) {
            $nextId++;
        }

        if ($user->id) {
            $employee = new EmployeeDetails();
            $employee->user_id = $user->id;
            $employee->company_id = $invite->company_id;
            $employee->employee_id = $nextId; // ✅ sahi jagah, sahi value

            $employee->joining_date = $request->joining_date ?? now($this->company->timezone)->format('Y-m-d');

            $employee->department_id = !empty($request->department) ? $request->department : null;
            $employee->designation_id = !empty($request->designation) ? $request->designation : null;
            $employee->reporting_to = !empty($request->reporting_to) ? $request->reporting_to : null;
            $employee->date_of_birth = !empty($request->date_of_birth) ? $request->date_of_birth : null;
            $employee->marital_status = $request->marital_status;
            $employee->address = $request->address;
            $employee->added_by = $user->id;
            $employee->last_updated_by = $user->id;
            $employee->save();

            if ($request->filled('salary')) {
                DB::table('custom_fields_data')->insert([
                    'custom_field_id' => 32,
                    'model_id'        => $employee->id,
                    'model'           => 'App\Models\EmployeeDetails',
                    'value'           => $request->salary,
                ]);
            }
        }

        $employeeRole = Role::where('name', 'employee')->where('company_id', $invite->company_id)->first();
        $user->attachRole($employeeRole);

        $rolePermissions = PermissionRole::where('role_id', $employeeRole->id)->get();

        foreach ($rolePermissions as $value) {
            $userPermission = UserPermission::where('permission_id', $value->permission_id)
                ->where('user_id', $user->id)
                ->firstOrNew();
            $userPermission->permission_id = $value->permission_id;
            $userPermission->user_id = $user->id;
            $userPermission->permission_type_id = $value->permission_type_id;
            $userPermission->save();
        }

        $logSearch = new AccountBaseController();
        $logSearch->logSearchEntry($user->id, $user->name, 'employees.show', 'employee');

        if ($invite->invitation_type == 'email') {
            $invite->status = 'inactive';
            $invite->save();
        }

        // Commit Transaction
        DB::commit();

        // Send Notification to all admins about recently added member
        $admins = User::allAdmins($user->company->id);

        foreach ($admins as $admin) {
            event(new NewUserRegistrationViaInviteEvent($admin, $user));
        }

        session()->forget('user');
        Auth::login($user);
        return Reply::success('Signup successful. Email: ' . $request->email . ' Password: ' . $request->password);

    } catch (TransportException $e) {
        DB::rollback();
        return Reply::error('Please configure SMTP details. Visit Settings -> notification setting to set smtp: ' . $e->getMessage(), 'smtp_error');
    } catch (\Exception $e) {
        DB::rollback();
        return Reply::error('Some error occurred when inserting the data. Please try again or contact support: ' . $e->getMessage());
    }

    return view('auth.invitation', $this->data);
}
    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function setupAccount(AccountSetupRequest $request)
    {
        // Update company name
        $setting = Company::firstOrCreate();
        $setting->company_name = $request->company_name;
        $setting->app_name = $request->company_name;
        $setting->timezone = 'Asia/Kolkata';
        $setting->date_picker_format = 'dd-mm-yyyy';
        $setting->moment_format = 'DD-MM-YYYY';
        $setting->rounded_theme = 1;
        $setting->save();

        // Create admin user
        $user = new User();
        $user->name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->company_id = $setting->id;
        $user->save();

        $employee = new EmployeeDetails();
        $employee->user_id = $user->id;
        $employee->employee_id = $user->id;
        $employee->company_id = $setting->id;
        $employee->save();

        $search = new UniversalSearch();
        $search->searchable_id = $user->id;
        $search->title = $user->name;
        $search->route_name = 'employees.show';
        $search->save();

        // Attach roles
        $adminRole = Role::where('company_id', $setting->id)->where('name', 'admin')->first();
        $employeeRole = Role::where('company_id', $setting->id)->where('name', 'employee')->first();
        $user->roles()->attach($adminRole->id);
        $user->roles()->attach($employeeRole->id);

        $allPermissions = Permission::orderBy('id')->get()->pluck('id')->toArray();

        foreach ($allPermissions as $permission) {
            $user->permissionTypes()->attach([$permission => ['permission_type_id' => PermissionType::ALL]]);
        }

        Auth::login($user);

        return Reply::success(__('messages.signupSuccess'));
    }
    
         public function agentRetainer()
                {
                    $this->pageTitle = 'Add Retainer';
                    $this->user = 1;
                
                   
                    return view('agent_retainer_new', $this->data);
                }
                
public function agentRetainerStore(Request $request)
{
    $request->validate([
        'type' => 'required',
        'name' => 'required',
        'mobile' => 'required|unique:agent_retainers,mobile',
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $agentRetainer = new AgentRetainer();

    $agentRetainer->user_id = 1;
    $agentRetainer->type = $request->type;
    $agentRetainer->name = $request->name;
    $agentRetainer->mobile = $request->mobile;
    $agentRetainer->email = $request->email;
    $agentRetainer->address = $request->address;
    $agentRetainer->date_of_birth = $request->date_of_birth;
    $agentRetainer->gender = $request->gender;
    $agentRetainer->marital_status = $request->marital_status;
    $agentRetainer->manager_name = $request->manager_name;
    $agentRetainer->manager_mobile = $request->manager_mobile;
    $agentRetainer->recommended_name = $request->recommended_name;
    $agentRetainer->recommended_mobile = $request->recommended_mobile;

    // PHOTO UPLOAD
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/agent'), $filename);
        $agentRetainer->photo = $filename;
    }

    $agentRetainer->save();

    return redirect()->route('agent_retainer.success');
    
}


}
