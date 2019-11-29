<?php $__env->startSection('content'); ?>

<div class="row">
	
	<div class="col-md-12">

        <!-- Session Messages -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?> 
        </div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>
		
		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">Amazon S3 Settings</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/cloud/amazon" method="POST">
                
                	<?php echo e(csrf_field()); ?>


                	<!-- Bucket Name -->
                    <div class="form-group <?php echo e($errors->has('bucket') ? 'has-error' : ''); ?>">
                        <label class="control-label">Bucket name</label>
                        <input type="text" class="form-control" name="bucket" value="<?php echo e(config('filesystems.disks.s3.bucket')); ?>"> 
                        <?php if($errors->has('bucket')): ?>
                        <span class="help-block"><?php echo e($errors->first('bucket')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- API key -->
                    <div class="form-group <?php echo e($errors->has('key') ? 'has-error' : ''); ?>">
                        <label class="control-label">API key</label>
                        <input type="text" class="form-control" name="key" value="<?php echo e(config('filesystems.disks.s3.key')); ?>"> 
                        <?php if($errors->has('key')): ?>
                        <span class="help-block"><?php echo e($errors->first('key')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- API Secret -->
                    <div class="form-group <?php echo e($errors->has('secret') ? 'has-error' : ''); ?>">
                        <label class="control-label">API Secret</label>
                        <input type="text" class="form-control" name="secret" value="<?php echo e(config('filesystems.disks.s3.secret')); ?>"> 
                        <?php if($errors->has('secret')): ?>
                        <span class="help-block"><?php echo e($errors->first('secret')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Region -->
                    <div class="form-group <?php echo e($errors->has('region') ? 'has-error' : ''); ?>">
                        <label class="control-label">منطقة</label>
                        <select class="form-control" name="region">
                            <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e($region == config('filesystems.disks.s3.region') ? 'selected' : ''); ?> value="<?php echo e($region); ?>"><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('region')): ?>
                        <span class="help-block"><?php echo e($errors->first('region')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%;">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>