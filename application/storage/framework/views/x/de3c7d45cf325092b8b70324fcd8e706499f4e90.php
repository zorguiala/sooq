<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- account offers -->
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

	<!-- Account Offers -->
	<div class="col-md-9">

		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th><?php echo e(Lang::get('table.lang_ad_details')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_offer_by')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_offer_price')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php if($offers): ?>
						<?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<!-- Ad Details -->
							<td>
								<div class="media-left media-middle">
									<a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($offer->ad_id); ?>"><img data-src="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($offer->ad_id); ?>/previews/preview_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($offer->ad_id); ?>" class="text-default text-semibold"><?php echo e($offer->ad_id); ?></a></div>
									<div class="text-muted text-size-small">
										<?php if(Helper::ad_status($offer->ad_id)): ?>
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_active')); ?>"></span>
										<?php else: ?> 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_pending')); ?>"></span>
										<?php endif; ?>
										<?php echo e(Helper::date_ago($offer->created_at)); ?>

									</div>
								</div>
							</td>

							<!-- Offer By -->
							<td class="text-center"><span class="text-muted"><?php echo e(Profile::full_name($offer->offer_by)); ?></span></td>

							<!-- Offer Price -->
							<td class="text-center"><h6 class="text-semibold"><?php echo e(Helper::ad_details($offer->ad_id, 'price')); ?></h6></td>

							<!-- Offer status -->
							<?php if(is_null($offer->is_accepted)): ?>
							<td class="text-center"><span class="label bg-grey-300"><?php echo e(Lang::get('badges.lang_pending')); ?></span></td>
							<?php elseif($offer->is_accepted): ?>
							<td class="text-center"><span class="label bg-success"><?php echo e(Lang::get('badges.lang_accepted')); ?></span></td>
							<?php else: ?> 
							<td class="text-center"><span class="label bg-danger"><?php echo e(Lang::get('badges.lang_refused')); ?></span></td>
							<?php endif; ?>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<?php if(is_null($offer->is_accepted)): ?>
											<li><a href="<?php echo e(Protocol::home()); ?>/account/offers/accept/<?php echo e($offer->id); ?>"><i class="icon-checkmark3"></i> <?php echo e(Lang::get('options.lang_accept_offer')); ?></a></li>
											<li><a href="<?php echo e(Protocol::home()); ?>/account/offers/refuse/<?php echo e($offer->id); ?>"><i class="icon-blocked"></i> <?php echo e(Lang::get('options.lang_refuse_offer')); ?></a></li>
											<li class="divider"></li>
											<?php endif; ?>
											<li><a href="<?php echo e(Protocol::home()); ?>/account/offers/delete/<?php echo e($offer->id); ?>"><i class="icon-trash"></i> <?php echo e(Lang::get('options.lang_delete_offer')); ?></a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</tbody>
				</table>

				<?php if($offers): ?>
				<div class="text-center pb-15 pt-15">
					<?php echo e($offers->links()); ?>

				</div>
				<?php endif; ?>

			</div>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>