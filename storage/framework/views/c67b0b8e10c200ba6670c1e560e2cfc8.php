

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
<div class="container-fluid mt-4">

<div class="card shadow-sm">
<div class="card-body">

<h4 class="mb-4">RETAINER FORM</h4>


<?php if(session('success')): ?>
<div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
<?php echo e(session('success')); ?>

<button type="button" class="close" data-dismiss="alert">
<span>&times;</span>
</button>
</div>
<?php endif; ?>


<form method="POST" action="<?php echo e(route('agent_retainer.store')); ?>">
<?php echo csrf_field(); ?>

<div class="row">

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter Name">
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" placeholder="Enter Mobile">
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Address</label>
<input type="text" name="address" class="form-control" placeholder="Enter Address">
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Gender</label>
<select name="gender" class="form-control">
<option value="">Select Gender</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Date of Birth</label>
<input type="date" name="date_of_birth" class="form-control" max="<?php echo e(date('Y-m-d')); ?>">
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Marital Status</label>
<select name="marital_status" class="form-control">
<option value="">Select Status</option>
<option value="Single">Single</option>
<option value="Married">Married</option>
</select>
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Recommended Person Name</label>
<input type="text" name="person_name" class="form-control" placeholder="Enter Name">
</div>

<div class="col-12 col-md-6 col-lg-4 mb-3">
<label>Recommended Person Mobile</label>
<input type="text" name="person_mobile" class="form-control" placeholder="Enter Mobile">
</div>

</div>

<hr>

<button type="submit" class="btn btn-danger">
Submit
</button>

</form>

</div>
</div>

</div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    setTimeout(function(){

        let alert = document.getElementById("success-alert");

        if(alert){
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";

            setTimeout(function(){
                alert.remove();
            },500);
        }

    },3000);

});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/agent_retainer.blade.php ENDPATH**/ ?>