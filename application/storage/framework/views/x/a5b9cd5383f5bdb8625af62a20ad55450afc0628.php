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
                    <span class="caption-subject bold font-blue uppercase">Nexmo اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/sms/nexmo" method="POST">
                
                	<?php echo e(csrf_field()); ?>


                    <!-- Nexmo Key -->
                    <div class="form-group <?php echo e($errors->has('nexmo_key') ? 'has-error' : ''); ?>">
                        <label class="control-label">Nexmo مفتاح</label>
                        <input type="text" class="form-control" name="nexmo_key" value="<?php echo e(config('services.nexmo.key')); ?>">
                        <?php if($errors->has('nexmo_key')): ?>
                        <span class="help-block"><?php echo e($errors->first('nexmo_key')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Nexmo Secret -->
                    <div class="form-group <?php echo e($errors->has('nexmo_secret') ? 'has-error' : ''); ?>">
                        <label class="control-label">Nexmo سري</label>
                        <input type="text" class="form-control" name="nexmo_secret" value="<?php echo e(config('services.nexmo.secret')); ?>">
                        <?php if($errors->has('nexmo_secret')): ?>
                        <span class="help-block"><?php echo e($errors->first('nexmo_secret')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Nexmo SMS From -->
                    <div class="form-group <?php echo e($errors->has('sms_from') ? 'has-error' : ''); ?>">
                        <label class="control-label">Nexmo الرسائل القصيرة من</label>
                        <input type="text" class="form-control" name="sms_from" value="<?php echo e(config('services.nexmo.sms_from')); ?>">
                        <?php if($errors->has('sms_from')): ?>
                        <span class="help-block"><?php echo e($errors->first('sms_from')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>