<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- notifications -->
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

	<div class="col-md-4">

		<div class="content-group">
			<div class="panel-body bg-white mb-20 border-radius-top text-center" style="border-radius: 3px;box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.12);">
				<div class="content-group-sm">
					<h6 class="text-semibold no-margin-bottom">
						<?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?>

					</h6>

					<span class="display-block text-muted"><?php echo e(Lang::get('account/include/sidebar.lang_joined')); ?> <?php echo e(Helper::date_ago(Auth::user()->created_at)); ?></span>
				</div>

				<a href="<?php echo e(Protocol::home()); ?>/account/settings" class="display-inline-block content-group-sm">
					<img data-src="<?php echo e(Profile::user_picture(Auth::id())); ?>" class="lozad img-circle img-responsive" alt="" style="width: 110px; height: 110px;">
				</a>

				<ul class="list-inline list-inline-condensed no-margin-bottom account-sidebar-list">
					<li><a style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/create" class="btn btn-rounded btn-icon text-grey"><i class="icon-plus3"></i></a></li>
					<li><a style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/upgrade" class="btn btn-rounded btn-icon text-grey"><i class="icon-crown"></i></a></li>
					<li><a style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/contact" class="btn btn-rounded btn-icon text-grey"><i class="icon-bubbles8"></i></a></li>
					<li><a style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/account/ads/trash" class="btn btn-rounded btn-icon text-grey"><i class="icon-trash-alt"></i></a></li>
				</ul>
			</div>

			<div class="panel no-border-top no-border-radius-top">
				<ul class="navigation">
					<li class="navigation-header"><?php echo e(Lang::get('account/include/sidebar.lang_notifications')); ?></li>

					<!-- Ads Notifications -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/notifications/ads" class="text-uppercase"><i class="icon-archive"></i> <?php echo e(Lang::get('account/include/sidebar.lang_ads_notifications')); ?> 
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications('ads')); ?></span>
					</a></li>

					<!-- Comments Notifications -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/notifications/comments" class="text-uppercase"><i class="icon-bubbles6"></i> <?php echo e(Lang::get('account/include/sidebar.lang_comments_notifications')); ?> 
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications('comments')); ?></span>
					</a></li>

					<!-- Likes Notifications -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/notifications/likes" class="text-uppercase"><i class="icon-heart5"></i> <?php echo e(Lang::get('account/include/sidebar.lang_likes_notifications')); ?> 
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications('likes')); ?></span>
					</a></li>

					<!-- Warnings Notifications -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/notifications/warnings" class="text-uppercase"><i class="icon-spam"></i> <?php echo e(Lang::get('account/include/sidebar.lang_warnings_notifications')); ?> 
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications('warnings')); ?></span>
					</a></li>

				</ul>
			</div>
		</div>
		
	</div>
	
	<!-- Notifications -->
	<div class="col-md-8">
		
		<div class="panel panel-flat">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th><?php echo e(Lang::get('table.lang_ad_details')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_notification_type')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_date')); ?></th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>

						<?php if($notifications): ?>
						<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<!-- Ad ID -->
							<td>
								<a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($n->ad_id); ?>" target="_blank" class="text-semibold text-muted"><?php echo e($n->ad_id); ?></a>
							</td>

							<!-- Type -->
							<td class="text-center">
								<span class="label bg-success"><?php echo e(Lang::get('badges.lang_ad_accepted')); ?></span>
							</td>

							<!-- Status -->
							<td class="text-center">
								<?php if($n->is_read): ?>
								<span class="label bg-grey"><?php echo e(Lang::get('badges.lang_read')); ?></span>
								<?php else: ?> 
								<span class="label bg-blue"><?php echo e(Lang::get('badges.lang_unread')); ?></span>
								<?php endif; ?>
							</td>

							<!-- Date -->
							<td class="text-center text-muted">
								<?php echo e(Helper::date_ago($n->created_at)); ?>

							</td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<!-- Delete notification -->
									<li><a href="<?php echo e(Protocol::home()); ?>/account/notifications/ads/delete/<?php echo e($n->id); ?>"><i class="icon-trash-alt"></i></a></li>
								</ul>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>

					</tbody>
				</table>

				<?php if($notifications): ?>
				<div class="text-center mb-15 mt-15">
					<?php echo e($notifications->links()); ?>

				</div>
				<?php endif; ?>

			</div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>