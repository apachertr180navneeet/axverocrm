<?php

namespace App\Http\Controllers;

use App\Models\JoiningKit;
use Illuminate\Http\Request;
use App\Http\Controllers\OtpController;
use Barryvdh\DomPDF\Facade\Pdf;

class JoiningKitController extends AccountBaseController
{
    public function getJoiningKit(){
         if (!auth()->check() || in_array('admin', user_roles())) {
        abort(403, 'Unauthorized Access');
    }

        $this->pageTitle = 'Joining Agreement Kit';
        $this->user = user();
        return view('joiningkit',$this->data);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        // OTP CHECK
        if (!OtpController::isVerified($request->email)) {
            return back()->withInput()
                ->withErrors(['email' => 'Please verify your email with OTP']);
        }

        // FILE UPLOAD FUNCTION
        function uploadFile($file) {
            if (!$file) return null;

            $filename = time() . rand(100,999) . '.' . $file->extension();
            $file->move(public_path('upload/joiningkit'), $filename);

            return 'upload/joiningkit/' . $filename;
        }

        // FILES
        $photo1 = uploadFile($request->file('photo1'));
        $photo2 = uploadFile($request->file('photo2'));
        $aadhar_front = uploadFile($request->file('aadhar_front'));
        $aadhar_back  = uploadFile($request->file('aadhar_back'));
        $pan_image = uploadFile($request->file('pan_image'));
        $exp_certificate = uploadFile($request->file('exp_certificate'));
        $relieving_letter = uploadFile($request->file('relieving_letter'));
        $passbook = uploadFile($request->file('passbook'));

        // ================= JSON BUILD =================

        // 10th
        $tenth = [];
        if ($request->tenth_year) {
            foreach ($request->tenth_year as $i => $year) {
                $tenth[] = [
                    'year' => $year,
                    'percentage' => $request->tenth_percentage[$i] ?? null,
                    'board' => $request->tenth_board[$i] ?? null
                ];
            }
        }

        // Graduation
        $graduation = [];
        if ($request->grad_year) {
            foreach ($request->grad_year as $i => $year) {
                $graduation[] = [
                    'degree' => $request->degree[$i] ?? null,
                    'year' => $year,
                    'percentage' => $request->grad_percentage[$i] ?? null,
                    'college' => $request->college[$i] ?? null
                ];
            }
        }

        // Experience
        $experience = [];
        if ($request->company_name) {
            foreach ($request->company_name as $i => $company) {
                $experience[] = [
                    'company' => $company,
                    'designation' => $request->prev_designation[$i] ?? null,
                    'from' => $request->work_from[$i] ?? null,
                    'to' => $request->work_to[$i] ?? null,
                    'ctc' => $request->last_ctc[$i] ?? null,
                    'reason' => $request->leaving_reason[$i] ?? null,
                ];
            }
        }

        // Certificates
        $certificates = [];
        if ($request->hasFile('edu_certificates')) {
            foreach ($request->file('edu_certificates') as $file) {
                $filename = time() . rand(100,999) . '.' . $file->extension();
                $file->move(public_path('upload/joiningkit'), $filename);

                $certificates[] = 'upload/joiningkit/' . $filename;
            }
        }

        // ================= SAVE =================
        JoiningKit::create([
            'designation' => $request->designation,
            'joining_date' => $request->date,

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,

            'email' => $request->email,
            'mobile' => $request->mobile,
            'emergency_mobile' => $request->emergency_mobile,

            'gender' => $request->gender,
            'dob' => $request->dob,
            'marital_status' => $request->marital_status,

            'perm_street' => $request->perm_street,
            'perm_line2' => $request->perm_line2,
            'perm_city' => $request->perm_city,
            'perm_state' => $request->perm_state,
            'perm_zip' => $request->perm_zip,
            'perm_country' => $request->perm_country,

            'curr_street' => $request->curr_street,
            'curr_line2' => $request->curr_line2,
            'curr_city' => $request->curr_city,
            'curr_state' => $request->curr_state,
            'curr_zip' => $request->curr_zip,
            'curr_country' => $request->curr_country,

            'aadhar_number' => $request->aadhar_number,
            'pan_number' => $request->pan_number,

            'photo_full' => $photo1,
            'photo_passport' => $photo2,
            'aadhar_front' => $aadhar_front,
            'aadhar_back' => $aadhar_back,
            'pan_image' => $pan_image,

            'bank_name' => $request->bank_name,
            'acc_holder' => $request->acc_holder,
            'acc_number' => $request->acc_number,
            'ifsc' => $request->ifsc,
            'passbook' => $passbook,

            'exp_type' => $request->exp_type,

                      'tenth_data' => $tenth,
            'graduation_data' => $graduation,
            'experience_data' => $experience,
            'certificates' => $certificates,

            'exp_certificate' => $exp_certificate,
            'relieving_letter' => $relieving_letter,
           'tnc_accepted' => $request->input('tnc_accepted', 0) == 1 ? 1 : 0,
        ]);

        return back()->with('success', 'Form submitted successfully!');
    }

    // ================= LISTING =================
    public function index(Request $request)
    {
         
  
            if (!auth()->check() || !in_array('admin', user_roles())) {
            abort(403, 'Unauthorized Access');
            }
    
    
         $this->pageTitle = 'Joining Kit List'; 
        $query = JoiningKit::query();

        // 🔍 SEARCH (name + mobile)
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('mobile', 'like', "%{$request->search}%");
            });
        }

        // gender filter
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        // date range
        if ($request->from_date) {
            $query->whereDate('joining_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('joining_date', '<=', $request->to_date);
        }

       $kits = $query->latest()->paginate(10);
   return view('joiningkit_list', $this->data, compact('kits'));
    }


    // ================= PDF DOWNLOAD =================
   public function downloadPdf($id)
{
    $kit = JoiningKit::findOrFail($id);

    $fileName = $kit->first_name.'_'.$kit->last_name.'_joiningkit.pdf';

    $pdf = Pdf::loadView('joiningkit_pdf', compact('kit'));

    return $pdf->download($fileName);
}


    // ===== STEP 1 =====
public function storeStep1(Request $request)
{
    // OTP check
    if (!OtpController::isVerified($request->email)) {
        return response()->json(['success' => false, 'message' => 'Please verify your email with OTP']);
    }

    function uploadFile($file) {
        if (!$file) return null;
        $filename = time() . rand(100,999) . '.' . $file->extension();
        $file->move(public_path('upload/joiningkit'), $filename);
        return 'upload/joiningkit/' . $filename;
    }

    $kit = JoiningKit::create([
        'designation'      => $request->designation,
        'joining_date'     => $request->date,
        'first_name'       => $request->first_name,
        'last_name'        => $request->last_name,
        'father_fname'     => $request->f_first_name,
        'father_lname'     => $request->f_last_name,
        'mother_fname'     => $request->m_first_name,
        'mother_lname'     => $request->m_last_name,
        'email'            => $request->email,
        'mobile'           => $request->mobile,
        'emergency_mobile' => $request->emergency_mobile,
        'gender'           => $request->gender,
        'dob'              => $request->dob,
        'marital_status'   => $request->marital_status,
        'perm_street'      => $request->perm_street,
        'perm_line2'       => $request->perm_line2,
        'perm_city'        => $request->perm_city,
        'perm_state'       => $request->perm_state,
        'perm_zip'         => $request->perm_zip,
        'perm_country'     => $request->perm_country,
        'curr_street'      => $request->curr_street,
        'curr_line2'       => $request->curr_line2,
        'curr_city'        => $request->curr_city,
        'curr_state'       => $request->curr_state,
        'curr_zip'         => $request->curr_zip,
        'curr_country'     => $request->curr_country,
        'aadhar_number'    => $request->aadhar_number,
        'pan_number'       => $request->pan_number,
        'photo_full'       => uploadFile($request->file('photo1')),
        'photo_passport'   => uploadFile($request->file('photo2')),
        'aadhar_front'     => uploadFile($request->file('aadhar_front')),
        'aadhar_back'      => uploadFile($request->file('aadhar_back')),
        'pan_image'        => uploadFile($request->file('pan_image')),
    ]);

    // Session mein ID save karo
    session(['joining_kit_id' => $kit->id]);

    return response()->json(['success' => true, 'message' => 'Step 1 saved successfully!']);
}

// ===== STEP 2 =====
public function storeStep2(Request $request)
{
    $id = session('joining_kit_id');
    if (!$id) {
        return response()->json(['success' => false, 'message' => 'Session expired. Please restart.']);
    }

    // 10th data
    $tenth = [];
    if ($request->tenth_year) {
        foreach ($request->tenth_year as $i => $year) {
            $tenth[] = [
                'year'       => $year,
                'percentage' => $request->tenth_percentage[$i] ?? null,
                'type'       => $request->tenth_type[$i] ?? null,
                'board'      => $request->tenth_board[$i] ?? null,
            ];
        }
    }

    // Graduation data
    $graduation = [];
    if ($request->grad_year) {
        foreach ($request->grad_year as $i => $year) {
            $graduation[] = [
                'degree'     => $request->degree[$i] ?? null,
                'year'       => $year,
                'percentage' => $request->grad_percentage[$i] ?? null,
                'type'       => $request->grad_type[$i] ?? null,
                'college'    => $request->college[$i] ?? null,
            ];
        }
    }

    // Certificates
    $certificates = [];
    if ($request->hasFile('edu_certificates')) {
        foreach ($request->file('edu_certificates') as $file) {
            $filename = time() . rand(100,999) . '.' . $file->extension();
            $file->move(public_path('upload/joiningkit'), $filename);
            $certificates[] = 'upload/joiningkit/' . $filename;
        }
    }

    JoiningKit::where('id', $id)->update([
        'tenth_data'      => json_encode($tenth),
        'graduation_data' => json_encode($graduation),
        'certificates'    => json_encode($certificates),
    ]);

    return response()->json(['success' => true, 'message' => 'Step 2 saved successfully!']);
}

// ===== STEP 3 =====
public function storeStep3(Request $request)
{
    $id = session('joining_kit_id');
    if (!$id) {
        return response()->json(['success' => false, 'message' => 'Session expired. Please restart.']);
    }

    function uploadFile2($file) {
        if (!$file) return null;
        $filename = time() . rand(100,999) . '.' . $file->extension();
        $file->move(public_path('upload/joiningkit'), $filename);
        return 'upload/joiningkit/' . $filename;
    }

    $experience = [];
    if ($request->company_name) {
        foreach ($request->company_name as $i => $company) {
            $experience[] = [
                'company'     => $company,
                'designation' => $request->prev_designation[$i] ?? null,
                'from'        => $request->work_from[$i] ?? null,
                'to'          => $request->work_to[$i] ?? null,
                'ctc'         => $request->last_ctc[$i] ?? null,
                'reason'      => $request->leaving_reason[$i] ?? null,
            ];
        }
    }

    JoiningKit::where('id', $id)->update([
        'exp_type'         => $request->exp_type,
        'experience_data'  => json_encode($experience),
        'exp_certificate'  => uploadFile2($request->file('exp_certificate')),
        'relieving_letter' => uploadFile2($request->file('relieving_letter')),
    ]);

    return response()->json(['success' => true, 'message' => 'Step 3 saved successfully!']);
}

// ===== STEP 4 (Final) =====
public function storeStep4(Request $request)
{
    $id = session('joining_kit_id');
    if (!$id) {
        return response()->json(['success' => false, 'message' => 'Session expired. Please restart.']);
    }

    function uploadFile3($file) {
        if (!$file) return null;
        $filename = time() . rand(100,999) . '.' . $file->extension();
        $file->move(public_path('upload/joiningkit'), $filename);
        return 'upload/joiningkit/' . $filename;
    }

    JoiningKit::where('id', $id)->update([
        'bank_name'    => $request->bank_name,
        'acc_holder'   => $request->acc_holder,
        'acc_number'   => $request->acc_number,
        'ifsc'         => $request->ifsc,
        'passbook'     => uploadFile3($request->file('passbook')),
        'tnc_accepted' => $request->input('tnc_accepted', 0) == 1 ? 1 : 0,
    ]);

    // Session clear karo
    session()->forget('joining_kit_id');

    return response()->json(['success' => true, 'message' => 'Profile submitted successfully! ✓']);
}





}