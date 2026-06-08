
<?php if (isset($component)) { $__componentOriginald278722911781386ebf0ce0184b0f0fb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald278722911781386ebf0ce0184b0f0fb = $attributes; } ?>
<?php $component = App\View\Components\Auth::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Auth::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginal18ad2e0d264f9740dc73fff715357c28 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18ad2e0d264f9740dc73fff715357c28 = $attributes; } ?>
<?php $component = App\View\Components\Form::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Form::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'acceptInviteForm']); ?>
        <input type="hidden" name="send_mail_to_admin" value="yes">

        <h3 class=" mb-4 f-w-500"><?php echo app('translator')->get('app.signUp'); ?></h3>

        <div class="alert alert-success m-t-10 d-none" id="success-msg"></div>
            <div class=" text-left text-primary">
                <p>Employee Id - <?php echo e($lastEmployeeID+1); ?></p>
            </div>
        <div class="group">
            <div class="form-group text-left">
                <label for="user-name"><?php echo app('translator')->get('modules.employees.fullName'); ?><sup
                        class="f-14">*</sup></label>
                <input type="text" name="name" class="form-control height-50 f-15 light_text"
                       placeholder="<?php echo app('translator')->get('placeholders.name'); ?>" id="user-name">
            </div>

            <?php if(!is_null($invite->email_restriction)): ?>
                <div class="form-group text-left">
                    <?php if (isset($component)) { $__componentOriginal89b295b0763c93abe0143426334eb5d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal89b295b0763c93abe0143426334eb5d6 = $attributes; } ?>
<?php $component = App\View\Components\Forms\Label::resolve(['fieldId' => 'user-email','fieldLabel' => __('app.email')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Forms\Label::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal89b295b0763c93abe0143426334eb5d6)): ?>
<?php $attributes = $__attributesOriginal89b295b0763c93abe0143426334eb5d6; ?>
<?php unset($__attributesOriginal89b295b0763c93abe0143426334eb5d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal89b295b0763c93abe0143426334eb5d6)): ?>
<?php $component = $__componentOriginal89b295b0763c93abe0143426334eb5d6; ?>
<?php unset($__componentOriginal89b295b0763c93abe0143426334eb5d6); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalcbf9105fd4879d5d6ef9e1f6fe271af7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbf9105fd4879d5d6ef9e1f6fe271af7 = $attributes; } ?>
<?php $component = App\View\Components\Forms\InputGroup::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('forms.input-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Forms\InputGroup::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <input type="text" name="email_address" id="email_address"
                               class="form-control height-50 f-15 light_text">
                         <?php $__env->slot('append', null, []); ?> 
                        <span class="input-group-text height-50 border bg-white">

                            <?php echo e($lastEmployeeID+1); ?><?php echo e('@'.$invite->email_restriction); ?></span>
                         <?php $__env->endSlot(); ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcbf9105fd4879d5d6ef9e1f6fe271af7)): ?>
<?php $attributes = $__attributesOriginalcbf9105fd4879d5d6ef9e1f6fe271af7; ?>
<?php unset($__attributesOriginalcbf9105fd4879d5d6ef9e1f6fe271af7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcbf9105fd4879d5d6ef9e1f6fe271af7)): ?>
<?php $component = $__componentOriginalcbf9105fd4879d5d6ef9e1f6fe271af7; ?>
<?php unset($__componentOriginalcbf9105fd4879d5d6ef9e1f6fe271af7); ?>
<?php endif; ?>
                    <input type="hidden" name="email_domain" id="email_domain"
                           value="<?php echo e($lastEmployeeID+1); ?><?php echo e('@'.$invite->email_restriction); ?>">
                    <input type="hidden" name="email" id="user-email">
                </div>
            <?php else: ?>
                <div class="form-group text-left">
                    <label for="user-email"><?php echo app('translator')->get('app.email'); ?><sup class="f-14">*</sup></label>
                    <input type="email" name="email" class="form-control height-50 f-15 light_text"
                           placeholder="<?php echo app('translator')->get('placeholders.email'); ?>" id="user-email">
                </div>
            <?php endif; ?>

            <div class="row">

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile"
                   class="form-control height-50 f-15 light_text"
                   id="mobile" placeholder="Enter mobile number">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="joining_date">Joining Date</label>
            <input type="date" name="joining_date"
                   class="form-control height-50 f-15 light_text"
                   id="joining_date"
                   value="<?php echo e(now()->format('Y-m-d')); ?>" >
        </div>
    </div>

</div>


<div class="row">

   <div class="col-md-6">
    <div class="form-group text-left">
        <label for="department">Department</label>

        <select class="form-control height-50 f-15 light_text" id="department" >
            
            
    <?php if($invite->department_id == 5): ?>
        <option value="5" selected>
            Human Resource
        </option>
    <?php else: ?>
        <option value="6" <?php echo e($invite->department_id == 6 ? 'selected' : ''); ?>>
            Retainer Sales & Marketing
        </option>

        <option value="7" <?php echo e($invite->department_id == 7 ? 'selected' : ''); ?>>
            Retainer Sales
        </option>
    <?php endif; ?>
            <!--<option value="5" <?php echo e($invite->department_id == 5 ? 'selected' : ''); ?>>-->
            <!--    Human Resource-->
            <!--</option>-->
            

            <!--<option value="6" <?php echo e($invite->department_id == 6 ? 'selected' : ''); ?>>-->
            <!--    Retainer Sales & Marketing-->
            <!--</option>-->
            
            <!--   <option value="7" <?php echo e($invite->department_id == 7 ? 'selected' : ''); ?>>-->
            <!--    Retainer Sales-->
            <!--</option>-->
            
        </select>

        <!-- Actual value that will be submitted -->
        <input type="hidden" name="department" value="<?php echo e($invite->department_id); ?>">
    </div>
</div>

    <div class="col-md-6">
    <div class="form-group text-left">
        <label for="designation">Designation</label>

        <select class="form-control height-50 f-15 light_text"
                id="designation" name="designation">

         
    <?php if($invite->department_id == 5): ?>

        <option value="49" <?php echo e($invite->designation_id == 49 ? 'selected' : ''); ?>>
            Hr Executive
        </option>

        <option value="48" <?php echo e($invite->designation_id == 48 ? 'selected' : ''); ?>>
            HR Manager
        </option>

    <?php else: ?>

        <option value="47" <?php echo e($invite->designation_id == 47 ? 'selected' : ''); ?>>
            Retainer Relationship Manager
        </option>

        <option value="52" <?php echo e($invite->designation_id == 52 ? 'selected' : ''); ?>>
            Retainer
        </option>

        <option value="58" <?php echo e($invite->designation_id == 58 ? 'selected' : ''); ?>>
            Sales Executive
        </option>

        <option value="45" <?php echo e($invite->designation_id == 45 ? 'selected' : ''); ?>>
            Sales Manager
        </option>

    <?php endif; ?>
            
         

        </select>

        <!-- Hidden input so value gets submitted -->
        
    </div>
</div>

</div>


<div class="row">

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="dob">Date of Birth</label>
            <input type="date" name="date_of_birth"
                   class="form-control height-50 f-15 light_text"
                   id="dob">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="marital_status">Marital Status</label>
            <select name="marital_status"
                    class="form-control height-50 f-15 light_text"
                    id="marital_status">
                <option value="">Select Status</option>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="widowed">Widowed</option>
                <option value="divorced">Divorced</option>
            </select>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="reporting_to">Reporting To</label>
            <select name="reporting_to" 
                    id="reporting_to" 
                    class="form-control height-50 f-15 light_text select-picker" 
                    data-live-search="true"
                    data-size="8">
                <option value="">-- Select Reporting Person --</option>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal6c7097547485b98631a37d273a171e9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c7097547485b98631a37d273a171e9f = $attributes; } ?>
<?php $component = App\View\Components\UserOption::resolve(['user' => $item] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('user-option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\UserOption::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c7097547485b98631a37d273a171e9f)): ?>
<?php $attributes = $__attributesOriginal6c7097547485b98631a37d273a171e9f; ?>
<?php unset($__attributesOriginal6c7097547485b98631a37d273a171e9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c7097547485b98631a37d273a171e9f)): ?>
<?php $component = $__componentOriginal6c7097547485b98631a37d273a171e9f; ?>
<?php unset($__componentOriginal6c7097547485b98631a37d273a171e9f); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group text-left">
            <label for="salary">Salary</label>
            <input type="number" 
                   name="salary" 
                   id="salary" 
                   class="form-control height-50 f-15 light_text" 
                   placeholder="Enter Salary">
        </div>
    </div>
</div>
<div class="form-group text-left">
    <label for="address">Address</label>
    <textarea name="address"
              id="address"
              rows="3"
              class="form-control f-15 light_text"
              placeholder="Enter address"></textarea>
</div>


            <div class="form-group text-left">
                <label for="password"><?php echo app('translator')->get('app.password'); ?><sup class="f-14">*</sup></label>
                <input type="text" name="password" class="form-control height-50 f-15 light_text"
                       placeholder="<?php echo app('translator')->get('placeholders.password'); ?>" id="password" value="Axveronew@2026#" readonly>
            </div>

            <?php if($globalSetting->sign_up_terms == 'yes'): ?>
                <div class="form-group text-left" >
                    <input autocomplete="off" id="read_agreement"
                        name="terms_and_conditions" type="checkbox" >
                    <label for="read_agreement"><?php echo app('translator')->get('app.acceptTerms'); ?> <a href="<?php echo e($globalSetting->terms_link); ?>" target="_blank" id="terms_link" ><?php echo app('translator')->get('app.termsAndCondition'); ?></a></label>
                </div>
            <?php endif; ?>

            <button type="button" id="submit-signup"
                    class="btn-primary f-w-500 rounded w-100 height-50 f-18">
                <?php echo app('translator')->get('app.signUp'); ?> <i class="fa fa-arrow-right pl-1"></i>
            </button>
        </div>
        <div class="forgot_pswd mt-3">
            <a href="<?php echo e(route('login')); ?>" class="justify-content-center"><?php echo app('translator')->get('app.login'); ?></a>
        </div>
        <input type="hidden" name="locale" value="<?php echo e(session()->has('locale') ? session('locale') : global_setting()->locale); ?>">
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18ad2e0d264f9740dc73fff715357c28)): ?>
<?php $attributes = $__attributesOriginal18ad2e0d264f9740dc73fff715357c28; ?>
<?php unset($__attributesOriginal18ad2e0d264f9740dc73fff715357c28); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18ad2e0d264f9740dc73fff715357c28)): ?>
<?php $component = $__componentOriginal18ad2e0d264f9740dc73fff715357c28; ?>
<?php unset($__componentOriginal18ad2e0d264f9740dc73fff715357c28); ?>
<?php endif; ?>

     <?php $__env->slot('scripts', null, []); ?> 
        <script>
            $('#email_address').change(function () {
                var email = $('#email_address').val() + $('#email_domain').val();
                $('#user-email').val(email);
            });

            $('#submit-signup').click(function () {
                console.log($('#acceptInviteForm').serialize());
                var url = "<?php echo e(route('accept_invite') . '?invite=' . $invite->invitation_code); ?>";
                $.easyAjax({
                    url: url,
                    container: '#acceptInviteForm',
                    disableButton: true,
                    buttonSelector: "#submit-signup",
                    type: "POST",
                    blockUI: true,
                    messagePosition: 'inline',
                    data: $('#acceptInviteForm').serialize(),
                    success: function (response) {
                        $('#success-msg').removeClass('d-none');
                        $('#success-msg').html(response.message);
                        $('.group').remove();
                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('dashboard')); ?>"
                        }, 20000);
                    },
                })
            });

         $('#user-name').on('keyup change', function () {

    let name = $(this).val();   // original name

    let emailName = name.toLowerCase();      // lowercase
    emailName = emailName.replace(/\s+/g,''); // remove spaces

    $('#email_address').val(emailName);
       let email = emailName + $('#email_domain').val();

    $('#user-email').val(email);

});
$(document).ready(function () {
    $('#reporting_to').selectpicker('destroy'); // pehle destroy karo agar pehle se laga ho
    $('#reporting_to').selectpicker({
        liveSearch: true,
        liveSearchPlaceholder: 'Search...',
        size: 8
    });
});
        </script>
     <?php $__env->endSlot(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald278722911781386ebf0ce0184b0f0fb)): ?>
<?php $attributes = $__attributesOriginald278722911781386ebf0ce0184b0f0fb; ?>
<?php unset($__attributesOriginald278722911781386ebf0ce0184b0f0fb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald278722911781386ebf0ce0184b0f0fb)): ?>
<?php $component = $__componentOriginald278722911781386ebf0ce0184b0f0fb; ?>
<?php unset($__componentOriginald278722911781386ebf0ce0184b0f0fb); ?>
<?php endif; ?>
<?php /**PATH /home/u536896586/domains/crmaxvero.in/public_html/resources/views/auth/invitation.blade.php ENDPATH**/ ?>