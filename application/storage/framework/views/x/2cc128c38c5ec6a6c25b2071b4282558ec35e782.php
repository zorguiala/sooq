<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Store Reviews -->
<div class="row">
		
	<!-- Session Messages -->
	<div class="col-md-12">
		<?php if(Session::has('success')): ?>
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('success')); ?>

	    </div>
	    <?php endif; ?>
	    <?php if(Session::has('error')): ?>
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('error')); ?>

	    </div>
	    <?php endif; ?>
	</div>

	<?php echo $__env->make(Theme::get().'.account.include.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<div class="col-md-9">

		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th><?php echo e(Lang::get('table.lang_ad_details')); ?></th>
							<th class="col-md-2"><?php echo e(Lang::get('update_three.lang_review_by')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('update_three.lang_rating')); ?></th>
							<th class="col-md-2"><?php echo e(Lang::get('update_three.lang_comment')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('update_three.lang_status')); ?></th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php if($r): ?>
						<?php $__currentLoopData = $r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<!-- Ad Details -->
							<td>
								<div class="media-left media-middle">
									<a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($review->ad_id); ?>"><img data-src="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($review->ad_id); ?>/previews/preview_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($review->ad_id); ?>" class="text-default text-semibold"><?php echo e($review->ad_id); ?></a></div>
									<div class="text-muted text-size-small">
										<?php echo e(Helper::date_ago($review->created_at)); ?>

									</div>
								</div>
							</td>

							<!-- Review By -->
							<td class="text-muted">
								<?php echo e(Profile::full_name($review->user_id)); ?>

							</td>

							<!-- Rating -->
							<td class="text-center">
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
							</td>

							<!-- Comment -->
							<td class="text-muted">
								<?php echo e($review->comment); ?>

							</td>

							<!-- Status -->
							<td class="text-center">
								<?php if($review->is_approved): ?>
								<span class="label label-success"><?php echo e(Lang::get('update_three.lang_active')); ?></span>
								<?php else: ?>
								<span class="label label-danger"><?php echo e(Lang::get('update_three.lang_pending')); ?></span>
								<?php endif; ?>
							</td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<?php if($review->is_approved): ?>
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_three.lang_hide_review')); ?>" href="<?php echo e(Protocol::home()); ?>/account/store/reviews/hide/<?php echo e($review->id); ?>"><i class="icon-cross2"></i></a>
									</li>
									<?php else: ?>
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_three.lang_show_review')); ?>" href="<?php echo e(Protocol::home()); ?>/account/store/reviews/publish/<?php echo e($review->id); ?>"><i class="icon-checkmark3"></i></a>
									</li>
									<?php endif; ?>
								</ul>
							</td>

						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</tbody>
				</table>

				<?php if($r): ?>
				<div class="text-center pb-15 pt-15">
					<?php echo e($r->links()); ?>

				</div>
				<?php endif; ?>

			</div>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>