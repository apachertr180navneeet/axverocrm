<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retainer Form</title>

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

            <form method="POST" action="{{ route('agent_retainer.store') }}">
                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Mobile <span class="required">*</span></label>
                        <input type="text" name="mobile" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Permanent Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Marital Status</label>
                        <select name="marital_status" class="form-control">
                            <option value="">Select</option>
                            <option>Single</option>
                            <option>Married</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Recommended Person Name</label>
                        <input type="text" name="person_name" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Recommended Person Mobile</label>
                        <input type="text" name="person_mobile" class="form-control">
                    </div>

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
