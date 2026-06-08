            
            
            <?php $__env->startPush('styles'); ?>
            
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            
            <style>
            @media(max-width:768px){
                .form-row label{
                    display:none;
                }
            }
            </style>
            
            <?php $__env->stopPush(); ?>
            
            
            <?php $__env->startSection('content'); ?>
            <div class="content-wrapper">
            <div class="container-fluid">
            
            <form method="POST" action="<?php echo e(route('daily-report.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="bg-white p-4 rounded">
            
            
                 <?php if(session('success')): ?>
                <div id="success-alert" class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>
            
            <h4 class="mb-3">Report Manager</h4>
            <hr>
            
            
            <div class="row">
            
            <div class="col-12 col-md-3 mb-3">
            <label>Date</label>
            <input type="text" id="report_date" name="report_date"
                   class="form-control" autocomplete="off">
            </div>
            
            <div class="col-12 col-md-3 mb-3">
            <label>Portal Email</label>
            <input type="email" name="portal_email"
                   value="<?php echo e($user->email); ?>"
                   class="form-control" readonly>
            </div>
            
            <div class="col-12 col-md-3 mb-3">
            <label>Name</label>
            <input type="text" name="name"
                   value="<?php echo e($user->name); ?>"
                   class="form-control" readonly>
            </div>
            
            <div class="col-12 col-md-3 mb-3">
            <label>Mobile</label>
            <input type="text" 
           name="mobile"
           value="<?php echo e($user->mobile); ?>"
           class="form-control">
            </div>
            
            </div>
            
            <hr>
            <h5>Today Team Work Report</h5>
            <hr>
            
            
            <h6>Today Selected Person Detail</h6>
            
                    <div id="selected-wrapper">
                    <div class="form-row align-items-end selected-row mb-2">
                    
                    <div class="row w-100">
                    <div class="col-12 col-md-3 mb-2">
                    <label>Hr.Executive Name</label>
                    <input type="text" name="hr_name[]" class="form-control" placeholder="Hr.Executive Name">
                    </div>
                    
                    <div class="col-12 col-md-3 mb-2">
                    <label>HR Mobile</label>
                    <input type="text" name="hr_mobile[]" class="form-control" placeholder="HR Mobile">
                    </div>
                    
                    <div class="col-12 col-md-3 mb-2">
                    <label>Name</label>
                    <input type="text" name="selected_name[]" class="form-control" placeholder="Name">
                    </div>
                    
                    <div class="col-12 col-md-3 mb-2">
                    <label>Person Mobile</label>
                    <input type="text" name="selected_mobile[]" class="form-control" placeholder="Person Mobile">
                    </div>
                    </div>
                    
                    <div class="row w-100">
                    
                    <div class="col-12 col-md-3 mb-2">
                    <label>Salary</label>
                    <input type="number" name="salary_offered[]" class="form-control" placeholder="Salary Offered">
                    </div>
                    
                    <div class="col-12 col-md-3 mb-2">
                    <label>Email</label>
                    <input type="email" name="person_email[]" class="form-control" placeholder="Person Email">
                    </div>
                    
                    <div class="col-12 col-md-3 mb-2">
                    <label>Designation</label>
                    <input type="text" name="designation[]" class="form-control" placeholder="Designation">
                    </div>
                    
                    <div class="col-12 col-md-2 mb-2">
                    <label>Joining Date</label>
                    <input type="date" name="joining_date[]" class="form-control" placeholder="Joining Date">
                    </div>
                    
                    <div class="col-12 col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-primary btn-sm rounded-circle mr-1"
                    style="width:30px;height:30px;" onclick="addSelectedRow()">
                    <i class="fas fa-plus"></i>
                    </button>
                    
                    <button type="button"
                    class="btn btn-danger btn-sm rounded-circle remove-btn d-none"
                    style="width:30px;height:30px;"
                    onclick="removeRow(this)">
                    <i class="fas fa-minus"></i>
                    </button>
                    </div>
                    
                    </div>
                    
                    </div>
                    </div>
            
            <hr>
            
            
            <!--<h6>Today Retainer Detail</h6>-->
            
            <!--<div id="retainer-wrapper">-->
            <!--<div class="form-row align-items-end retainer-row mb-2">-->
            
            <!--<div class="col-12 col-md mb-2">-->
            <!--<label>Hr.Executive Name</label>-->
            <!--<input type="text" name="retainer_hr_name[]" class="form-control" placeholder="Hr.Executive Name">-->
            <!--</div>-->
            
            <!--<div class="col-12 col-md mb-2">-->
            <!--<label>HR Mobile</label>-->
            <!--<input type="text" name="retainer_hr_mobile[]" class="form-control" placeholder="HR Mobile">-->
            <!--</div>-->
            
            <!--<div class="col-12 col-md mb-2">-->
            <!--<label>Retainer Name</label>-->
            <!--<input type="text" name="retainer_name[]" class="form-control" placeholder="Retainer Name">-->
            <!--</div>-->
            
            <!--<div class="col-12 col-md mb-2">-->
            <!--<label>Retainer Mobile</label>-->
            <!--<input type="text" name="retainer_mobile[]" class="form-control" placeholder="Retainer Mobile">-->
            <!--</div>-->
            
            <!--<div class="col-12 col-md-auto mb-2 d-flex">-->
            <!--<button type="button" class="btn btn-primary btn-sm rounded-circle mr-1"-->
            <!--        style="width:30px;height:30px;" onclick="addRetainerRow()">-->
            <!--<i class="fas fa-plus"></i>-->
            <!--</button>-->
            
            <!--<button type="button"-->
            <!--        class="btn btn-danger btn-sm rounded-circle remove-btn d-none"-->
            <!--        style="width:30px;height:30px;"-->
            <!--        onclick="removeRow(this)">-->
            <!--<i class="fas fa-minus"></i>-->
            <!--</button>-->
            <!--</div>-->
            
            <!--</div>-->
            <!--</div>-->
            
            <!--<hr>-->
            
            
            <h6>Total Team Detail</h6>
            
            <div id="team-wrapper">
            <div class="form-row align-items-end team-row mb-2">
            
            <div class="col-12 col-md mb-2">
            <label>Hr.Executive Name</label>
            <input type="text" name="total_hr_name[]" class="form-control" placeholder="Hr.Executive Name">
            </div>
            
            <div class="col-12 col-md mb-2">
            <label>HR Mobile</label>
            <input type="text" name="total_hr_mobile[]" class="form-control" placeholder="HR Mobile">
            </div>
            
            <div class="col-12 col-md mb-2">
            <label>Total Hr Executive</label>
            <input type="number" name="total_active_executive[]" class="form-control" placeholder="Total Hr Executive">
            </div>
            
            <div class="col-12 col-md mb-2">
            <label>Total Sales Executive</label>
            <input type="number" name="total_active_retainer[]" class="form-control" placeholder="Total Sales Executive">
            </div>
            
            <div class="col-12 col-md-auto mb-2 d-flex">
            <button type="button" class="btn btn-primary btn-sm rounded-circle mr-1"
                    style="width:30px;height:30px;" onclick="addTeamRow()">
            <i class="fas fa-plus"></i>
            </button>
            
            <button type="button"
                    class="btn btn-danger btn-sm rounded-circle remove-btn d-none"
                    style="width:30px;height:30px;"
                    onclick="removeRow(this)">
            <i class="fas fa-minus"></i>
            </button>
            </div>
            
            </div>
            </div>
            
            <hr>
            
            <!--<div class="row">-->
            <!--<div class="col-12 col-md-6 mb-3">-->
            <!--<label>Total Joined Retainer</label>-->
            <!--<input type="number" name="total_joined_retainer" class="form-control" required>-->
            <!--</div>-->
            <!--</div>-->
            
            <button type="submit" class="btn btn-primary">Submit</button>
            
            </div>
            </form>
            </div>
            </div>
            <?php $__env->stopSection(); ?>
            
            
            <?php $__env->startPush('scripts'); ?>
            
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            
            <script>
            flatpickr("#report_date", {
                enableTime: true,
                dateFormat: "Y-m-d h:i K",
                time_24hr: false,
                defaultDate: new Date()
            });
            
            function addSelectedRow(){ cloneRow('selected-row','selected-wrapper'); }
            function addRetainerRow(){ cloneRow('retainer-row','retainer-wrapper'); }
            function addTeamRow(){ cloneRow('team-row','team-wrapper'); }
            
            function cloneRow(rowClass, wrapperId){
                let original = document.querySelector('.' + rowClass);
                let clone = original.cloneNode(true);
                clone.querySelectorAll('input').forEach(input => input.value='');
                clone.querySelector('.remove-btn').classList.remove('d-none');
                document.getElementById(wrapperId).appendChild(clone);
                updateRemoveButtons(wrapperId);
            }
            
            function removeRow(button){
                let row = button.closest('.form-row');
                let wrapper = row.parentNode;
                if(wrapper.children.length > 1){
                    wrapper.removeChild(row);
                    updateRemoveButtons(wrapper.id);
                }
            }
            
            function updateRemoveButtons(wrapperId){
                let wrapper = document.getElementById(wrapperId);
                let rows = wrapper.querySelectorAll('.form-row');
                rows.forEach(row=>{
                    let removeBtn = row.querySelector('.remove-btn');
                    rows.length === 1
                        ? removeBtn.classList.add('d-none')
                        : removeBtn.classList.remove('d-none');
                });
            }
             $(document).ready(function() {
                    setTimeout(function() {
                        let alertBox = $('#success-alert');
                        if(alertBox.length){
                            alertBox.fadeOut('slow');
                        }
                    }, 3000);
                })
                    </script>
            
            <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u972418887/domains/kactto.com/public_html/crmhr/resources/views/daily-report.blade.php ENDPATH**/ ?>