        
        
        <?php $__env->startPush('styles'); ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <?php $__env->stopPush(); ?>
        
        <?php $__env->startSection('content'); ?>
        
            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php endif; ?>
        <div class="container mt-4 mb-5">
        <form method="POST" action="<?php echo e(route('hr.executive.report.store')); ?>">
        <?php echo csrf_field(); ?>
        
        <h4 class="mb-4">Executive Report</h4>
        
        
        <div class="row">
        
            <div class="col-md-6 col-12 mb-3">
                <label>Date</label>
                <input type="text" id="report_date" name="report_date" class="form-control">
            </div>
        
            <div class="col-md-6 col-12 mb-3">
                <label>Portal Email ID <span class="text-danger">(Required)</span></label>
                <input type="email" value="<?php echo e($user->email); ?>"  name="portal_email" class="form-control" required readonly>
            </div>
        
            <div class="col-md-6 col-12 mb-3">
                <label>Your Name <span class="text-danger">(Required)</span></label>
                <input type="text" value="<?php echo e($user->name); ?>"  name="name" class="form-control" required readonly>
            </div>
        
            <div class="col-md-6 col-12 mb-3">
                <label>Your Mobile <span class="text-danger">(Required)</span></label>
                <input type="text" value="<?php echo e($user->mobile); ?>"  name="mobile" class="form-control" required >
            </div>
        
            <div class="col-md-6 col-12 mb-3">
                <label>HR Manager Mobile <span class="text-danger">(Required)</span></label>
                <input type="text" name="hr_manager_mobile" class="form-control" required>
            </div>
        
            <div class="col-md-6 col-12 mb-3">
                <label>HR Manager Name <span class="text-danger">(Required)</span></label>
                <input type="text" name="hr_manager_name" class="form-control" required>
            </div>
        
        </div>
        
        <hr>
        
        <h5 class="mt-4">Today Report</h5>
        <hr>
        
        
        <h6>Today Selected Person's Report <span class="text-danger">(Required)</span></h6>
        
      <div id="selected-wrapper">
        <div class="row selected-row align-items-end mb-3">
        
            <div class="col-md col-12">
                <label>Person Name</label>
                <input type="text" name="selected_person_name[]" class="form-control">
            </div>
        
            <div class="col-md col-12">
                <label>Mobile Number</label>
                <input type="text" name="selected_mobile[]" class="form-control">
            </div>
        
            <div class="col-md col-12">
                <label>Designation</label>
                <input type="text" name="selected_designation[]" class="form-control">
            </div>
        
            <div class="col-md col-12">
                <label>Joining Date</label>
                <input type="date" name="selected_joining_date[]" class="form-control">
            </div>
        
            <div class="col-md col-12">
                <label>Person E-mail ID</label>
                <input type="email" name="selected_email[]" class="form-control">
            </div>
        
            <div class="col-md-auto col-12 d-flex align-items-end">
                <button type="button" class="btn btn-primary btn-sm rounded-circle" onclick="addSelectedRow()">
                    <i class="fas fa-plus"></i>
                </button>
        
                <button type="button" class="btn btn-danger btn-sm rounded-circle ml-1 remove-btn" onclick="removeRow(this)" style="display:none;">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        
        </div>
        </div>
        
        
        <h6>Follow Up Candidates Detail <span class="text-danger">(Required)</span></h6>
        
        <div id="follow-wrapper">
        <div class="row follow-row align-items-end mb-3">
        
            <div class="col-md-4 col-12">
                <label>Person Name</label>
                <input type="text" name="follow_person_name[]" class="form-control">
            </div>
        
            <div class="col-md-4 col-12">
                <label>Mobile Number</label>
                <input type="text" name="follow_mobile[]" class="form-control">
            </div>
        
            <div class="col-md-3 col-10">
                <label>Interview Date</label>
                <input type="text" name="interview_date[]" class="form-control interview_date">
            </div>
        
            <div class="col-md-1 col-2 d-flex align-items-end">
                <button type="button" class="btn btn-primary btn-sm rounded-circle" onclick="addFollowRow()">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm rounded-circle ml-1 remove-btn" onclick="removeRow(this)" style="display:none;">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        
        </div>
        </div>
   
        
        <hr>
        
        <h5>Detail of Joined Total Candidate</h5>
        <hr>
        
        <div id="total-wrapper">
        <div class="row total-row align-items-end mb-3">
        
            <div class="col-md-5 col-12">
                <label>Total Hr Executive</label>
                <input type="number" name="total_executive[]" class="form-control">
            </div>
        
            <div class="col-md-5 col-10">
                <label>Total Sales Executive</label>
                <input type="number" name="total_sales_executive[]" class="form-control">
            </div>
        
            <div class="col-md-2 col-2 d-flex align-items-end">
                <button type="button" class="btn btn-primary btn-sm rounded-circle" onclick="addTotalRow()">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm rounded-circle ml-1 remove-btn" onclick="removeRow(this)" style="display:none;">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        
        </div>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
        
        </form>
        </div>
        
        <?php $__env->stopSection(); ?>
        <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        <script>
                      flatpickr("#report_date", {
                dateFormat: "d/m/Y",
                defaultDate: new Date()
            });
            
            initInterviewDate();
            
            function initInterviewDate(){
                flatpickr(".interview_date",{
                    dateFormat:"d/m/Y"
                });
            }
            
            function cloneRow(rowClass, wrapperId){
                let original=document.querySelector('.'+rowClass);
                let clone=original.cloneNode(true);
            
                clone.querySelectorAll('input').forEach(input=>input.value='');
            
                clone.querySelector('.remove-btn').style.display='inline-block';
            
                document.getElementById(wrapperId).appendChild(clone);
            
                // 🔥 IMPORTANT
                initInterviewDate();
            }
            
            function removeRow(btn){
                let row=btn.closest('.row');
                if(row.parentNode.children.length>1){
                    row.remove();
                }
            }
            
            function addSelectedRow(){ cloneRow('selected-row','selected-wrapper'); }
            function addFollowRow(){ cloneRow('follow-row','follow-wrapper'); }
            function addTotalRow(){ cloneRow('total-row','total-wrapper'); }
        </script>
        <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/kactto.space/public_html/resources/views/hr-executive-report.blade.php ENDPATH**/ ?>