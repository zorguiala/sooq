

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- account messages -->
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
	
	<!-- Account messages -->
	<div class="col-md-9">

		<div class="panel">
			
			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th><?php echo e(Lang::get('table.lang_ad_details')); ?></th>
							<th class="col-md-2"><?php echo e(Lang::get('table.lang_from')); ?></th>
							<th class="col-md-2"><?php echo e(Lang::get('table.lang_subject')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>

					<tbody>

						<?php if($messages): ?>
						<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<!-- Ad ID -->
							<td>
								<div class="media-left media-middle">
									<a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($message->ad_id); ?>"><img data-src="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($message->ad_id); ?>/previews/preview_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($message->ad_id); ?>" class="text-default text-semibold"><?php echo e($message->ad_id); ?></a></div>
									<div class="text-muted text-size-small">
										<?php if(Helper::ad_status($message->ad_id)): ?>
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_active')); ?>"></span>
										<?php else: ?> 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_pending')); ?>"></span>
										<?php endif; ?>
										<?php echo e(Helper::date_ago($message->created_at)); ?>

									</div>
								</div>
							</td>

							<!-- Message From -->
							<td><span class="text-muted"><?php echo e(Profile::full_name_by_username($message->msg_from)); ?></span></td>
							
							<!-- Subject -->
							<td><span class="text-muted"><?php echo e($message->subject); ?></span></td>

							<!-- Message Status -->
							<?php if($message->is_read): ?>
							<td class="text-center"><span class="label label-default"><?php echo e(Lang::get('badges.lang_read')); ?></span></td>
							<?php else: ?> 
							<td class="text-center"><span class="label label-primary"><?php echo e(Lang::get('badges.lang_unread')); ?></span></td>
							<?php endif; ?>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="<?php echo e(Protocol::home()); ?>/account/inbox/read/<?php echo e($message->id); ?>"><i class="icon-eye"></i> <?php echo e(Lang::get('options.lang_read_message')); ?></a></li>
											<li><a href="<?php echo e(Protocol::home()); ?>/account/inbox/reply?to=<?php echo e($message->msg_from); ?>&ad=<?php echo e($message->ad_id); ?>"><i class="icon-bubbles8"></i> <?php echo e(Lang::get('options.lang_reply_message')); ?></a></li>
											<li class="divider"></li>
											<li><a href="<?php echo e(Protocol::home()); ?>/account/inbox/delete/<?php echo e($message->id); ?>"><i class="icon-trash"></i> <?php echo e(Lang::get('options.lang_delete_message')); ?></a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
						
					</tbody>
				</table>

				<?php if($messages): ?>
				<div class="text-center pb-15">
					<?php echo e($messages->links()); ?>

				</div>
				<?php endif; ?>
			</div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>