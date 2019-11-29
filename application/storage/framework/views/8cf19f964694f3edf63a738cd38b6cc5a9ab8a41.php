

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	
	<div class="col-md-8">
		
		<div class="panel">

			<div class="panel-body">
				
				<ul class="media-list chat-list content-group">
					<li class="media date-step">
						<span>"<?php echo e($ad->title); ?>" <?php echo e(Lang::get('update_three.lang_all_reviews')); ?></span>
					</li>

					<?php if($reviews): ?>
					<?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li class="media">
						<div class="media-left">
							<a>
								<img data-src="<?php echo e(Profile::user_picture($review->user_id)); ?>" class="lozad img-circle img-md" alt="<?php echo e(Profile::full_name($review->user_id)); ?>">
							</a>
						</div>

						<div class="media-body">
							<div class="media-content mb-10"><?php echo e($review->comment); ?></div>
							<span class="media-annotation mt-20 mr-10"><?php echo e(Profile::full_name($review->user_id)); ?></span>
							<span class="media-annotation mt-20 dotted mr-10">
								<?php switch($review->rating):
									case (1): ?>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<?php break; ?>

									<?php case (2): ?>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<?php break; ?>

									<?php case (3): ?>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<?php break; ?>

									<?php case (4): ?>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<?php break; ?>

									<?php case (5): ?>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<?php break; ?>

									<?php default: ?>
									'N/A'

								<?php endswitch; ?>
							</span>
							<span class="media-annotation mt-20 dotted mr-10"><?php echo e(Helper::date_ago($review->created_at)); ?></span>
						</div>
					</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>

				</ul>

			</div>
		</div>

	</div>

	<div class="col-md-4">
			
		<div class="content-group">
			<div class="panel-body bg-blue border-radius-top text-center lozad" data-background-image="<?php echo e(Helper::store_cover($store->username)); ?>" style=" background-size: contain;">
				<div class="content-group-sm">
					<h5 class="text-semibold no-margin-bottom">
						<?php echo e($store->title); ?>

					</h5>

					<span class="display-block"><?php echo e($store->username); ?></span>
				</div>

				<a href="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>" class="display-inline-block content-group-sm">
					<img data-src="<?php echo e($store->logo); ?>" class="lozad img-circle img-responsive" alt="" style="width: 120px; height: 120px;">
				</a>

				<ul class="list-inline no-margin-bottom">

					<?php
					$style = 'background-color: white;
						    color: #5f5d5d;
						    border-radius: 100%;
						    height: 35px;
						    width: 35px;
						    vertical-align: middle;
						    padding-top: 7px;
						    padding-right: 11px;
						    padding-left: 10px;';
					?>

					<?php if(!is_null($store->fb_page)): ?>
					<li><a style="<?php echo e($style); ?>" target="_blank" href="<?php echo e($store->fb_page); ?>" class="btn bg-transparent btn-rounded btn-icon legitRipple"><i class="icon-facebook"></i></a></li>
					<?php endif; ?>

					<?php if(!is_null($store->tw_page)): ?>
					<li><a style="<?php echo e($style); ?>" target="_blank" href="<?php echo e($store->tw_page); ?>" class="btn bg-transparent btn-rounded btn-icon legitRipple"><i class="icon-twitter"></i></a></li>
					<?php endif; ?>

					<?php if(!is_null($store->go_page)): ?>
					<li><a style="<?php echo e($style); ?>" target="_blank" href="<?php echo e($store->go_page); ?>" class="btn bg-transparent btn-rounded btn-icon legitRipple"><i class="icon-google-plus"></i></a></li>
					<?php endif; ?>

				</ul>
			</div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>