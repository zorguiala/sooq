<?php $__env->startSection('content'); ?>

<!-- Maintenance Mode -->
<div class="row">

	<div class="col-md-12">
		
		<!-- Session Messages -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?> 
        </div>
        <?php endif; ?>

        <!-- Session Messages -->
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>

		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">وضع الصيانة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/maintenance" method="POST">

                	<?php echo e(csrf_field()); ?>



					<p class="text-muted">
						While in maintenance mode, users can't access your website. Useful if you need to make changes on your website. Use the following button to toggle maintenance mode ON/OFF.<br><br>
						Maintenance mode is: <b><?php echo e($maintenance->is_maintenance ? 'ON' : 'OFF'); ?></b> 
                        <?php if($maintenance->is_maintenance): ?>
                        <br><br>
                        Disable maintenance(Reserve Link): <b><a href="<?php echo e(Protocol::home()); ?>/maintenance?token=<?php echo e(config('maintenance.token')); ?>" target="_blank"><?php echo e(Protocol::home()); ?>/maintenance?token=<?php echo e(config('maintenance.token')); ?></a></b><br>
                        <span class="help-block text-danger">You need to save this link, In case you can't access dashboard to disable maintenance.</span>
                        <?php endif; ?>
					</p>

                    <?php if(!$maintenance->is_maintenance): ?>
                    <input type="hidden" name="maintenance" value="1">
                    <?php else: ?>
                    <input type="hidden" name="maintenance" value="0">
                    <?php endif; ?>

					<hr>

					<!-- Enable/Disable -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn blue"><?php echo e($maintenance->is_maintenance ? 'Disable Maintenance Mode' : 'Enable Maintenance Mode'); ?> </button>
                    </div>

                </form>
            </div>
        </div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>