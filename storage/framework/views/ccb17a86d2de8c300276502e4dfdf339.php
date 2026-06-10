        
        
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <?php if (isset($component)) { $__componentOriginal000fcba1c6c5a1e4a2897e45738ec35e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal000fcba1c6c5a1e4a2897e45738ec35e = $attributes; } ?>
<?php $component = App\View\Components\AppTitle::resolve(['pageTitle' => $pageTitle] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppTitle::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'd-block d-lg-none']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal000fcba1c6c5a1e4a2897e45738ec35e)): ?>
<?php $attributes = $__attributesOriginal000fcba1c6c5a1e4a2897e45738ec35e; ?>
<?php unset($__attributesOriginal000fcba1c6c5a1e4a2897e45738ec35e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal000fcba1c6c5a1e4a2897e45738ec35e)): ?>
<?php $component = $__componentOriginal000fcba1c6c5a1e4a2897e45738ec35e; ?>
<?php unset($__componentOriginal000fcba1c6c5a1e4a2897e45738ec35e); ?>
<?php endif; ?>
        <h4 class="f-21 f-w-500 mb-0 d-none d-lg-block"><?php echo e($pageTitle); ?></h4>
        <div class="d-flex">
            <a href="<?php echo e(route('agent_retainer.create')); ?>" class="btn btn-primary rounded f-14 p-2 mr-2">
                <i class="fa fa-plus mr-1"></i> Add Retainer
            </a>
            <a href="<?php echo e(route('agent_retainer.export-excel')); ?>" class="btn btn-secondary rounded f-14 p-2">
                <i class="fa fa-file-export mr-1"></i> Export Excel
            </a>
        </div>
    </div>

<div class="card">
<div class="card-body">
        
        
        
        <?php if(session('success')): ?>
        <div class="alert alert-success" id="successMessage">
        <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>
        
        
        
        <form method="GET" class="row mb-3">
        
        <div class="col-md-3 mb-2">
        <input type="text"
        name="search"
        value="<?php echo e(request('search')); ?>"
        class="form-control"
        placeholder="Search Name / Mobile">
        </div>
        
        <div class="col-md-2 mb-2">
        <select name="gender" class="form-control">
        
        <option value="">Gender</option>
        
        <option value="Male" <?php echo e(request('gender')=='Male'?'selected':''); ?>>
        Male
        </option>
        
        <option value="Female" <?php echo e(request('gender')=='Female'?'selected':''); ?>>
        Female
        </option>
        
        <option value="Other" <?php echo e(request('gender')=='Other'?'selected':''); ?>>
        Other
        </option>
        
        </select>
        </div>
        
        <div class="col-md-2 mb-2">
        <input type="date"
        name="from_date"
        value="<?php echo e(request('from_date')); ?>"
        class="form-control"
        placeholder="From Created Date">
        </div>
        
        <div class="col-md-2 mb-2">
        <input type="date"
        name="to_date"
        value="<?php echo e(request('to_date')); ?>"
        class="form-control"
        placeholder="To Created Date">
        </div>
        
        <div class="col-md-2 mb-2">
        <button class="btn btn-success">
        Filter
        </button>
        </div>
        
        <div class="col-md-1 mb-2">
        <a href="<?php echo e(route('agent_retainer.list')); ?>" class="btn btn-secondary">
        Reset
        </a>
        </div>
        
        </form>
        
        
        <div class="table-responsive">
        
        <table class="table table-bordered table-hover">
        
        <thead>
        
        <tr>
        
        <th>#</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Gender</th>
        <th>DOB</th>
        <th>Created At</th>
        <th width="120">Action</th>
        
        </tr>
        
        </thead>
        
        <tbody>
        
        <?php $__empty_1 = true; $__currentLoopData = $agentRetainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        
        <tr>
        
        <td><?php echo e($agentRetainers->firstItem() + $key); ?></td>
        
        <td><?php echo e($row->name); ?></td>
        
        <td><?php echo e($row->mobile); ?></td>
        
        <td><?php echo e($row->gender); ?></td>
        
        <td><?php echo e($row->date_of_birth); ?></td>
        
        <td><?php echo e($row->created_at->format('d-m-Y')); ?></td>
        
        <td>
        
        <a href="<?php echo e(route('agent_retainer.pdf',$row->id)); ?>"
        class="btn btn-danger btn-sm btn-pdf">
        
        PDF
        
        </a>
        
        </td>
        
        </tr>
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        
        <tr>
        
        <td colspan="7" class="text-center">
        No Data Found
        </td>
        
        </tr>
        
        <?php endif; ?>
        
        </tbody>
        
        </table>
        
        </div>
        
        
        <div class="mt-3">
      <?php echo e($agentRetainers->appends(request()->query())->links('pagination::simple-bootstrap-4')); ?>

        </div>
        
        </div>
        
        </div>
        
        </div>
        
        </div>
        
        <?php $__env->stopSection(); ?>
        
        
        <?php $__env->startPush('scripts'); ?>
        
        <script>
        
        setTimeout(function(){
        
        let msg = document.getElementById('successMessage');
        
        if(msg){
        
        msg.style.display = 'none';
        
        }
        
        },3000);
        
        </script>
        
        <?php $__env->stopPush(); ?>
        <?php $__env->startPush('styles'); ?>
    
    <style>
    
    .btn-pdf{
    background:#dc3545;
    color:#fff !important;
    border-color:#dc3545;
    }
    
    .btn-pdf:hover{
    background:#000;
    color:#fff !important;
    border-color:#000;
    }
    
    </style>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\axvero\crm\resources\views/agent_retainer_list.blade.php ENDPATH**/ ?>