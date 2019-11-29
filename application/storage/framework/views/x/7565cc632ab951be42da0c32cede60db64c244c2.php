<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- account ads -->
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
	
	<!-- Account Ads -->
	<div class="col-md-9">
		
		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th><?php echo e(Lang::get('table.lang_ad_details')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_category')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_visits')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_price')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_ends_at')); ?></th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>

						<?php if($ads): ?>
						<?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<!-- Ad Details -->
							<td>
								<div class="media-left media-middle">
									<a target="_blank" href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($ad->ad_id); ?>"><img data-src="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($ad->ad_id); ?>/thumbnails/thumbnail_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a target="_blank" href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($ad->ad_id); ?>" class="text-default text-semibold text-dots"><?php echo e($ad->title); ?></a></div>
									<div class="text-muted text-size-small">
										<?php if($ad->status): ?>
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_active')); ?>"></span>
										<?php else: ?> 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_pending')); ?>"></span>
										<?php endif; ?>
										<?php echo e(Helper::date_ago($ad->created_at)); ?>

									</div>
								</div>
							</td>

							<!-- Ad Category -->
							<td class="text-center">
								<a class="text-muted" href="<?php echo e(Helper::get_category($ad->category, true)); ?>" target="_blank"><?php echo e(Helper::get_category($ad->category)); ?></a>
							</td>

							<!-- Ad Vists -->
							<td class="text-center"><span class="text-success-600"><i class="icon-stats-growth2 position-left"></i> <?php echo e(number_format($ad->views)); ?></span></td>

							<!-- Ad Price -->
							<td class="text-center"><h6 class="text-semibold"><?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?></h6></td>

							<!-- Ad Status -->
							<td class="text-center">
								<?php if($ad->is_archived): ?>
								<span class="label bg-danger"><?php echo e(Lang::get('badges.lang_archived')); ?></span>
								<?php elseif($ad->is_featured): ?>
								<span class="label bg-warning"><?php echo e(Lang::get('badges.lang_featured')); ?></span>
								<?php else: ?>
								<span class="label bg-blue"><?php echo e(Lang::get('badges.lang_normal')); ?></span>
								<?php endif; ?>
							</td>

							<!-- Ends At -->
							<td class="text-center text-muted">
								<?php echo e(Helper::dateToFormatted($ad->ends_at)); ?>

							</td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">

											<!-- Edit Ad -->
											<li><a href="<?php echo e(Protocol::home()); ?>/account/ads/edit/<?php echo e($ad->ad_id); ?>"><i class="icon-pencil4"></i> <?php echo e(Lang::get('options.lang_edit_ad')); ?></a></li>

											<!-- Delete Ad -->
											<li><a href="<?php echo e(Protocol::home()); ?>/account/ads/delete/<?php echo e($ad->ad_id); ?>"><i class="icon-trash-alt"></i> <?php echo e(Lang::get('options.lang_move_to_trash')); ?></a></li>

											<!-- Upgrade Ad -->
											<li><a href="<?php echo e(Protocol::home()); ?>/account/ads/upgrade/<?php echo e($ad->ad_id); ?>"><i class="icon-chess-queen"></i> <?php echo e(Lang::get('options.lang_upgrade_ad')); ?></a></li>

											<?php if(!$ad->is_archived): ?>
											<!-- Archive Ad -->
											<li><a href="<?php echo e(Protocol::home()); ?>/account/ads/archive/<?php echo e($ad->ad_id); ?>"><i class="icon-archive"></i> <?php echo e(Lang::get('options.lang_archive_ad')); ?></a></li>
											<?php endif; ?>

											<!-- Stats Ad -->
											<li><a href="<?php echo e(Protocol::home()); ?>/account/ads/stats/<?php echo e($ad->ad_id); ?>"><i class="icon-stats-bars2"></i> <?php echo e(Lang::get('options.lang_statistics')); ?></a></li>
											
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>

					</tbody>
				</table>

				<?php if($ads): ?>
				<div class="text-center pb-15">
					<?php echo e($ads->links()); ?>

				</div>
				<?php endif; ?>

			</div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>