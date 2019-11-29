<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-12">
        
        <!-- Session Messages -->
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?> 
        </div>
        <?php endif; ?>
        
        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">اختيار موضوع</span>
                </div>
            </div>

            <div class="portlet-body">
                
                <form method="POST" action="<?php echo e(Protocol::home()); ?>/dashboard/themes">
                    
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group form-md-line-input <?php echo e($errors->has('theme') ? 'has-error' : ''); ?>">
                        <select class="form-control" id="theme" name="theme">
                            <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e((config('view.theme') == basename($theme)) ? "selected" : ""); ?> value="<?php echo e(basename($theme)); ?>"><?php echo e(basename($theme)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <label for="theme">اختيار موضوع</label>
                        <?php if($errors->has('theme')): ?>
                        <span class="help-block"><?php echo e($errors->first('theme')); ?></span>
                        <?php endif; ?>
                    </div>                 

                    <button type="submit" class="btn default btn-block">تحديث</button>

                </form>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>