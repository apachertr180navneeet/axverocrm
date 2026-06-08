                
                
                <?php $__env->startPush('styles'); ?>
                
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
                
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
                
                <form method="POST" action="<?php echo e(route('sales-executive.store')); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="bg-white p-4 rounded">
                
                <?php if(session('success')): ?>
                <div id="success-alert" class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php endif; ?>
                
                <h4 class="mb-3">Sales Executive Report</h4>
                <hr>
                
                
                <div class="row">
                
                
                <div class="col-12 col-md-3 mb-3">
                <label>Name</label>
                <input type="text" name="name"
                placeholder="Name"
                class="form-control">
                </div>
                
                <div class="col-12 col-md-3 mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile"
                class="form-control" placeholder="Enter Mobile">
                </div>
                     
                <div class="col-12 col-md-3 mb-3">
                <label>Portal Id</label>
                <input type="text" name="portal_id"
                placeholder="Portal Id"
                class="form-control">
                </div>
                
                <div class="col-12 col-md-3 mb-3">
                <label>Manager Name</label>
                <input type="text" name="manager_name"
                class="form-control" placeholder="Manager Name">
                </div>
                
                <div class="col-12 col-md-3 mb-3">
                <label>Manager Mobile</label>
                <input type="text" name="manager_mobile"
                class="form-control" placeholder="Manager Mobile">
                </div>
                
                </div>
                
                <hr>
                
                
                <h5>Today Work</h5>
                <hr>
                
                <div class="row">
                
                <div class="col-12 col-md-3 mb-3">
                <label>Today Sales Number</label>
                <input type="number" name="today_sales_number"
                class="form-control" placeholder="Today Sales Number" required>
                </div>
                
                <div class="col-12 col-md-3 mb-3">
                <label>Today Sales Amount</label>
                <input type="number" step="0.01"
                name="today_sales_amount"
                class="form-control" placeholder="Today Sales Amount" required>
                </div>
                
                </div>
                
                <hr>
                
                
                <h6>Today Followup</h6>
                
                <div id="followup-wrapper">
                <div class="form-row align-items-end followup-row mb-2">
                
                <div class="col-12 col-md mb-2">
                <label>Customer Name</label>
                <input type="text" name="followup_customer_name[]"
                class="form-control" placeholder="Customer Name">
                </div>
                
                <div class="col-12 col-md mb-2">
                <label>Mobile Number</label>
                <input type="text" name="followup_mobile[]"
                class="form-control" placeholder="Mobile Number">
                </div>
                
                <div class="col-12 col-md-auto mb-2 d-flex">
                <button type="button" class="btn btn-danger btn-sm rounded-circle mr-1"
                style="width:30px;height:30px;"
                onclick="addFollowupRow()">
                <i class="fas fa-plus"></i>
                </button>
                
                <button type="button"
                class="btn btn-secondary btn-sm rounded-circle remove-btn d-none"
                style="width:30px;height:30px;"
                onclick="removeRow(this)">
                <i class="fas fa-minus"></i>
                </button>
                </div>
                
                </div>
                </div>
                
                <hr>
                
                
                <h6>Total Work</h6>
                
                <div class="row">
                
                <div class="col-12 col-md-3 mb-3">
                <label>Number of Sales</label>
                <input type="number" name="total_sales_number"
                class="form-control" placeholder="Number of Sales" required>
                </div>
                
                <div class="col-12 col-md-3 mb-3">
                <label>Total Sales Amount</label>
                <input type="number" step="0.01"
                name="total_sales_amount"
                class="form-control" placeholder="Total Sales Amount" required>
                </div>
                
                </div>
                
                <hr>
                
                <button type="submit" class="btn btn-primary">
                Submit
                </button>
                
                </div>
                </form>
                </div>
                </div>
                <?php $__env->stopSection(); ?>
                
                
                <?php $__env->startPush('scripts'); ?>
                
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
                
                <script>
                
                function addFollowupRow(){
                    cloneRow('followup-row','followup-wrapper');
                }
                
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
                });
                
                </script>
                
                <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u536896586/domains/crmaxvero.in/public_html/resources/views/sales-executive.blade.php ENDPATH**/ ?>