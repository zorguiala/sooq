

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(Protocol::home()); ?>/auth/password/reset" method="POST">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">

			<!-- Sessions Message -->
			<?php if(Session::has('error')): ?>
			<div class="alert bg-danger alert-styled-left">
				<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
				<?php echo e(Session::get('error')); ?>

		    </div>
		    <?php endif; ?>

		    <?php if(Session::has('success')): ?>
			<div class="alert bg-success alert-styled-left">
				<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
				<?php echo e(Session::get('success')); ?>

		    </div>
		    <?php endif; ?>

			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-danger text-danger"><i class="icon-spinner11"></i></div>
					<h5 class="content-group"><?php echo e(Lang::get('auth/password/reset.lang_password_recovery')); ?> <small class="display-block"><?php echo e(Lang::get('auth/password/reset.lang_we_will_send_you_instructions')); ?></small></h5>
				</div>

				<div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
					<input class="form-control" placeholder="<?php echo e(Lang::get('auth/password/reset.lang_your_email')); ?>" type="email" name="email">
					<div class="form-control-feedback">
						<i class="icon-reset text-muted"></i>
					</div>
					<?php if($errors->has('email')): ?>
					<span class="help-block">
						<?php echo e($errors->first('email')); ?>

					</span>
					<?php endif; ?>
				</div>

				<?php echo e(csrf_field()); ?>


				<?php if(Helper::settings_security()->recaptcha): ?>
					<?php echo app('captcha')->render(); ?>
				<?php endif; ?>

				<button type="submit" class="btn bg-default btn-block legitRipple"><?php echo e(Lang::get('auth/password/reset.lang_reset_password')); ?></button>
			</div>
		</div>
	</div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>