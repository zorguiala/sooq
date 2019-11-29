<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	<div class="col-md-6" style="margin: 0 auto !important;float: none;">

		<!-- Session Messages -->
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
		
		<form action="<?php echo e(Protocol::home()); ?>/upgrade" method="POST">

			<?php echo e(csrf_field()); ?>


			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
					<h5 class="content-group"><?php echo e(Lang::get('upgrade.lang_upgrade_your_account')); ?> <small class="display-block"><?php echo e(Lang::get('upgrade.lang_select_payment_method')); ?></small></h5>
				</div>

				<!-- Payment Method -->
				<div class="form-group has-feedback has-feedback-left <?php echo e($errors->has('method') ? 'has-error' : ''); ?>">
					<select data-placeholder="<?php echo e(Lang::get('upgrade.lang_select_payment_method')); ?>" class="select" name="method">
						<option></option>
						<?php if($settings->is_paypal): ?>
						<option value="paypal">PayPal</option>
						<?php endif; ?>

						<?php if($settings->is_2checkout): ?>
						<option value="2checkout">2Checkout</option>
						<?php endif; ?>

						<?php if($settings->is_stripe): ?>
						<option value="stripe">Stripe</option>
						<?php endif; ?>

						<?php if($settings->is_mollie): ?>
						<option value="mollie">Mollie</option>
						<?php endif; ?>

						<?php if($settings->is_paystack): ?>
						<option value="paystack">PayStack</option>
						<?php endif; ?>

						<?php if($settings->is_paysafecard): ?>
						<option value="paysafecard">PaySafeCard</option>
						<?php endif; ?>

						<?php if($settings->is_razorpay): ?>
						<option value="razorpay">RazorPay</option>
						<?php endif; ?>

						<?php if($settings->is_barion): ?>
						<option value="barion">Barion</option>
						<?php endif; ?>

						<?php if($settings->is_cashu): ?>
						<option value="cashu">CashU</option>
						<?php endif; ?>

						<?php if($settings->is_pagseguro): ?>
						<option value="pagseguro">PagSeguro</option>
						<?php endif; ?>

						<?php if($settings->is_paytm): ?>
						<option value="paytm">Paytm</option>
						<?php endif; ?>

						<?php if($settings->is_interkassa): ?>
						<option value="interkassa">InterKassa</option>
						<?php endif; ?>

					</select>
					<?php if($errors->has('method')): ?>
					<span class="help-block"><?php echo e($errors->first('method')); ?></span>
					<?php endif; ?>
				</div>

				<div class="form-group checkout-btn">
					<button type="submit" class="btn bg-default-400 btn-block"><?php echo e(Lang::get('upgrade.lang_continue')); ?></button>
				</div>
				<span class="help-block text-center no-margin"><?php echo e(Lang::get('upgrade.lang_terms')); ?> <a href="<?php echo e(config('pages.terms')); ?>" target="_blank"><?php echo e(Lang::get('upgrade.lang_terms_condition')); ?></a></span>
			</div>

	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>