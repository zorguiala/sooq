

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/icons/et-line-font/et-line.css" rel="stylesheet" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pageHeader'); ?>

<div class="plans-header">
	
	<div class="plans-header-body">
		<h2 class="text-uppercase"><?php echo e(Lang::get('pricing.lang_header_upgrade_now')); ?></h2>
	</div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Pricing Plans -->
<div class="row">

	<!-- Main Features -->
	<div class="col-md-12">
		
		<div class="heading-title">
            <h2><?php echo e(Lang::get('pricing.lang_the_best_value')); ?></h2>
            <p><?php echo e(Lang::get('pricing.lang_the_best_value_p')); ?></p>
        </div>

		<div class="row">
			
			<div class="features">
				
				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-trophy"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_featured_ads')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_featured_ads_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-lock"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_encrypted_payment')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_encrypted_payment_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-bargraph"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_statistics')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_statistics_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-megaphone"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_no_advertisements')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_no_advertisements_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-envelope"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_feedback')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_feedback_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-linegraph"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_autoshare')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_autoshare_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-shield"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_trusted_seller')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_trusted_seller_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-map"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_online_store')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_online_store_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-chat"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_support')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_support_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-pictures"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_more_images')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_more_images_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-hourglass"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_no_limiting')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_no_limiting_p')); ?></p>
					</div>
				</div>

				<div class="col-md-4">
					<!-- plan feature -->
					<div class="plan-feature">
						<div class="plan-icon">
							<i class="et-line-happy"></i>
						</div>
						<h2><?php echo e(Lang::get('pricing.lang_more')); ?></h2>
						<p><?php echo e(Lang::get('pricing.lang_more_p')); ?></p>
					</div>
				</div>

			</div>

			<!-- Upgrade Now -->
			<div class="col-md-12 text-center">
			
				<a class="upgrade-btn legitRipple" href="<?php echo e(Protocol::home()); ?>/upgrade"><?php echo e(Lang::get('pricing.lang_get_started_now')); ?></a>
				
			</div>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>