<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retainer Form</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ companyOrGlobalSetting()->favicon_url }}">
    <link rel="manifest" href="{{ companyOrGlobalSetting()->favicon_url }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ companyOrGlobalSetting()->favicon_url }}">
    <meta name="theme-color" content="#ffffff">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 10px;
        }
        .required {
            color: red;
        }
    </style>
</head>

<body>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-4 text-center">Retainer Form</h4>

            {{-- Success Message --}}
            @if(session('success'))
            <div id="success-alert" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('agent_retainer_new.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- TYPE --}}
                    <div class="col-md-4 mb-3">
                        <label>Type <span class="required">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">Select</option>
                            <option value="Retainer" {{ old('type') == 'Retainer' ? 'selected' : '' }}>Retainer</option>
                            <option value="Agent" {{ old('type') == 'Agent' ? 'selected' : '' }}>Agent</option>
                        </select>@error('type')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- PHOTO --}}
                    <div class="col-md-4 mb-3">
                        <label>Photo <span class="required">*</span></label>
                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" required>
                        @error('photo')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- NAME --}}
                    <div class="col-md-4 mb-3">
                        <label>Name <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- MOBILE --}}
                    <div class="col-md-4 mb-3">
                        <label>Mobile <span class="required">*</span></label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" required>
                        @error('mobile')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-4 mb-3">
                        <label>Email ID</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- ADDRESS --}}
                    <div class="col-md-4 mb-3">
                        <label>Permanent Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror">
                        @error('address')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- DOB --}}
                    <div class="col-md-4 mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control @error('date_of_birth') is-invalid @enderror" max="{{ date('Y-m-d') }}">
                        @error('date_of_birth')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- GENDER --}}
                    <div class="col-md-4 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select</option>
                            <option {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>@error('gender')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- MARITAL --}}
                    <div class="col-md-4 mb-3">
                        <label>Marital Status</label>
                        <select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                            <option value="">Select</option>
                            <option {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                        </select>@error('marital_status')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- MANAGER NAME --}}
                    {{--  <div class="col-md-4 mb-3">
                        <label>Manager Name</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name') }}" class="form-control @error('manager_name') is-invalid @enderror">
                        @error('manager_name')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>  --}}

                    {{-- MANAGER MOBILE --}}
                    {{--  <div class="col-md-4 mb-3">
                        <label>Manager Mobile</label>
                        <input type="text" name="manager_mobile" value="{{ old('manager_mobile') }}" class="form-control @error('manager_mobile') is-invalid @enderror">
                        @error('manager_mobile')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>  --}}

                    {{-- RECOMMENDED NAME --}}
                    <div class="col-md-4 mb-3">
                        <label>Recommended Person Name</label>
                        <input type="text" name="recommended_name" value="{{ old('recommended_name') }}" class="form-control @error('recommended_name') is-invalid @enderror">
                        @error('recommended_name')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- RECOMMENDED MOBILE --}}
                    <div class="col-md-4 mb-3">
                        <label>Recommended Person Mobile</label>
                        <input type="text" name="recommended_mobile" value="{{ old('recommended_mobile') }}" class="form-control @error('recommended_mobile') is-invalid @enderror">
                        @error('recommended_mobile')
                            <span class="text-danger small" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                {{-- TERMS --}}
                <div class="form-group mt-3">
                    <input type="checkbox" required>
                    I agree to 
                    <a href="https://kactto.com/termscondition" target="_blank">
                        Terms & Conditions
                    </a>
                </div>

                <button class="btn btn-danger btn-block mt-3">Submit</button>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
setTimeout(function(){
    let alert = document.getElementById("success-alert");
    if(alert){
        alert.style.opacity = "0";
        setTimeout(()=>alert.remove(),500);
    }
},3000);
</script>

</body>
</html>
