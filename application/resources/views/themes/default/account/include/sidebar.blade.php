	
	<!-- Account Side bar -->
	<div class="col-md-3">

		<div class="content-group">
			<div class="panel panel-body bg-white mb-20 border-radius-top text-center">
				<div class="content-group-sm">
					<h6 class="text-semibold no-margin-bottom">
						{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
					</h6>

					<span class="display-block text-muted">{{ Lang::get('account/include/sidebar.lang_joined') }} {{ Helper::date_ago(Auth::user()->created_at) }}</span>
				</div>

				<a href="{{ Protocol::home() }}/account/settings" class="display-inline-block content-group-sm">
					<img data-src="{{ Profile::user_picture(Auth::id()) }}" class="lozad img-circle img-responsive" alt="" style="width: 110px; height: 110px;">
				</a>

				<ul class="list-inline list-inline-condensed no-margin-bottom account-sidebar-list">
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update_two.lang_add_ad') }}" style="background-color: rgba(0, 0, 0, 0.05)" href="{{ Protocol::home() }}/create" class="btn btn-rounded btn-icon text-grey"><i class="icon-plus3"></i></a></li>
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('upgrade.lang_upgrade_your_account') }}" style="background-color: rgba(0, 0, 0, 0.05)" href="{{ Protocol::home() }}/upgrade" class="btn btn-rounded btn-icon text-grey"><i class="icon-crown"></i></a></li>
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('footer.lang_contact') }}" style="background-color: rgba(0, 0, 0, 0.05)" href="{{ Protocol::home() }}/contact" class="btn btn-rounded btn-icon text-grey"><i class="icon-bubbles8"></i></a></li>
					<li><a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('badges.lang_trashed') }}" style="background-color: rgba(0, 0, 0, 0.05)" href="{{ Protocol::home() }}/account/ads/trash" class="btn btn-rounded btn-icon text-grey"><i class="icon-trash-alt"></i></a></li>
				</ul>
			</div>

			<div class="panel no-border-top no-border-radius-top">
				<ul class="navigation">
					<li class="navigation-header">{{ Lang::get('account/include/sidebar.lang_navigation') }}</li>

					<!-- Account Settings -->
					<li><a href="{{ Protocol::home() }}/account/settings" ><i class="icon-equalizer2"></i> {{ Lang::get('header.lang_account_settings') }}</a></li>

					@if (Profile::hasStore(Auth::id()))
					<!-- Store Settings -->
					<li><a href="{{ Protocol::home() }}/account/store/settings" ><i class="icon-hammer-wrench"></i> {{ Lang::get('header.lang_store_settings') }}</a></li>

					<!-- Store Settings -->
					<li><a href="{{ Protocol::home() }}/account/store/reviews" ><i class="icon-star-full2"></i> {{ Lang::get('update_three.lang_manage_reviews') }}</a></li>

					<!-- Store Feedback -->
					<li><a href="{{ Protocol::home() }}/account/store/feedback" ><i class="icon-feed"></i> {{ Lang::get('account/include/sidebar.lang_store_feedback') }}</a></li>
					@endif

					<!-- My Submissions -->
					<li><a href="{{ Protocol::home() }}/account/ads" ><i class="icon-list"></i> {{ Lang::get('account/include/sidebar.lang_my_submissions') }}</a></li>

					<!-- Messages -->
					<li><a href="{{ Protocol::home() }}/account/inbox" ><i class="icon-bubbles6"></i> {{ Lang::get('account/include/sidebar.lang_messages') }} 
					@if (Helper::count_user_notifications('messages'))
					<span class="badge bg-danger">{{ Helper::count_user_notifications('messages') }}</span>
					@endif
					</a></li>

					<!-- Notifications -->
					<li><a href="{{ Protocol::home() }}/account/notifications" ><i class="icon-bell3"></i> {{ Lang::get('account/include/sidebar.lang_notifications') }}  @if (Helper::count_user_notifications(null))
					<span class="badge bg-danger">{{ Helper::count_user_notifications(null) }}</span>
					@endif</a></li>

					<!-- Manage Comments -->
					<li><a href="{{ Protocol::home() }}/account/comments" ><i class="icon-bubbles2"></i> {{ Lang::get('account/include/sidebar.lang_manage_comments') }}</a></li>

					<!-- Offers -->
					<li><a href="{{ Protocol::home() }}/account/offers" ><i class="icon-cash3"></i> {{ Lang::get('account/include/sidebar.lang_received_offers') }} @if (Helper::count_user_notifications('offers'))
					<span class="badge bg-danger">{{ Helper::count_user_notifications('offers') }}</span>
					@endif</a></li>

					<!-- My Favorites -->
					<li><a href="{{ Protocol::home() }}/account/favorite/ads" ><i class="icon-heart5"></i> {{ Lang::get('account/include/sidebar.lang_my_favorites') }}</a></li>

					<!-- Auto Share Settings -->
					<li><a href="{{ Protocol::home() }}/account/autoshare" ><i class="icon-share"></i> {{ Lang::get('account/include/sidebar.lang_autoshare_settings') }}</a></li>

					<!-- Payments History -->
					<li><a href="{{ Protocol::home() }}/account/payments" ><i class="icon-credit-card2"></i> {{ Lang::get('account/include/sidebar.lang_payments_history') }}</a></li>

					<!-- Login History -->
					<li><a href="{{ Protocol::home() }}/account/login/history" ><i class="icon-blocked"></i> {{ Lang::get('account/include/sidebar.lang_login_history') }}</a></li>

					<!-- Two Factor Authentication
					<li><a href="{{ Protocol::home() }}/account/secure/2fa" ><i class="icon-safe"></i> Two Factor Authentication</a></li> -->

					<li class="navigation-divider"></li>

					<!-- Logout -->
					<li><a href="{{ Protocol::home() }}/logout"><i class="icon-switch2"></i> {{ Lang::get('account/include/sidebar.lang_logout') }}</a></li>
				</ul>
			</div>
		</div>
		
	</div>