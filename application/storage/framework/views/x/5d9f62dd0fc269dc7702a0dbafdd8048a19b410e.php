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
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <span class="caption-subject font-blue-madison bold uppercase"> منع IP الجديد</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="<?php echo e(Protocol::home()); ?>/dashboard/firewall/add" method="POST">
                	<?php echo e(csrf_field()); ?>

                    <div class="form-body">

                    	<!-- IP Address -->
                        <div class="form-group form-md-line-input <?php echo e($errors->has('ip_address') ? 'has-error' :''); ?>">
                            <label class="col-md-2 control-label" for="ip_address">عنوان IP</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="ip_address" placeholder="IP Address" name="ip_address" value="<?php echo e(old('ip_address')); ?>">
                                <div class="form-control-focus"> </div>
                                <?php if($errors->has('ip_address')): ?>
                                <span class="help-block"><?php echo e($errors->first('ip_address')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">اضافة IP</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>