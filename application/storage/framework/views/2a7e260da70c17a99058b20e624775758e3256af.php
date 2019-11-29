

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

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
		
		<form action="<?php echo e(Protocol::home()); ?>/contact" method="POST">
			<?php echo e(csrf_field()); ?>

			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-envelop5"></i></div>
					<h5 class="content-group"><?php echo e(Lang::get('contact.lang_get_in_touch')); ?> <small class="display-block"><?php echo e(Lang::get('contact.lang_contact_us_directly')); ?></small></h5>
				</div>

				<div class="form-group  <?php echo e($errors->has('full_name') ? 'has-error' : ''); ?>">
					<label><?php echo e(Lang::get('contact.lang_full_name')); ?></label>
					<input type="text" name="full_name" class="form-control" placeholder="<?php echo e(Lang::get('contact.lang_full_name_placeholder')); ?>" value="<?php echo e(old('email')); ?>" value="<?php echo e(old('full_name')); ?>">
					<?php if($errors->has('full_name')): ?>
					<span class="help-block"><?php echo e($errors->first('full_name')); ?></span>
					<?php endif; ?>
				</div>

				<!-- Email Address -->
				<div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
					<label><?php echo e(Lang::get('contact.lang_email_address')); ?></label>
					<input type="email" name="email" class="form-control" placeholder="<?php echo e(Lang::get('contact.lang_email_address_placeholder')); ?>" value="<?php echo e(old('email')); ?>">
					<?php if($errors->has('email')): ?>
					<span class="help-block"><?php echo e($errors->first('email')); ?></span>
					<?php endif; ?>
				</div>

				<!-- Phone Number -->
				<div class="form-group  <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
					<label><?php echo e(Lang::get('contact.lang_phone')); ?></label>
					<input type="text" name="phone" class="form-control" placeholder="<?php echo e(Lang::get('contact.lang_phone_placeholder')); ?>" value="<?php echo e(old('phone')); ?>">
					<?php if($errors->has('phone')): ?>
					<span class="help-block"><?php echo e($errors->first('phone')); ?></span>
					<?php endif; ?>
				</div>

				<!-- Subject -->
				<div class="form-group  <?php echo e($errors->has('subject') ? 'has-error' : ''); ?>">
					<label><?php echo e(Lang::get('contact.lang_subject')); ?></label>
					<input type="text" name="subject" class="form-control" placeholder="<?php echo e(Lang::get('contact.lang_subject_placeholder')); ?>" value="<?php echo e(old('subject')); ?>">
					<?php if($errors->has('subject')): ?>
					<span class="help-block"><?php echo e($errors->first('subject')); ?></span>
					<?php endif; ?>
				</div>

				<!-- Your Message -->
				<div class="form-group  <?php echo e($errors->has('message') ? 'has-error' : ''); ?>">
					<label><?php echo e(Lang::get('contact.lang_your_message')); ?></label>
					<textarea rows="5" cols="5" class="form-control" placeholder="<?php echo e(Lang::get('contact.lang_your_message_placeholder')); ?>" name="message"><?php echo e(old('message')); ?></textarea>
					<?php if($errors->has('message')): ?>
					<span class="help-block"><?php echo e($errors->first('message')); ?></span>
					<?php endif; ?>
				</div>

				<div class="text-right">
					<button type="submit" class="btn btn-default"><?php echo e(Lang::get('contact.lang_send_message')); ?></button>
				</div>
				
			</div>
		</form>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>