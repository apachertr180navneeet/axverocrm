

<?php $__env->startSection('content'); ?>

<style>
body { background: #171F29; }
.main-card {
    background: linear-gradient(135deg, #1e293b, #1e2a44);
    border-radius: 20px; padding: 40px;
    border: 1px solid #2d3a4b; max-width: 860px; margin: 0 auto;
}
.header-icon {
    width: 70px; height: 70px; border-radius: 20px;
    background: linear-gradient(135deg, #3b82f6, #a855f7);
    display: flex; align-items: center; justify-content: center; margin: auto;
}
.title { font-size: 28px; font-weight: 600; color: #a5b4fc; }
.subtitle { color: #94a3b8; }
.step-text { color: #94a3b8; font-size: 14px; font-weight: 600; }
.progress { height: 6px; background: #2d3a4b; border-radius: 10px; }
.progress-bar { background: linear-gradient(90deg, #3b82f6, #a855f7); transition: width 0.4s ease; border-radius: 10px; }
label { color: #cbd5f5; font-size: 13px; margin-bottom: 4px; display: block; }
.form-control {
    background: #0B1220; border: 1px solid #2d3a4b; border-radius: 10px;
    height: 48px; color: #fff; padding: 0 14px; width: 100%; font-size: 14px;
}
select.form-control { appearance: auto; cursor: pointer; }
.form-control:focus {
    border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    background: #0B1220; color: #fff; outline: none;
}
.form-control::placeholder { color: #4b5a6e; }
.section-line { border-top: 1px solid #2d3a4b; margin: 28px 0; }
.file-box {
    border: 1px dashed #334155; border-radius: 12px; padding: 10px 14px;
    display: flex; align-items: center; gap: 12px; background: #0B1220;
}
.file-btn {
    background: #1e3a5f; border: 1px solid #3b82f6; padding: 7px 16px;
    border-radius: 8px; color: #60a5fa; font-size: 13px; cursor: pointer; white-space: nowrap;
}
.file-btn:hover { background: #1d4ed8; color: #fff; }
.file-text { color: #94a3b8; font-size: 13px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.drag-drop-box {
    border: 2px dashed #334155; border-radius: 14px; padding: 36px 20px;
    text-align: center; background: #0B1220; cursor: pointer; transition: border-color 0.2s;
}
.drag-drop-box:hover, .drag-drop-box.dragover { border-color: #3b82f6; }
.drag-drop-box i { font-size: 30px; color: #4b6a88; }
.drag-drop-box .dd-title { color: #cbd5f5; font-size: 14px; margin-top: 10px; }
.drag-drop-box .dd-sub { color: #4b5a6e; font-size: 12px; }
.edu-row {
    background: #0f1929; border: 1px solid #2d3a4b; border-radius: 14px;
    padding: 16px; margin-bottom: 12px;
}
.edu-row-header { display: flex; justify-content: flex-end; margin-bottom: 10px; }
.edu-row .remove-btn {
    background: #7f1d1d; border: none; border-radius: 6px;
    color: #fca5a5; padding: 4px 12px; font-size: 12px; cursor: pointer;
}
.edu-row .remove-btn:hover { background: #991b1b; }
.btn-add {
    background: transparent; border: 1px dashed #3b82f6; color: #60a5fa;
    border-radius: 10px; padding: 8px 18px; font-size: 13px; cursor: pointer;
}
.btn-add:hover { background: rgba(59,130,246,0.1); }
.sec-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.radio-group { display: flex; gap: 28px; flex-wrap: wrap; }
.radio-option { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.radio-option input[type="radio"] { width: 20px; height: 20px; accent-color: #3b82f6; cursor: pointer; }
.radio-option span { color: #e2e8f0; font-size: 15px; }
.btn-next {
    background: #3b82f6; border-radius: 10px; padding: 11px 28px;
    border: none; color: #fff; font-size: 15px; font-weight: 500; cursor: pointer;
}
.btn-next:hover { background: #2563eb; }
.btn-next:disabled { background: #334155; cursor: not-allowed; }
.btn-prev {
    background: transparent; border: 1px solid #334155; border-radius: 10px;
    padding: 11px 24px; color: #94a3b8; font-size: 15px; cursor: pointer;
}
.btn-prev:hover { background: #1e293b; color: #fff; }
.btn-submit {
    background: #22c55e; border-radius: 10px; padding: 11px 28px;
    border: none; color: #fff; font-size: 15px; font-weight: 500; cursor: pointer;
}
.btn-submit:hover { background: #16a34a; }
.btn-submit:disabled { background: #334155; cursor: not-allowed; }
.tnc-box {
    background: #0B1220; border: 1px solid #2d3a4b; border-radius: 14px;
    padding: 20px; max-height: 260px; overflow-y: auto;
    font-size: 13px; color: #94a3b8; line-height: 1.7; margin-bottom: 16px;
}
.tnc-box::-webkit-scrollbar { width: 5px; }
.tnc-box::-webkit-scrollbar-track { background: #1e293b; }
.tnc-box::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 4px; }
.tnc-check-box {
    background: #0f1929; border: 1px solid #2d3a4b; border-radius: 12px;
    padding: 14px 18px; display: flex; align-items: center; gap: 12px;
}
.tnc-check-box input[type="checkbox"] { width: 18px; height: 18px; accent-color: #3b82f6; cursor: pointer; }
.tnc-check-box label { color: #e2e8f0; font-size: 14px; margin: 0; cursor: pointer; }
.step-indicators { display: flex; justify-content: center; gap: 8px; margin-bottom: 28px; }
.step-dot {
    width: 30px; height: 30px; border-radius: 50%; background: #2d3a4b; color: #94a3b8;
    display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; transition: all 0.3s;
}
.step-dot.active { background: linear-gradient(135deg, #3b82f6, #a855f7); color: #fff; }
.step-dot.done { background: #22c55e; color: #fff; }
.step-connector { width: 36px; height: 2px; background: #2d3a4b; align-self: center; }
input[type="date"] { cursor: pointer; color-scheme: dark; }
.cert-previews { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.cert-tag {
    background: #1e3a5f; border: 1px solid #3b82f6; border-radius: 8px;
    padding: 5px 10px; color: #93c5fd; font-size: 12px; display: flex; align-items: center; gap: 6px;
}
.cert-tag button { background: none; border: none; color: #f87171; cursor: pointer; padding: 0; font-size: 13px; }

/* Saving overlay */
.saving-overlay {
    position: fixed; inset: 0; background: rgba(11,18,32,0.75);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    z-index: 99999; backdrop-filter: blur(4px);
}
.saving-spinner {
    width: 54px; height: 54px; border-radius: 50%;
    border: 4px solid #2d3a4b; border-top-color: #3b82f6;
    animation: spin 0.8s linear infinite; margin-bottom: 16px;
}
@keyframes spin { to { transform: rotate(360deg); } }
.saving-text { color: #a5b4fc; font-size: 16px; font-weight: 600; }
</style>

<div class="container-fluid px-2 py-4">
<div class="main-card" id="mainCard">

    <div class="text-center mb-5">
        <div class="header-icon mb-3"><i class="bi bi-briefcase text-white fs-4"></i></div>
        <div class="title">Joining Agreement Kit</div>
        <div class="subtitle">Complete your onboarding profile securely.</div>
    </div>

    <div class="step-indicators">
        <div class="step-dot active" id="dot1">1</div>
        <div class="step-connector"></div>
        <div class="step-dot" id="dot2">2</div>
        <div class="step-connector"></div>
        <div class="step-dot" id="dot3">3</div>
        <div class="step-connector"></div>
        <div class="step-dot" id="dot4">4</div>
    </div>

    <div class="mb-4">
        <div class="d-flex justify-content-between step-text">
            <span id="stepLabel">Step 1 of 4: Personal Details</span>
            <span id="stepPercent">25%</span>
        </div>
        <div class="progress mt-2">
            <div class="progress-bar" id="progressBar" style="width:25%"></div>
        </div>
    </div>

    
    <form id="mainForm" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <!-- ===== STEP 1 ===== -->
    <div id="step1">
        <h5 class="text-light mb-4"><i class="bi bi-person me-2"></i> Part 1: Personal Details</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label>Designation *</label>
                <input name="designation" class="form-control s1req" placeholder="Enter designation">
            </div>
            <div class="col-md-6">
                <label>Date *</label>
                <input type="date" name="date" class="form-control s1req" onclick="this.showPicker()">
            </div>
            <div class="col-md-6">
                <label>Full Size Photograph *</label>
                <div class="file-box" id="box_file1">
                    <button type="button" class="file-btn" onclick="document.getElementById('file1').click()">Choose File</button>
                    <span id="file1Name" class="file-text">No file chosen</span>
                    <input type="file" id="file1" name="photo1" hidden onchange="updateFile(this,'file1Name','box_file1')" class="s1req_file" accept="image/*">
                </div>
            </div>
            <div class="col-md-6">
                <label>Passport Size Photograph *</label>
                <div class="file-box" id="box_file2">
                    <button type="button" class="file-btn" onclick="document.getElementById('file2').click()">Choose File</button>
                    <span id="file2Name" class="file-text">No file chosen</span>
                    <input type="file" id="file2" name="photo2" hidden onchange="updateFile(this,'file2Name','box_file2')" class="s1req_file" accept="image/*">
                </div>
            </div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Full Name *</h6>
        <div class="row g-3">
            <div class="col-md-6"><input name="first_name" class="form-control s1req" placeholder="First Name"></div>
            <div class="col-md-6"><input name="last_name" class="form-control" placeholder="Last Name"></div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Father's Name</h6>
        <div class="row g-3">
            <div class="col-md-6"><input class="form-control" placeholder="First Name" name="f_first_name"></div>
            <div class="col-md-6"><input class="form-control" placeholder="Last Name" name="f_last_name"></div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Mother's Name</h6>
        <div class="row g-3">
            <div class="col-md-6"><input class="form-control" placeholder="First Name" name="m_first_name"></div>
            <div class="col-md-6"><input class="form-control" placeholder="Last Name" name="m_last_name"></div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Contact Details</h6>
        <div class="row g-3">

            <div class="col-12">
                <label>Email *
                    <span id="emailVerifiedBadge" style="display:none;background:#166534;color:#86efac;font-size:11px;padding:2px 10px;border-radius:20px;margin-left:8px;">&#10003; Verified</span>
                </label>
                <div class="d-flex gap-2">
                    <input type="email" name="email" id="emailField" class="form-control" placeholder="Enter your email" autocomplete="off">
                    <button type="button" id="sendOtpBtn" onclick="sendOtp()"
                            style="white-space:nowrap;background:#3b82f6;border:none;border-radius:10px;padding:0 20px;color:#fff;font-size:13px;font-weight:600;cursor:pointer;min-width:120px;">
                        Send OTP
                    </button>
                </div>
                <div id="emailMsg" style="font-size:12px;margin-top:5px;display:none;"></div>
            </div>

            <div class="col-12" id="otpBox" style="display:none;">
                <label>Enter OTP * <span style="color:#f59e0b;font-size:12px;" id="otpTimer"></span></label>
                <div class="d-flex gap-2">
                    <input type="text" id="otpField" name="otp" class="form-control"
                           placeholder="Enter 6-digit OTP" maxlength="6"
                           oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                           style="letter-spacing:6px;font-size:18px;font-weight:700;text-align:center;">
                    <button type="button" id="verifyOtpBtn" onclick="verifyOtp()"
                            style="white-space:nowrap;background:#22c55e;border:none;border-radius:10px;padding:0 20px;color:#fff;font-size:13px;font-weight:600;cursor:pointer;min-width:120px;">
                        Verify OTP
                    </button>
                </div>
                <div style="margin-top:8px;display:flex;align-items:center;gap:14px;">
                    <span id="otpMsg" style="font-size:12px;"></span>
                    <button type="button" id="resendBtn" onclick="resendOtp()"
                            style="display:none;background:none;border:none;color:#60a5fa;font-size:12px;cursor:pointer;text-decoration:underline;padding:0;">
                        Resend OTP
                    </button>
                </div>
            </div>

            <div class="col-md-6">
                <label>Mobile Number *</label>
                <input type="text" name="mobile" class="form-control s1req" placeholder="Enter mobile" maxlength="10">
            </div>
            <div class="col-md-6">
                <label>Emergency Contact Number *</label>
                <input type="text" name="emergency_mobile" class="form-control s1req" placeholder="Enter emergency number" maxlength="10">
            </div>
            <div class="col-md-6">
                <label>Gender *</label>
                <select name="gender" class="form-control s1req">
                    <option value="">Select Gender</option>
                    <option>Male</option><option>Female</option><option>Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date of Birth *</label>
                <input type="date" name="dob" class="form-control s1req" onclick="this.showPicker()">
            </div>
            <div class="col-md-6">
                <label>Marital Status *</label>
                <select name="marital_status" class="form-control s1req">
                    <option value="">Select Status</option>
                    <option>Single</option><option>Married</option><option>Divorced</option><option>Widowed</option>
                </select>
            </div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Permanent Address *</h6>
        <div class="row g-3">
            <div class="col-12"><label>Street Address</label><input name="perm_street" class="form-control s1req" placeholder="Street Address"></div>
            <div class="col-12"><label>Address Line 2</label><input name="perm_line2" class="form-control" placeholder="Apartment, suite, etc."></div>
            <div class="col-md-6"><label>City</label><input name="perm_city" class="form-control s1req" placeholder="City"></div>
            <div class="col-md-6"><label>State / Province</label><input name="perm_state" class="form-control s1req" placeholder="State"></div>
            <div class="col-md-6"><label>ZIP / Postal Code</label><input name="perm_zip" class="form-control s1req" placeholder="ZIP Code"></div>
            <div class="col-md-6"><label>Country</label><input name="perm_country" class="form-control s1req" placeholder="Country" value="India"></div>
        </div>

        <div class="section-line"></div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-light mb-0">Current Address *</h6>
            <div>
                <input type="checkbox" id="sameAddress" onchange="copyAddress(this)">
                <label for="sameAddress" class="small text-secondary ms-1" style="display:inline;">Same as Permanent Address</label>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-12"><label>Street Address</label><input name="curr_street" id="curr_street" class="form-control s1req" placeholder="Street Address"></div>
            <div class="col-12"><label>Address Line 2</label><input name="curr_line2" id="curr_line2" class="form-control" placeholder="Apartment, suite, etc."></div>
            <div class="col-md-6"><label>City</label><input name="curr_city" id="curr_city" class="form-control s1req" placeholder="City"></div>
            <div class="col-md-6"><label>State / Province</label><input name="curr_state" id="curr_state" class="form-control s1req" placeholder="State"></div>
            <div class="col-md-6"><label>ZIP / Postal Code</label><input name="curr_zip" id="curr_zip" class="form-control s1req" placeholder="ZIP Code"></div>
            <div class="col-md-6"><label>Country</label><input name="curr_country" id="curr_country" class="form-control s1req" placeholder="Country"></div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Aadhar Verification</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label>Aadhar Number *</label>
                <input name="aadhar_number" class="form-control s1req" placeholder="XXXX XXXX XXXX" maxlength="14">
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <label>Aadhar Front Side * <small class="text-secondary">(Max 5MB)</small></label>
                <div class="file-box" id="box_aadharFront">
                    <button type="button" class="file-btn" onclick="document.getElementById('aadharFront').click()">Choose File</button>
                    <span id="aadharFrontText" class="file-text">No file chosen</span>
                    <input type="file" id="aadharFront" name="aadhar_front" hidden onchange="updateFile(this,'aadharFrontText','box_aadharFront')" class="s1req_file" accept="image/*,.pdf">
                </div>
            </div>
            <div class="col-md-6">
                <label>Aadhar Back Side * <small class="text-secondary">(Max 5MB)</small></label>
                <div class="file-box" id="box_aadharBack">
                    <button type="button" class="file-btn" onclick="document.getElementById('aadharBack').click()">Choose File</button>
                    <span id="aadharBackText" class="file-text">No file chosen</span>
                    <input type="file" id="aadharBack" name="aadhar_back" hidden onchange="updateFile(this,'aadharBackText','box_aadharBack')" class="s1req_file" accept="image/*,.pdf">
                </div>
            </div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">PAN Verification</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label>PAN Card Number *</label>
                <input name="pan_number" class="form-control s1req" placeholder="ABCDE1234F" maxlength="10" style="text-transform:uppercase">
            </div>
            <div class="col-md-6">
                <label>PAN Card Image *</label>
                <div class="file-box" id="box_panFile">
                    <button type="button" class="file-btn" onclick="document.getElementById('panFile').click()">Choose File</button>
                    <span id="panText" class="file-text">No file chosen</span>
                    <input type="file" id="panFile" name="pan_image" hidden onchange="updateFile(this,'panText','box_panFile')" class="s1req_file" accept="image/*,.pdf">
                </div>
            </div>
        </div>

        <div class="section-line"></div>
        <div class="text-end">
            <button type="button" class="btn-next" id="nextBtn1" onclick="nextStep(this)">Next &rarr;</button>
        </div>
    </div><!-- /step1 -->


    <!-- ===== STEP 2 ===== -->
    <div id="step2" style="display:none;">
        <h5 class="text-light mb-4">&#127891; Part 2: Education Details</h5>

        <div class="sec-header">
            <h6 class="text-light mb-0">10th Class Details (Required)</h6>
            <button type="button" class="btn-add" onclick="addEduRow('tenth')">+ Add</button>
        </div>
        <div id="tenthRows">
            <div class="edu-row">
                <div class="row g-3">
                    <div class="col-md-3"><label>Passing Year *</label><input name="tenth_year[]" class="form-control s2req" placeholder="e.g. 2015"></div>
                    <div class="col-md-3"><label>Percentage *</label><input name="tenth_percentage[]" class="form-control s2req" placeholder="e.g. 85%"></div>
                    <div class="col-md-3"><label>Regular/Private *</label>
                        <select name="tenth_type[]" class="form-control s2req">
                            <option value="">Select</option><option>Regular</option><option>Private</option>
                        </select>
                    </div>
                    <div class="col-md-3"><label>Board Name *</label><input name="tenth_board[]" class="form-control s2req" placeholder="e.g. CBSE"></div>
                </div>
            </div>
        </div>

        <div class="section-line"></div>

        <div class="sec-header">
            <h6 class="text-light mb-0">Highest Qualification Details (Required)</h6>
            <button type="button" class="btn-add" onclick="addEduRow('highest')">+ Add</button>
        </div>
        <div id="highestRows">
            <div class="edu-row">
                <div class="row g-3">
                    <div class="col-md-3"><label>Degree *</label><input name="degree[]" class="form-control s2req" placeholder="BA/B.com/BSc..."></div>
                    <div class="col-md-3"><label>Passing Year *</label><input name="grad_year[]" class="form-control s2req" placeholder="e.g. 2021"></div>
                    <div class="col-md-3"><label>Percentage *</label><input name="grad_percentage[]" class="form-control s2req" placeholder="e.g. 75%"></div>
                    <div class="col-md-3"><label>Regular/Private *</label>
                        <select name="grad_type[]" class="form-control s2req">
                            <option value="">Select</option><option>Regular</option><option>Private</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2"><label>University/College Name *</label><input name="college[]" class="form-control s2req" placeholder="College / University Name"></div>
                </div>
            </div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">Upload Educational Certificates (Images Only)</h6>
        <div class="drag-drop-box" id="certDropZone"
             onclick="document.getElementById('certFiles').click()"
             ondragover="dragOver(event,'certDropZone')"
             ondragleave="dragLeave(event,'certDropZone')"
             ondrop="dropFiles(event,'certDropZone','certFiles','certPreviews')">
            <i class="bi bi-cloud-arrow-up"></i>
            <div class="dd-title">Click to upload or drag and drop</div>
            <div class="dd-sub">Max: 5MB per file</div>
        </div>
        <input type="file" id="certFiles" name="edu_certificates[]" multiple hidden accept="image/*,.pdf" onchange="showFileTags(this,'certPreviews')">
        <div class="cert-previews" id="certPreviews"></div>

        <div class="section-line"></div>
        <div class="d-flex justify-content-between">
            
            <button type="button" class="btn-prev" id="prevBtn2" onclick="prevStep()">&larr; Previous</button>
            <button type="button" class="btn-next" id="nextBtn2" onclick="nextStep(this)">Next &rarr;</button>
        </div>
    </div><!-- /step2 -->


    <!-- ===== STEP 3 ===== -->
    <div id="step3" style="display:none;">
        <h5 class="text-light mb-4">&#127970; Part 3: Experience Details</h5>
        <div class="mb-4">
            <label class="text-light mb-3" style="font-size:15px;">Are you Fresher or Experienced? (Required)</label>
            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="exp_type" value="Fresher" id="radioFresher" checked onchange="toggleExpFields()">
                    <span>Fresher</span>
                </label>
                <label class="radio-option">
                    <input type="radio" name="exp_type" value="Experienced" id="radioExp" onchange="toggleExpFields()">
                    <span>Experienced</span>
                </label>
            </div>
        </div>
        <div id="expFields" style="display:none;">
            <div class="section-line"></div>
            <div class="sec-header">
                <h6 class="text-light mb-0">Previous Employment Details</h6>
                <button type="button" class="btn-add" onclick="addExpRow()">+ Add More</button>
            </div>
            <div id="expRows">
                <div class="edu-row">
                    <div class="row g-3">
                        <div class="col-md-6"><label>Company Name *</label><input name="company_name[]" class="form-control exp_req" placeholder="Previous company"></div>
                        <div class="col-md-6"><label>Designation *</label><input name="prev_designation[]" class="form-control exp_req" placeholder="Your role"></div>
                        <div class="col-md-6"><label>From Date *</label><input type="date" name="work_from[]" class="form-control exp_req" onclick="this.showPicker()"></div>
                        <div class="col-md-6"><label>To Date *</label><input type="date" name="work_to[]" class="form-control exp_req" onclick="this.showPicker()"></div>
                        <div class="col-md-6"><label>Last CTC (per annum)</label><input name="last_ctc[]" class="form-control" placeholder="e.g. 4,00,000"></div>
                        <div class="col-md-6"><label>Reason for Leaving</label><input name="leaving_reason[]" class="form-control" placeholder="Reason"></div>
                    </div>
                </div>
            </div>
            <div class="section-line"></div>
            <h6 class="text-light mb-3">Experience Documents</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Experience Certificate <small class="text-secondary">(Max 5MB)</small></label>
                    <div class="file-box" id="box_expCert">
                        <button type="button" class="file-btn" onclick="document.getElementById('expCert').click()">Choose File</button>
                        <span id="expCertText" class="file-text">No file chosen</span>
                        <input type="file" id="expCert" name="exp_certificate" hidden onchange="updateFile(this,'expCertText','box_expCert')" accept=".pdf,image/*">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Relieving Letter <small class="text-secondary">(Max 5MB)</small></label>
                    <div class="file-box" id="box_relieving">
                        <button type="button" class="file-btn" onclick="document.getElementById('relieving').click()">Choose File</button>
                        <span id="relievingText" class="file-text">No file chosen</span>
                        <input type="file" id="relieving" name="relieving_letter" hidden onchange="updateFile(this,'relievingText','box_relieving')" accept=".pdf,image/*">
                    </div>
                </div>
            </div>
        </div>
        <div class="section-line"></div>
        <div class="d-flex justify-content-between">
            
            <button type="button" class="btn-prev" id="prevBtn3" onclick="prevStep()">&larr; Previous</button>
            <button type="button" class="btn-next" id="nextBtn3" onclick="nextStep(this)">Next &rarr;</button>
        </div>
    </div><!-- /step3 -->


    <!-- ===== STEP 4 ===== -->
    <div id="step4" style="display:none;">
        <h5 class="text-light mb-4">&#127974; Bank Details</h5>
        <div class="row g-3">
            <div class="col-12"><label>Bank Name *</label><input name="bank_name" class="form-control s4req" placeholder="e.g. HDFC Bank"></div>
            <div class="col-12"><label>Account Holder Name *</label><input name="acc_holder" class="form-control s4req" placeholder="As per bank records"></div>
            <div class="col-md-6"><label>Account Number *</label><input name="acc_number" class="form-control s4req" placeholder="Account number"></div>
            <div class="col-md-6"><label>IFSC Code *</label><input name="ifsc" class="form-control s4req" placeholder="e.g. HDFC0001234" style="text-transform:uppercase"></div>
            <div class="col-12">
                <label>Cancelled Cheque / Passbook Front *</label>
                <div class="file-box" id="box_passbook">
                    <button type="button" class="file-btn" onclick="document.getElementById('passbookFile').click()">Choose File</button>
                    <span id="passbookText" class="file-text">No file chosen</span>
                    <input type="file" id="passbookFile" name="passbook" hidden onchange="updateFile(this,'passbookText','box_passbook')" class="s4req_file" accept="image/*,.pdf">
                </div>
            </div>
        </div>

        <div class="section-line"></div>
        <h6 class="text-light mb-3">&#128196; Terms &amp; Conditions (Required)</h6>
        <div class="tnc-box">
            <p class="text-light fw-semibold mb-2 text-center">We are pleased to welcome you to EASY ONLINE MARKETING COMPANY.</p>
            <p>The following retainer Terms and Conditions govern. You are requested to carefully read the following terms and conditions and provide your acceptance.</p>
            <p>During the probationary period, your engagement with the Company shall be governed by the retainer terms of this Agreement, and the applicable remuneration, rights, and benefits shall be as expressly set out herein.</p>
            <p>You are hereby appointed as a Retainer &amp; Department &amp; Recruiter Like HR Executive, HR Manager Trainer &amp; Retainer Sales &amp; Marketing, hereinafter referred to as the "Candidate" for a probationary period of six (6) months on a retainer basis. Upon completion of this period, and subject to your performance being found satisfactory, you may be eligible to apply for confirmation as a permanent employee of the Company, at the Company's sole discretion.</p>
            <p>Until the completion of the six-month period, you shall continue to work strictly as a Contract Candidate. During the probation period, you shall be entitled only to a Income Amount as agreed, and no other employee benefits shall be applicable.</p>

            <p class="text-light fw-semibold mt-3 mb-1">1. Joining Formalities</p>
            <p>1.1 Acceptance of the offer and completion of all joining formalities by the candidate shall commence from the date of issuance of the offer letter. In the event the offer is not accepted within three (3) days thereof, the offer shall stand automatically withdrawn without further notice.</p>
            <p>1.2 The candidate shall be required to attend all daily scheduled meetings and report directly to the reporting person assigned by the Company.</p>

            <p class="text-light fw-semibold mt-3 mb-1">2. Place of Posting</p>
            <p>You may be assigned to work at any location in India and at any place of business owned, operated, or subsequently acquired by the Company, as per business requirements.</p>

            <p class="text-light fw-semibold mt-3 mb-1">3. Attendance and Work Reporting Policy</p>
            <p>3.1 The Company's standard working hours shall be from 9:00 a.m. to 6:00 p.m., or such other hours as may be prescribed by the Company from time to time based on business requirements.</p>
            <p>3.2 For the limited purpose of work tracking, monitoring, and reporting, the candidate shall record attendance by clocking in between 9:00 a.m. and 10:00 a.m. and clocking out between 6:00 p.m. and 6:30 p.m.</p>
            <p>3.3 Failure to record a clock-out by 6:30 p.m. shall be deemed as absence for the relevant working day, unless otherwise approved in writing by the reporting authority.</p>
            <p>3.4 Clock-in after 10:00 a.m. shall be treated as a half-day leave.</p>
            <p>3.5 Clock-in after 11:00 a.m. shall be treated as a full-day leave.</p>
            <p>3.6 In the event the candidate records a clock-in but fails to record a corresponding clock-out, such day shall be marked as absent, unless an explanation is provided and accepted in writing by the Company.</p>
            <p>3.7 Any request for half-day leave, full-day leave, or absence due to emergency must be communicated to the designated reporting authority in writing and in advance, or at the earliest possible opportunity in case of an emergency.</p>

            <p class="text-light fw-semibold mt-3 mb-1">4. Monthly Income Payment Terms</p>
            <p>4.1 The candidate shall complete a minimum of fifteen (15) working days in a calendar month to be eligible for payment of the fixed retainer fee for that month.</p>
            <p>4.2 In the event the candidate disengages from the Company, or the engagement is terminated by the Company, prior to completion of fifteen (15) working days in a calendar month, the candidate shall not be entitled to receive any retainer fee or payment for the services rendered during such period.</p>
            <p>4.3 The Income shall be credited to the designated bank account on or before the 10th day of the succeeding month. The Company shall not be liable for delays caused due to bank holidays, strikes, technical issues, or other circumstances beyond the Company's reasonable control.</p>

            <p class="text-light fw-semibold mt-3 mb-1">5. Leave and Holidays</p>
            <p>5.1 The candidate shall not be entitled to any casual leave.</p>
            <p>5.2 The candidate shall not be entitled to any paid sick leave. Any absence on account of illness shall be treated as unpaid leave.</p>
            <p>5.3 The Company shall, from time to time, communicate in advance the list of declared holidays, if any, applicable for work planning purposes.</p>

            <p class="text-light fw-semibold mt-3 mb-1">6. Company Property</p>
            <p>The candidate shall at all times maintain in good condition any property, equipment, documents, or materials belonging to the Company that may be entrusted for official use during the course of engagement. All such property shall be returned to the Company upon cessation of engagement or upon request by the Company. Failure to return Company property may result in the cost of such property being recovered from the candidate.</p>

            <p class="text-light fw-semibold mt-3 mb-1">7. Borrowing and Acceptance of Gifts</p>
            <p>The candidate shall not borrow money from, accept gifts, rewards, or any form of personal compensation from, or place themselves under any pecuniary obligation to, any person, client, or entity with whom they have official dealings in the course of their engagement with the Company.</p>

            <p class="text-light fw-semibold mt-3 mb-1">8. Termination</p>
            <p class="text-secondary fw-semibold mb-1">8.1 Termination by the Company</p>
            <p>The Company may terminate the engagement of the candidate, without assigning any reason, by providing not less than one (1) day's prior written notice, or payment in lieu thereof.</p>
            <p class="text-secondary fw-semibold mb-1">8.2 Termination by the Candidate</p>
            <p>The candidate may terminate their engagement without cause by providing not less than one (1) day's prior written notice, or pro-rated payment in lieu of notice, after adjusting for any pending leaves, if applicable.</p>
            <p class="text-secondary fw-semibold mb-1">8.3 Termination for Misconduct or Breach</p>
            <p>The Company reserves the right to terminate the engagement summarily without notice or payment, if there are reasonable grounds to believe that the candidate has engaged in misconduct, negligence, fundamental breach of contract, or caused loss or damage to the Company.</p>
            <p class="text-secondary fw-semibold mb-1">8.4 Return of Company Property</p>
            <p>Upon termination of the engagement, for any reason, the candidate shall return all Company property, documents, records, samples, literature, contracts, data, drawings, blueprints, letters, notes, and any confidential information, whether original or copies, in their possession or under their control.</p>
            <p>8.5 The Company reserves the right to cancel the engagement at any time by providing one (1) day's prior notice.</p>
            <p class="text-secondary fw-semibold mb-1">8.6 Final Settlement</p>
            <p>The full and final settlement of any dues, including pro-rated retainer fees, shall be completed within 45 to 90 working days following the termination of engagement.</p>

            <p class="text-light fw-semibold mt-3 mb-1">9. Confidential Information</p>
            <p class="text-secondary fw-semibold mb-1">9.1 Exclusivity of Engagement</p>
            <p>During the period of engagement, the candidate shall devote their time, attention, and skill to the Company's business to the best of their ability. The candidate shall not, directly or indirectly, engage, associate, or be connected with any other business, employment, post, or activity, whether part-time or full-time, nor pursue any course of study or professional activity, without the prior written consent of the Company.</p>
            <p class="text-secondary fw-semibold mb-1">9.2 Confidentiality Obligations</p>
            <p>The candidate shall at all times maintain the highest degree of confidentiality and shall keep confidential all records, documents, and other information relating to the business of the Company which may be disclosed or become known to them during the course of engagement. Such information shall be used solely in a duly authorized manner and in the interest of the Company.</p>
            <p>For the purposes of this clause, "Confidential Information" includes, but is not limited to, information relating to the Company's business operations, customer lists, employment policies, personnel data, products, processes, concepts, projections, technology, manuals, drawings, designs, specifications, contracts, records, and any other information not generally available to the public.</p>
            <p class="text-secondary fw-semibold mb-1">9.3 Restrictions on Removal</p>
            <p>The candidate shall not remove any Confidential Information from the Company's premises without prior written permission.</p>
            <p class="text-secondary fw-semibold mb-1">9.4 Survival of Obligations</p>
            <p>The obligations under this clause shall survive the termination or expiration of the engagement, regardless of the reason for cessation.</p>
            <p class="text-secondary fw-semibold mb-1">9.5 Remedies for Breach</p>
            <p>Any breach of this clause may result in summary termination of engagement in accordance with Clause 8, in addition to any other legal or equitable remedies available to the Company.</p>

            <p class="text-light fw-semibold mt-3 mb-1">10. Notices</p>
            <p class="text-secondary fw-semibold mb-1">10.1 Notices to the Company</p>
            <p>All notices or communications by the candidate to the Company shall be sent to the Company's registered office address, unless otherwise specified in writing.</p>
            <p class="text-secondary fw-semibold mb-1">10.2 Notices to the Candidate</p>
            <p>All notices or communications by the Company to the candidate shall be sent to the address provided by the candidate in the Company's official records, unless otherwise updated in writing.</p>
            <p class="text-secondary fw-semibold mb-1">10.3 Mode of Delivery</p>
            <p>Notices may be delivered by hand, registered post, courier, or electronic communication (info@eomshopping.com), and shall be deemed to have been received on the date of delivery if delivered by hand, or three (3) business days after dispatch if sent by post/courier, or on the date of sending if sent by email.</p>

            <p class="text-light fw-semibold mt-3 mb-1">11. Applicability of Company Policy</p>
            <p>The Company reserves the right to issue, revise, or amend policies from time to time concerning matters such as working hours, leave entitlements, benefits, transfers, and other operational or administrative matters. All such policies, amendments, or directives shall be binding on the candidate, and to the extent of any inconsistency, shall prevail over the terms of this Agreement.</p>

            <p class="text-light fw-semibold mt-3 mb-1">12. Termination for Misconduct or Misrepresentation</p>
            <p class="text-secondary fw-semibold mb-1">12.1 Non-Performance and Misconduct</p>
            <p>If the candidate fails to perform the assigned work, fails to maintain attendance as required, or is found to be engaged in activities detrimental to the Company, the Company reserves the right to immediately terminate the engagement. In such cases, the candidate shall forfeit any entitlement to payment or fees for the period of engagement.</p>
            <p class="text-secondary fw-semibold mb-1">12.2 Misrepresentation</p>
            <p>The candidate warrants that all information provided to the Company during the onboarding process is complete and accurate. In the event any information is found to be false, misleading, or incorrect, the Company shall have the right to cancel the engagement immediately, and the candidate shall not be entitled to receive any payment or Amount.</p>

            <p class="text-light fw-semibold mt-3 mb-1">13. Modification of Terms</p>
            <p>The Company reserves the right to amend, modify, or update the terms and conditions of this engagement at any time, based on business requirements, market conditions, or operational needs. The candidate agrees to abide by and accept any such changes upon notification by the Company.</p>

            <p class="text-light fw-semibold mt-3 mb-1">14. Governing Law and Jurisdiction</p>
            <p>14.1 During the probationary period, your engagement with the Company shall be governed by the retainer terms of this Agreement, and the applicable remuneration, rights, and benefits shall be as expressly set out herein.</p>
            <p>14.2 This engagement shall be governed by and construed in accordance with the laws of India. Any disputes, differences, or claims arising out of or in connection with this engagement shall be subject to the exclusive jurisdiction of the courts of Delhi.</p>
            <p>14.3 The Company reserves the right to amend or modify the terms and conditions of this engagement at any time in accordance with business requirements or market conditions, and the candidate agrees to abide by such changes upon notification.</p>
        </div>

        <div class="tnc-check-box">
            <input type="checkbox" id="tncCheck" name="tnc_accepted" value="1">
            <label for="tncCheck">I confirm that I have read and accepted the terms and conditions.</label>
        </div>

        <div class="section-line"></div>
        <div class="d-flex justify-content-between">
            
            <button type="button" class="btn-prev" id="prevBtn4" onclick="prevStep()">&larr; Previous</button>
            <button type="button" class="btn-submit" id="nextBtn4" onclick="finalSubmit(this)">Submit Profile &#10003;</button>
        </div>
    </div><!-- /step4 -->

    </form>
</div><!-- /main-card -->
</div><!-- /container -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// ─────────────────────────────────────────────────────────
// GLOBALS
// ─────────────────────────────────────────────────────────
var currentStep   = 1;
var emailVerified = false;
var otpTimerInt   = null;
var otpSeconds    = 600;

// Step ke AJAX routes
var stepRoutes = {
    1: '<?php echo e(route("joiningkit.step1")); ?>',
    2: '<?php echo e(route("joiningkit.step2")); ?>',
    3: '<?php echo e(route("joiningkit.step3")); ?>',
    4: '<?php echo e(route("joiningkit.step4")); ?>',
};

var stepLabels = [
    'Step 1 of 4: Personal Details',
    'Step 2 of 4: Education Details',
    'Step 3 of 4: Experience Details',
    'Step 4 of 4: Bank Details'
];
var stepPercents = [25, 50, 75, 100];

// ─────────────────────────────────────────────────────────
// STEP UI UPDATE
// ─────────────────────────────────────────────────────────
function updateStepUI() {
    document.getElementById('stepLabel').textContent   = stepLabels[currentStep - 1];
    document.getElementById('stepPercent').textContent = stepPercents[currentStep - 1] + '%';
    document.getElementById('progressBar').style.width = stepPercents[currentStep - 1] + '%';
    for (var i = 1; i <= 4; i++) {
        var d = document.getElementById('dot' + i);
        d.classList.remove('active', 'done');
        if (i < currentStep)   d.classList.add('done');
        if (i === currentStep) d.classList.add('active');
    }
}

// ─────────────────────────────────────────────────────────
// FILE UPLOAD HELPERS
// ─────────────────────────────────────────────────────────
function updateFile(input, textId, boxId) {
    if (input.files && input.files[0]) {
        var file    = input.files[0];
        var maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            input.value = '';
            document.getElementById(textId).textContent = 'No file chosen';
            showFileError(boxId, '⚠️ File size exceeds 5MB. Please upload a smaller file.');
            return;
        }
        clearFileError(boxId);
        document.getElementById(textId).textContent =
            file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
        if (boxId) document.getElementById(boxId).style.border = '';
    }
}

function showFileError(boxId, msg) {
    var box = document.getElementById(boxId);
    if (!box) return;
    box.style.border = '1px solid #ef4444';
    var old = document.getElementById(boxId + '_err');
    if (old) old.remove();
    var err           = document.createElement('div');
    err.id            = boxId + '_err';
    err.textContent   = msg;
    err.style.cssText = 'color:#f87171;font-size:12px;margin-top:5px;';
    box.parentNode.insertBefore(err, box.nextSibling);
}

function clearFileError(boxId) {
    var box = document.getElementById(boxId);
    if (box) box.style.border = '';
    var old = document.getElementById(boxId + '_err');
    if (old) old.remove();
}

// ─────────────────────────────────────────────────────────
// ADDRESS COPY
// ─────────────────────────────────────────────────────────
function copyAddress(cb) {
    var fields = ['street', 'line2', 'city', 'state', 'zip', 'country'];
    fields.forEach(function (f) {
        var p = document.querySelector('[name="perm_' + f + '"]');
        var c = document.getElementById('curr_' + f);
        if (p && c) c.value = cb.checked ? p.value : '';
    });
}

// ─────────────────────────────────────────────────────────
// OTP — SEND
// ─────────────────────────────────────────────────────────
function onEmailChange() {
    emailVerified = false;
    document.getElementById('emailVerifiedBadge').style.display = 'none';
    document.getElementById('otpBox').style.display             = 'none';
    document.getElementById('emailMsg').style.display           = 'none';
    clearInterval(otpTimerInt);
}

function sendOtp() {
    var email = document.getElementById('emailField').value.trim();
    var btn   = document.getElementById('sendOtpBtn');
    var msgEl = document.getElementById('emailMsg');

    if (!email) { showMsg(msgEl, 'Please enter your email first.', 'red'); return; }
    if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
        showMsg(msgEl, 'Please enter a valid email address.', 'red'); return;
    }

    btn.disabled         = true;
    btn.textContent      = 'Sending...';
    btn.style.background = '#1d4ed8';

    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('<?php echo e(route("otp.send")); ?>', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body:    JSON.stringify({ email: email })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            document.getElementById('otpBox').style.display    = 'block';
            document.getElementById('otpField').value          = '';
            document.getElementById('otpMsg').textContent      = '';
            document.getElementById('resendBtn').style.display = 'none';
            showMsg(msgEl, 'OTP sent to ' + email, 'green');
            startSendCooldown(btn);
            startOtpTimer();
            document.getElementById('otpField').focus();
        } else {
            showMsg(msgEl, data.message || 'Failed to send OTP.', 'red');
            btn.disabled         = false;
            btn.textContent      = 'Send OTP';
            btn.style.background = '#3b82f6';
        }
    })
    .catch(function () {
        showMsg(msgEl, 'Network error. Please try again.', 'red');
        btn.disabled         = false;
        btn.textContent      = 'Send OTP';
        btn.style.background = '#3b82f6';
    });
}

// ─────────────────────────────────────────────────────────
// OTP — VERIFY
// ─────────────────────────────────────────────────────────
function verifyOtp() {
    var email = document.getElementById('emailField').value.trim();
    var otp   = document.getElementById('otpField').value.trim();
    var btn   = document.getElementById('verifyOtpBtn');
    var msgEl = document.getElementById('otpMsg');

    if (otp.length !== 6) { showOtpMsg(msgEl, 'Enter complete 6-digit OTP.', 'red'); return; }

    btn.disabled    = true;
    btn.textContent = 'Verifying...';

    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('<?php echo e(route("otp.verify")); ?>', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body:    JSON.stringify({ email: email, otp: otp })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            emailVerified = true;
            clearInterval(otpTimerInt);
            document.getElementById('otpBox').style.display             = 'none';
            document.getElementById('emailVerifiedBadge').style.display = 'inline';
            document.getElementById('emailField').readOnly              = true;
            document.getElementById('sendOtpBtn').style.display         = 'none';
            showMsg(document.getElementById('emailMsg'), 'Email verified successfully!', 'green');
            btn.disabled    = false;
            btn.textContent = 'Verify OTP';
        } else {
            showOtpMsg(msgEl, data.message || 'Invalid OTP.', 'red');
            document.getElementById('otpField').value = '';
            document.getElementById('otpField').focus();
            btn.disabled    = false;
            btn.textContent = 'Verify OTP';
            if (data.message && data.message.indexOf('request a new') !== -1) {
                document.getElementById('resendBtn').style.display = 'inline';
            }
        }
    })
    .catch(function () {
        showOtpMsg(msgEl, 'Network error. Please try again.', 'red');
        btn.disabled    = false;
        btn.textContent = 'Verify OTP';
    });
}

function resendOtp() {
    document.getElementById('otpField').value          = '';
    document.getElementById('otpMsg').textContent      = '';
    document.getElementById('resendBtn').style.display = 'none';
    clearInterval(otpTimerInt);
    var btn              = document.getElementById('sendOtpBtn');
    btn.disabled         = false;
    btn.textContent      = 'Send OTP';
    btn.style.display    = 'inline-block';
    btn.style.background = '#3b82f6';
    sendOtp();
}

function startOtpTimer() {
    clearInterval(otpTimerInt);
    otpSeconds = 600;
    var timerEl = document.getElementById('otpTimer');
    otpTimerInt = setInterval(function () {
        otpSeconds--;
        var m = String(Math.floor(otpSeconds / 60)).padStart(2, '0');
        var s = String(otpSeconds % 60).padStart(2, '0');
        timerEl.textContent = '(expires in ' + m + ':' + s + ')';
        if (otpSeconds <= 0) {
            clearInterval(otpTimerInt);
            timerEl.textContent = '(OTP expired)';
            timerEl.style.color = '#ef4444';
            document.getElementById('resendBtn').style.display = 'inline';
            document.getElementById('verifyOtpBtn').disabled   = true;
        }
    }, 1000);
}

function startSendCooldown(btn) {
    var secs             = 30;
    btn.disabled         = true;
    btn.style.background = '#334155';
    btn.textContent      = 'Resend (' + secs + 's)';
    var cd = setInterval(function () {
        secs--;
        btn.textContent = 'Resend (' + secs + 's)';
        if (secs <= 0) {
            clearInterval(cd);
            btn.disabled         = false;
            btn.style.background = '#3b82f6';
            btn.textContent      = 'Resend OTP';
        }
    }, 1000);
}

// ─────────────────────────────────────────────────────────
// MESSAGE HELPERS
// ─────────────────────────────────────────────────────────
function showMsg(el, msg, color) {
    el.textContent   = msg;
    el.style.color   = (color === 'green') ? '#86efac' : '#f87171';
    el.style.display = 'block';
}
function showOtpMsg(el, msg, color) {
    el.textContent = msg;
    el.style.color = (color === 'green') ? '#86efac' : '#f87171';
}

// ─────────────────────────────────────────────────────────
// DRAG & DROP / FILE TAGS
// ─────────────────────────────────────────────────────────
function dragOver(e, id)  { e.preventDefault(); document.getElementById(id).classList.add('dragover'); }
function dragLeave(e, id) { document.getElementById(id).classList.remove('dragover'); }

function dropFiles(e, boxId, inputId, previewId) {
    e.preventDefault();
    document.getElementById(boxId).classList.remove('dragover');
    var inp = document.getElementById(inputId);
    var dt  = new DataTransfer();
    Array.from(e.dataTransfer.files).forEach(function (f) { dt.items.add(f); });
    inp.files = dt.files;
    showFileTags(inp, previewId);
}

function showFileTags(input, previewId) {
    var c        = document.getElementById(previewId);
    var maxSize  = 5 * 1024 * 1024;
    c.innerHTML  = '';
    var hasError = false;

    Array.from(input.files).forEach(function (file, i) {
        if (file.size > maxSize) {
            hasError = true;
            var errTag           = document.createElement('div');
            errTag.style.cssText = 'color:#f87171;font-size:12px;background:#2d1515;border:1px solid #ef4444;border-radius:8px;padding:5px 10px;margin-bottom:4px;';
            errTag.textContent   = '⚠️ ' + file.name + ' exceeds 5MB — removed.';
            c.appendChild(errTag);
            return;
        }
        var tag       = document.createElement('div');
        tag.className = 'cert-tag';
        var btn       = document.createElement('button');
        btn.type      = 'button';
        btn.innerHTML = '&#10005;';
        btn.setAttribute('data-input', input.id);
        btn.setAttribute('data-idx',   i);
        btn.setAttribute('data-prev',  previewId);
        btn.onclick = function () {
            removeTag(
                this.getAttribute('data-input'),
                parseInt(this.getAttribute('data-idx')),
                this.getAttribute('data-prev')
            );
        };
        tag.innerHTML = '<i class="bi bi-file-earmark"></i> ' + file.name +
            ' <span style="color:#64748b;">(' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)</span> ';
        tag.appendChild(btn);
        c.appendChild(tag);
    });

    if (hasError) {
        var dt = new DataTransfer();
        Array.from(input.files).forEach(function (f) {
            if (f.size <= maxSize) dt.items.add(f);
        });
        input.files = dt.files;
    }
}

function removeTag(inputId, idx, previewId) {
    var inp = document.getElementById(inputId);
    var dt  = new DataTransfer();
    Array.from(inp.files).forEach(function (f, i) { if (i !== idx) dt.items.add(f); });
    inp.files = dt.files;
    showFileTags(inp, previewId);
}

// ─────────────────────────────────────────────────────────
// ADD EDU / EXP ROWS
// ─────────────────────────────────────────────────────────
function addEduRow(type) {
    var el        = document.createElement('div');
    el.className  = 'edu-row';
    var hdr       = '<div class="edu-row-header"><button type="button" class="remove-btn" onclick="this.closest(\'.edu-row\').remove()">&#10005; Remove</button></div>';
    if (type === 'tenth') {
        el.innerHTML = hdr +
            '<div class="row g-3">' +
            '<div class="col-md-3"><label>Passing Year</label><input name="tenth_year[]" class="form-control" placeholder="e.g. 2015"></div>' +
            '<div class="col-md-3"><label>Percentage</label><input name="tenth_percentage[]" class="form-control" placeholder="e.g. 85%"></div>' +
            '<div class="col-md-3"><label>Regular/Private</label><select name="tenth_type[]" class="form-control"><option value="">Select</option><option>Regular</option><option>Private</option></select></div>' +
            '<div class="col-md-3"><label>Board Name</label><input name="tenth_board[]" class="form-control" placeholder="e.g. CBSE"></div>' +
            '</div>';
        document.getElementById('tenthRows').appendChild(el);
    } else {
        el.innerHTML = hdr +
            '<div class="row g-3">' +
            '<div class="col-md-3"><label>Degree</label><input name="degree[]" class="form-control" placeholder="Degree"></div>' +
            '<div class="col-md-3"><label>Passing Year</label><input name="grad_year[]" class="form-control" placeholder="e.g. 2021"></div>' +
            '<div class="col-md-3"><label>Percentage</label><input name="grad_percentage[]" class="form-control" placeholder="e.g. 75%"></div>' +
            '<div class="col-md-3"><label>Regular/Private</label><select name="grad_type[]" class="form-control"><option value="">Select</option><option>Regular</option><option>Private</option></select></div>' +
            '<div class="col-md-6 mt-2"><label>University/College Name</label><input name="college[]" class="form-control" placeholder="College / University Name"></div>' +
            '</div>';
        document.getElementById('highestRows').appendChild(el);
    }
    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function addExpRow() {
    var el       = document.createElement('div');
    el.className = 'edu-row';
    var hdr      = '<div class="edu-row-header"><button type="button" class="remove-btn" onclick="this.closest(\'.edu-row\').remove()">&#10005; Remove</button></div>';
    el.innerHTML = hdr +
        '<div class="row g-3">' +
        '<div class="col-md-6"><label>Company Name</label><input name="company_name[]" class="form-control" placeholder="Previous company"></div>' +
        '<div class="col-md-6"><label>Designation</label><input name="prev_designation[]" class="form-control" placeholder="Your role"></div>' +
        '<div class="col-md-6"><label>From Date</label><input type="date" name="work_from[]" class="form-control" onclick="this.showPicker()"></div>' +
        '<div class="col-md-6"><label>To Date</label><input type="date" name="work_to[]" class="form-control" onclick="this.showPicker()"></div>' +
        '<div class="col-md-6"><label>Last CTC</label><input name="last_ctc[]" class="form-control" placeholder="e.g. 4,00,000"></div>' +
        '<div class="col-md-6"><label>Reason for Leaving</label><input name="leaving_reason[]" class="form-control" placeholder="Reason"></div>' +
        '</div>';
    document.getElementById('expRows').appendChild(el);
    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function toggleExpFields() {
    document.getElementById('expFields').style.display =
        document.getElementById('radioExp').checked ? 'block' : 'none';
}

// ─────────────────────────────────────────────────────────
// VALIDATION
// ─────────────────────────────────────────────────────────
function validateStep() {
    var ok = true;
    var s  = document.getElementById('step' + currentStep);

    // Step 1: OTP verified hona chahiye
    if (currentStep === 1 && !emailVerified) {
        var emailEl  = document.getElementById('emailField');
        var emailMsg = document.getElementById('emailMsg');
        emailEl.style.border = '1px solid #ef4444';
        showMsg(emailMsg, 'Please verify your email with OTP first.', 'red');
        emailEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }

    var reqClass  = { 1: 's1req', 2: 's2req', 4: 's4req' };
    var fileClass = { 1: 's1req_file', 4: 's4req_file' };

    if (reqClass[currentStep]) {
        s.querySelectorAll('.' + reqClass[currentStep]).forEach(function (el) {
            el.style.border = el.value.trim() ? '' : '1px solid #ef4444';
            if (!el.value.trim()) ok = false;
        });
    }
    if (fileClass[currentStep]) {
        s.querySelectorAll('.' + fileClass[currentStep]).forEach(function (el) {
            var box = el.closest('.file-box');
            if (!el.files || !el.files.length) {
                if (box) box.style.border = '1px dashed #ef4444';
                ok = false;
            }
        });
    }
    if (currentStep === 3 && document.getElementById('radioExp').checked) {
        s.querySelectorAll('.exp_req').forEach(function (el) {
            el.style.border = el.value.trim() ? '' : '1px solid #ef4444';
            if (!el.value.trim()) ok = false;
        });
    }
    if (currentStep === 4 && !document.getElementById('tncCheck').checked) {
        alert('Please accept the Terms & Conditions to submit.');
        return false;
    }
    if (!ok) alert('Please fill all required fields marked with *');
    return ok;
}

// ─────────────────────────────────────────────────────────
// SAVING OVERLAY
// ─────────────────────────────────────────────────────────
function showSavingOverlay(msg) {
    var ov           = document.createElement('div');
    ov.id            = 'savingOverlay';
    ov.className     = 'saving-overlay';
    ov.innerHTML     =
        '<div class="saving-spinner"></div>' +
        '<div class="saving-text">' + (msg || 'Saving your data...') + '</div>';
    document.body.appendChild(ov);
}
function hideSavingOverlay() {
    var ov = document.getElementById('savingOverlay');
    if (ov) ov.remove();
}

// ─────────────────────────────────────────────────────────
// TOAST
// ─────────────────────────────────────────────────────────
function showStepToast(msg, type) {
    var toast    = document.createElement('div');
    var isOk     = (type === 'success');
    toast.style.cssText =
        'position:fixed;top:24px;right:24px;z-index:99999;' +
        'padding:14px 22px;border-radius:12px;font-size:14px;font-weight:600;' +
        'box-shadow:0 4px 24px rgba(0,0,0,0.4);transition:opacity 0.5s;' +
        (isOk
            ? 'background:#166534;color:#86efac;border:1px solid #22c55e;'
            : 'background:#7f1d1d;color:#fca5a5;border:1px solid #ef4444;');
    toast.innerHTML = (isOk ? '✓ ' : '✕ ') + msg;
    document.body.appendChild(toast);
    setTimeout(function () {
        toast.style.opacity = '0';
        setTimeout(function () { toast.remove(); }, 500);
    }, 3500);
}

// ─────────────────────────────────────────────────────────
// CORE — AJAX STEP SAVE
// ─────────────────────────────────────────────────────────
function saveStepData(savingMsg, onSuccess, onError) {
    var formData = new FormData();
    var s        = document.getElementById('step' + currentStep);
    var token    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Current step ke saare inputs collect karo
    s.querySelectorAll('input, select, textarea').forEach(function (el) {
        if (!el.name) return;
        if (el.type === 'file') {
            if (el.multiple) {
                Array.from(el.files).forEach(function (f) { formData.append(el.name, f); });
            } else if (el.files && el.files[0]) {
                formData.append(el.name, el.files[0]);
            }
        } else if (el.type === 'radio') {
            if (el.checked) formData.append(el.name, el.value);
        } else if (el.type === 'checkbox') {
            if (el.checked) formData.append(el.name, el.value);
        } else {
            formData.append(el.name, el.value);
        }
    });

    formData.append('_token', token);

    showSavingOverlay(savingMsg);

    fetch(stepRoutes[currentStep], { method: 'POST', body: formData })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        hideSavingOverlay();
        if (data.success) {
            showStepToast(data.message, 'success');
            onSuccess();
        } else {
            showStepToast(data.message || 'Something went wrong. Please try again.', 'error');
            if (onError) onError();
        }
    })
    .catch(function () {
        hideSavingOverlay();
        showStepToast('Network error. Please check your connection.', 'error');
        if (onError) onError();
    });
}

// ─────────────────────────────────────────────────────────
// NEXT STEP — save karke aage jao, back hide karo
// ─────────────────────────────────────────────────────────
function nextStep(btnEl) {
    if (!validateStep()) return;

    // Button loading
    btnEl.disabled    = true;
    btnEl.textContent = 'Saving...';

    var savingMessages = {
        1: 'Saving Personal Details...',
        2: 'Saving Education Details...',
        3: 'Saving Experience Details...',
    };

    saveStepData(
        savingMessages[currentStep] || 'Saving...',
        function () {
            // ── SUCCESS ──
            // Current step hide karo
            document.getElementById('step' + currentStep).style.display = 'none';
            currentStep++;

            // Next step dikhao
            var nextEl = document.getElementById('step' + currentStep);
            nextEl.style.display = 'block';

            // ★ BACK BUTTON PERMANENTLY HIDE — saved step pe wapas nahi jaana
            var prevBtn = document.getElementById('prevBtn' + currentStep);
            if (prevBtn) prevBtn.style.display = 'none';

            updateStepUI();
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Button reset
            btnEl.disabled    = false;
            btnEl.innerHTML   = 'Next &rarr;';
        },
        function () {
            // ── ERROR — button re-enable ──
            btnEl.disabled  = false;
            btnEl.innerHTML = 'Next &rarr;';
        }
    );
}

// ─────────────────────────────────────────────────────────
// FINAL SUBMIT (Step 4)
// ─────────────────────────────────────────────────────────
function finalSubmit(btnEl) {
    if (!validateStep()) return;

    btnEl.disabled    = true;
    btnEl.textContent = 'Submitting...';

    saveStepData(
        'Submitting your profile...',
        function () {
            // ── SUCCESS — full card replace ──
            document.getElementById('mainCard').innerHTML =
                '<div style="text-align:center;padding:70px 20px;">' +
                    '<div style="width:90px;height:90px;border-radius:50%;' +
                         'background:linear-gradient(135deg,#22c55e,#16a34a);' +
                         'display:flex;align-items:center;justify-content:center;' +
                         'margin:0 auto 24px;box-shadow:0 0 40px rgba(34,197,94,0.4);">' +
                        '<i class="bi bi-check-lg text-white" style="font-size:42px;"></i>' +
                    '</div>' +
                    '<h3 style="color:#86efac;font-weight:700;font-size:26px;">' +
                        'Profile Submitted Successfully!' +
                    '</h3>' +
                    '<p style="color:#94a3b8;margin-top:12px;font-size:15px;">' +
                        'Your joining kit has been saved completely.<br>' +
                        'HR team will review it shortly.' +
                    '</p>' +
                    '<div style="margin-top:30px;padding:16px 24px;background:#0f1929;' +
                         'border:1px solid #22c55e;border-radius:14px;display:inline-block;">' +
                        '<span style="color:#4ade80;font-size:14px;">' +
                            '&#10003; All 4 steps completed &amp; saved to database' +
                        '</span>' +
                    '</div>' +
                '</div>';
        },
        function () {
            btnEl.disabled  = false;
            btnEl.innerHTML = 'Submit Profile &#10003;';
        }
    );
}

// ─────────────────────────────────────────────────────────
// PREV STEP (sirf tab kaam karega jab step save nahi hua)
// ─────────────────────────────────────────────────────────
function prevStep() {
    document.getElementById('step' + currentStep).style.display = 'none';
    currentStep--;
    document.getElementById('step' + currentStep).style.display = 'block';
    updateStepUI();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ─────────────────────────────────────────────────────────
// INIT
// ─────────────────────────────────────────────────────────
window.addEventListener('load', function () {
    var ef = document.getElementById('emailField');
    if (ef) ef.addEventListener('input', onEmailChange);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/joiningkit.blade.php ENDPATH**/ ?>