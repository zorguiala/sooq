<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('head'); ?>

	<!-- Login using phone number -->
	<script src="https://identifyme.net/authRequest/lib.js" type="text/javascript"></script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- login -->
<form action="<?php echo e(Protocol::home()); ?>/auth/login" method="POST">

	<?php echo e(csrf_field()); ?>


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
					<div class="icon-object border-blue text-blue"><i class="icon-key"></i></div>
					<h5 class="content-group"><?php echo e(Lang::get('auth/login.lang_login_to_your_account')); ?> <small class="display-block"><?php echo e(Lang::get('auth/login.lang_your_credentials')); ?></small></h5>
				</div>

				<div class="form-group has-feedback has-feedback-left <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
					<input type="text" class="form-control" placeholder="<?php echo e(Lang::get('auth/login.lang_email_address')); ?>" name="email" value="<?php echo e(old('email')); ?>">
					<div class="form-control-feedback">
						<i class="icon-envelop text-muted"></i>
					</div>
					<?php if($errors->has('email')): ?>
					<span class="help-block"><?php echo e($errors->first('email')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group has-feedback has-feedback-left <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
					<input type="password" class="form-control" placeholder="<?php echo e(Lang::get('auth/login.lang_password')); ?>" name="password">
					<div class="form-control-feedback">
						<i class="icon-lock2 text-muted"></i>
					</div>
					<?php if($errors->has('password')): ?>
					<span class="help-block"><?php echo e($errors->first('password')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group login-options">
					<div class="row">
						<div class="col-sm-4">
							<label class="checkbox-inline text-grey-400">
								<input type="checkbox" class="styled" name="remember" checked="">
								<?php echo e(Lang::get('auth/login.lang_remember_me')); ?>

							</label>
						</div>

						<div class="col-sm-8 text-right">
							<ul class="list-inline list-inline-separate heading-text">
								<?php if(Helper::settings_auth()->activation_type == 'sms'): ?>
								<li><a href="<?php echo e(Protocol::home()); ?>/auth/activation/phone/resend"><?php echo e(Lang::get('auth/login.lang_resend_activation_code')); ?></a></li>
								<?php elseif(Helper::settings_auth()->activation_type == 'email'): ?>
								<li><a href="<?php echo e(Protocol::home()); ?>/auth/activation/resend"><?php echo e(Lang::get('auth/login.lang_resend_activation_link')); ?></a></li>
								<?php else: ?> 
								<?php endif; ?>
								<li><a href="<?php echo e(Protocol::home()); ?>/auth/password/reset"><?php echo e(Lang::get('auth/login.lang_forgot_password')); ?></a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="recaptcha">
				
					<?php if(Helper::settings_security()->recaptcha): ?>
						<?php echo app('captcha')->render(); ?>
					<?php endif; ?>
					
				</div>

				<script type="text/javascript">
					$(".styled, .multiselect-container input").uniform({
				        radioClass: 'choice',
        				wrapperClass: 'border-grey-400 text-grey-400'
				    });
				</script>

				<div class="form-group">
					<button type="submit" class="btn bg-blue btn-block"><?php echo e(Lang::get('auth/login.lang_login')); ?></button>
				</div>

				<div class="content-divider text-muted form-group"><span><?php echo e(Lang::get('auth/login.lang_or_sign_in_with')); ?></span></div>
				<ul class="list-inline form-group list-inline-condensed text-center list-inline-social">

					<!-- Facebook -->
					<li><a href="<?php echo e(Protocol::home()); ?>/auth/facebook" class="btn border-indigo text-indigo btn-flat btn-icon btn-rounded"><i class="icon-facebook"></i></a></li>

					<!-- Twitter -->


					<!-- Google -->
					<li><a href="<?php echo e(Protocol::home()); ?>/auth/google" class="btn border-danger-400 text-danger-400 btn-flat btn-icon btn-rounded"><i class="icon-google-plus"></i></a></li>

					<!-- Instagram -->
					<li><a href="<?php echo e(Protocol::home()); ?>/auth/instagram" class="btn border-brown text-brown btn-flat btn-icon btn-rounded"><i class="icon-instagram"></i></a></li>

					<!-- VK -->


					<!-- Pinterest -->
					<li><a href="<?php echo e(Protocol::home()); ?>/auth/pinterest" class="btn border-danger-700 text-danger-700 btn-flat btn-icon btn-rounded"><i class="icon-pinterest2"></i></a></li>

					<!-- LinkedIn -->


					<!-- Phone -->


				</ul>

				<div class="content-divider text-muted form-group"><span><?php echo e(Lang::get('auth/login.lang_dont_have_account')); ?></span></div>
				<a href="<?php echo e(Protocol::home()); ?>/auth/register" class="btn btn-default btn-block content-group"><?php echo e(Lang::get('auth/login.lang_sigh_up')); ?></a>
			</div>
		</div>
	</div>
</form>
<!-- /login -->

<script>

	function login(){
		identifymeInit({
			clientId: "<?php echo e(config('identifyme.clientId')); ?>",
			callback: "<?php echo e(config('identifyme.callback')); ?>"
			//countryCode: "",
			//phone: "",
		});
	}

	function myLoginReportHandler(encryptedReport){

		var url = "<?php echo e(config('identifyme.callback')); ?>";
		opener.location.href = url + '?' + window.location.hash.substr(1);
		close();
	}

	(function() {
		checkReportOnLoad({
			callback: myLoginReportHandler
		});
	})();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>