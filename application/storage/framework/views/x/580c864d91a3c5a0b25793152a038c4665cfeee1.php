	
	<!-- Account Side bar -->
	<div class="col-md-3">

		<div class="content-group">
			<div class="panel panel-body bg-white mb-20 border-radius-top text-center">
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
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_add_ad')); ?>" style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/create" class="btn btn-rounded btn-icon text-grey"><i class="icon-plus3"></i></a></li>
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('upgrade.lang_upgrade_your_account')); ?>" style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/upgrade" class="btn btn-rounded btn-icon text-grey"><i class="icon-crown"></i></a></li>
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('footer.lang_contact')); ?>" style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/contact" class="btn btn-rounded btn-icon text-grey"><i class="icon-bubbles8"></i></a></li>
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('badges.lang_trashed')); ?>" style="background-color: rgba(0, 0, 0, 0.05)" href="<?php echo e(Protocol::home()); ?>/account/ads/trash" class="btn btn-rounded btn-icon text-grey"><i class="icon-trash-alt"></i></a></li>
				</ul>
			</div>

			<div class="panel no-border-top no-border-radius-top">
				<ul class="navigation">
					<li class="navigation-header"><?php echo e(Lang::get('account/include/sidebar.lang_navigation')); ?></li>

					<!-- Account Settings -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/settings" ><i class="icon-equalizer2"></i> <?php echo e(Lang::get('header.lang_account_settings')); ?></a></li>

					<?php if(Profile::hasStore(Auth::id())): ?>
					<!-- Store Settings -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/store/settings" ><i class="icon-hammer-wrench"></i> <?php echo e(Lang::get('header.lang_store_settings')); ?></a></li>

					<!-- Store Settings -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/store/reviews" ><i class="icon-star-full2"></i> <?php echo e(Lang::get('update_three.lang_manage_reviews')); ?></a></li>

					<!-- Store Feedback -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/store/feedback" ><i class="icon-feed"></i> <?php echo e(Lang::get('account/include/sidebar.lang_store_feedback')); ?></a></li>
					<?php endif; ?>

					<!-- My Submissions -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/ads" ><i class="icon-list"></i> <?php echo e(Lang::get('account/include/sidebar.lang_my_submissions')); ?></a></li>

					<!-- Messages -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/inbox" ><i class="icon-bubbles6"></i> <?php echo e(Lang::get('account/include/sidebar.lang_messages')); ?> 
					<?php if(Helper::count_user_notifications('messages')): ?>
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications('messages')); ?></span>
					<?php endif; ?>
					</a></li>

					<!-- Notifications -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/notifications" ><i class="icon-bell3"></i> <?php echo e(Lang::get('account/include/sidebar.lang_notifications')); ?>  <?php if(Helper::count_user_notifications(null)): ?>
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications(null)); ?></span>
					<?php endif; ?></a></li>

					<!-- Manage Comments -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/comments" ><i class="icon-bubbles2"></i> <?php echo e(Lang::get('account/include/sidebar.lang_manage_comments')); ?></a></li>

					<!-- Offers -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/offers" ><i class="icon-cash3"></i> <?php echo e(Lang::get('account/include/sidebar.lang_received_offers')); ?> <?php if(Helper::count_user_notifications('offers')): ?>
					<span class="badge bg-danger"><?php echo e(Helper::count_user_notifications('offers')); ?></span>
					<?php endif; ?></a></li>

					<!-- My Favorites -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/favorite/ads" ><i class="icon-heart5"></i> <?php echo e(Lang::get('account/include/sidebar.lang_my_favorites')); ?></a></li>

					<!-- Auto Share Settings -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/autoshare" ><i class="icon-share"></i> <?php echo e(Lang::get('account/include/sidebar.lang_autoshare_settings')); ?></a></li>

					<!-- Payments History -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/payments" ><i class="icon-credit-card2"></i> <?php echo e(Lang::get('account/include/sidebar.lang_payments_history')); ?></a></li>

					<!-- Login History -->
					<li><a href="<?php echo e(Protocol::home()); ?>/account/login/history" ><i class="icon-blocked"></i> <?php echo e(Lang::get('account/include/sidebar.lang_login_history')); ?></a></li>

					<!-- Two Factor Authentication
					<li><a href="<?php echo e(Protocol::home()); ?>/account/secure/2fa" ><i class="icon-safe"></i> Two Factor Authentication</a></li> -->

					<li class="navigation-divider"></li>

					<!-- Logout -->
					<li><a href="<?php echo e(Protocol::home()); ?>/logout"><i class="icon-switch2"></i> <?php echo e(Lang::get('account/include/sidebar.lang_logout')); ?></a></li>
				</ul>
			</div>
		</div>
		
	</div>