<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<link rel="shortcut icon" href="<?php echo e(Protocol::home()); ?>/application/public/uploads/settings/favicon/favicon.png">

	<?php echo $__env->yieldContent('seo'); ?>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900|Droid+Sans|Source+Sans+Pro|Open+Sans:300,400,700|Lato|Rubik|Fira+Sans:200,300,400" rel="stylesheet" type="text/css">

	<!-- Icon Fonts -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://rawgit.com/mendelman/icons/master/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/icons/tonicons/style.css" rel="stylesheet" type="text/css">
	<link href="https://rawgit.com/mendelman/icons/master/feather/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/icons/material/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />

	<!-- DNS Prefetch -->
	<link href='//www.youtube.com' rel='dns-prefetch'/>
	<link href='//apis.google.com' rel='dns-prefetch'/>
	<link href='//connect.facebook.net' rel='dns-prefetch'/>
	<link href='//cdnjs.cloudflare.com' rel='dns-prefetch'/>
	<link href='//www.google-analytics.com' rel='dns-prefetch'/>
	<link href='//pagead2.googlesyndication.com' rel='dns-prefetch'/>
	<link href='//googleads.g.doubleclick.net' rel='dns-prefetch'/>
	<link href='//www.gstatic.com' rel='preconnect'/>
	<link href='//www.googletagservices.com' rel='dns-prefetch'/>
	<link href='//static.xx.fbcdn.net' rel='dns-prefetch'/>
	<link href='//tpc.googlesyndication.com' rel='dns-prefetch'/>
	<link href='//syndication.twitter.com' rel='dns-prefetch'/>
	
	<!-- StyleSheets -->
	<?php if(config('app.rtl')): ?>
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/bootstrap-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/core-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/components-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/style-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">
	<?php else: ?> 
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/bootstrap.css?v=1.3.5" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/core.css?v=1.3.5" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/components.css?v=1.3.5" rel="stylesheet" type="text/css">
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/style.css?v=1.3.5" rel="stylesheet" type="text/css">
	<?php endif; ?>
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/colors.css?v=1.3.5" rel="stylesheet" type="text/css">
    
    <?php echo $__env->yieldContent('styles'); ?>

	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/core/libraries/jquery_ui/core.min.js"></script>

	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/core/app.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/forms/styling/uniform.min.js"></script>
	<!--<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/forms/validation/validate.min.js"></script>-->
	<?php echo $__env->yieldContent('javascript'); ?>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/notifications/noty.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/core/components.min.js?v=1.2"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/lib/js/emojione.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/loaders/pace.min.js"></script>

	<?php echo $__env->yieldContent('head'); ?>

	<!-- Google Analytics Code -->
	<?php echo Helper::settings_seo()->google_analytics; ?>


	<!-- Header Code -->
	
</head>

<body id="root" data-root="<?php echo e(Protocol::home()); ?>">

	<!-- Main navbar -->
	<nav class="navbar filter-bar <?php echo e(Route::currentRouteName() == 'home' ? 'navbar-transparent' : 'filled'); ?>">

	    <div class="container">

	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="icon7-bar"></span> <span class="icon7-bar"></span> <span class="icon7-bar"></span> </button>
	            <div data-no-turbolink="">
	                <a href="<?php echo e(Protocol::home()); ?>/" class="navbar-brand">
	                    <div class="logo"> <img src="<?php echo e(Route::currentRouteName() == 'home' ? Protocol::home().'/application/public/uploads/settings/logo/logo.png' : Protocol::home().'/application/public/uploads/settings/logo/footer/logo.png'); ?>"> </div>
	                </a>
	            </div>
	        </div>
	        <div class="navbar-collapse navbar-ex1-collapse collapse" aria-expanded="true" style="">
	            <ul class="nav navbar-nav navbar-right">
	                <li>
	                    <a href="https://sooqwatheq.co/"> <i class="feather-bag iconSize-2x"></i>
	                        <p>الرئيسية</p>
	                    </a>
	                </li>
					  <li>
	                    <a href="<?php echo e(Protocol::home()); ?>/stores"> <i class="feather-bag iconSize-2x"></i>
	                        <p><?php echo e(Lang::get('header.lang_browse_stores')); ?></p>
	                    </a>
	                </li>

					<?php if(Auth::check()): ?>
	                <!-- User Account -->
	                <li class="dropdown">
	                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                    	<?php if(Helper::count_user_notifications(null)): ?>
	                    	<span class="notification-bubble"> <?php echo e(Helper::count_user_notifications(null)); ?> </span>
	                    	<?php endif; ?>
	                        <div class="user-photo"> <img class="photo lozad" data-src="<?php echo e(Profile::picture(Auth::id())); ?>" alt="Thumb"> </div>
	                        <p><?php echo e(Auth::user()->first_name); ?> <span class="caret"></span></p>
	                    </a>
	                    <ul class="dropdown-menu dropdown-menu-navbar">

	                    	<!-- Account Settings -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/settings"> <i class="feather-cog"></i>
	                                <p><?php echo e(Lang::get('header.lang_account_settings')); ?></p>
	                            </a>
	                        </li>

	                        <!-- My Ads -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/ads"> <i class="feather-archive"></i>
	                                <p><?php echo e(Lang::get('header.lang_my_submissions')); ?></p>
	                            </a>
	                        </li>

							<?php if(Profile::hasStore(Auth::id())): ?>

	                        <!-- My Store -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/store/<?php echo e(Profile::hasStore(Auth::id())->username); ?>"> <i class="feather-bag"></i>
	                                <p><?php echo e(Lang::get('header.lang_my_store')); ?></p>
	                            </a>
	                        </li>

	                        <!-- Store Settings -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/store/settings"> <i class="feather-cog"></i>
	                                <p><?php echo e(Lang::get('header.lang_store_settings')); ?></p>
	                            </a>
	                        </li>

	                        <!-- Store Feedback -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/store/feedback"> <i class="feather-paper-clip"></i>
	                                <p><?php echo e(Lang::get('header.lang_store_feedback')); ?></p>
	                                <?php if(Helper::count_user_notifications('store_feedback')): ?>
	                                <span class="notification-bubble" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications('store_feedback')); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

	                        <?php elseif(Auth::user()->account_type): ?>

	                        <!-- Create Store -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/create/store"> <i class="feather-square-plus"></i>
	                                <p><?php echo e(Lang::get('header.lang_create_store')); ?></p>
	                            </a>
	                        </li>

	                        <?php endif; ?>

	                        <!-- Messages -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/inbox"> <i class="feather-mail"></i>
	                                <p><?php echo e(Lang::get('header.lang_messages')); ?></p>
	                                <?php if(Helper::count_user_notifications('messages')): ?>
	                                <span class="notification-bubble" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications(null)); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

	                        <!-- Received Offers -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/offers"> <i class="feather-loader"></i>
	                                <p><?php echo e(Lang::get('header.lang_offers')); ?></p>
	                                <?php if(Helper::count_user_notifications('offers')): ?>
	                                <span class="notification-bubble" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications('offers')); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

	                        <!-- Notifications -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/notifications"> <i class="feather-bell"></i>
	                                <p><?php echo e(Lang::get('header.lang_notifications')); ?></p>
	                                <?php if(Helper::count_user_notifications(null)): ?>
	                                <span class="notification-bubble" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications(null)); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

							<?php if(Auth::user()->is_admin): ?>

	                        <!-- Dashboard -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/dashboard" target="_blank"> <i class="feather-help"></i>
	                                <p><?php echo e(Lang::get('header.lang_dashboard')); ?></p>
	                            </a>
	                        </li>

	                        <?php endif; ?>

	                        <!-- Logout -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/auth/logout"> <i class="feather-power"></i>
	                                <p><?php echo e(Lang::get('header.lang_logout')); ?></p>
	                            </a>
	                        </li>

	                    </ul>
	                </li>
					<?php else: ?>
	                <!-- Login/Register -->
	                <li class="big-bundle">
	                    <a href="<?php echo e(Protocol::home()); ?>/auth/login"> <i class="feather-head iconSize-2x"></i>
	                        <p><?php echo e(Lang::get('update_two.lang_my_account')); ?></p>
	                    </a>
	                </li>
	                <?php endif; ?>

	                <!-- create new ad -->
	                <li class="big-bundle">
	                    <a href="<?php echo e(Protocol::home()); ?>/create"> <i class="feather-plus iconSize-2x"></i>
	                        <p><?php echo e(Lang::get('update_two.lang_add_ad')); ?></p>
	                    </a>
	                </li>

	            </ul>
	        </div>
	    </div>
	</nav>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">


			<!-- Main content -->
			<div class="content-wrapper">

	<!-- /main navbar -->
				<!-- Page Header -->
				<?php echo $__env->yieldContent('pageHeader'); ?>


				<!-- Content area -->
				<div class="content">

					<?php echo $__env->yieldContent('content'); ?>

				</div>
				<!-- /content area -->

				<!-- Footer -->
				<div class="footer text-muted">

					<!-- Page List -->
					<div class="footer-pages">
						<div class="row">
							<div class="col-md-2">
								<h4><?php echo e(Config::get('footer.column_one')); ?></h4>
								<div class="page-item">
									<?php if(Helper::get_pages('col1')): ?>
									<?php $__currentLoopData = Helper::get_pages('col1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e(Protocol::home()); ?>/page/<?php echo e($page->page_slug); ?>"><?php echo e($page->page_name); ?></a>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-2">
								<h4><?php echo e(Config::get('footer.column_two')); ?></h4>
								<div class="page-item">
									<?php if(Helper::get_pages('col2')): ?>
									<?php $__currentLoopData = Helper::get_pages('col2'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e(Protocol::home()); ?>/page/<?php echo e($page->page_slug); ?>"><?php echo e($page->page_name); ?></a>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-2">
								<h4><?php echo e(Config::get('footer.column_three')); ?></h4>
								<div class="page-item">
									<?php if(Helper::get_pages('col3')): ?>
									<?php $__currentLoopData = Helper::get_pages('col3'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e(Protocol::home()); ?>/page/<?php echo e($page->page_slug); ?>"><?php echo e($page->page_name); ?></a>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-2">
								<h4><?php echo e(Config::get('footer.column_four')); ?></h4>
								<div class="page-item">
									<a href="<?php echo e(Protocol::home()); ?>/contact"><?php echo e(Lang::get('footer.lang_contact')); ?></a>
									<a href="<?php echo e(Protocol::home()); ?>/pricing"><?php echo e(Lang::get('header.lang_pricing')); ?></a>
									<a href="<?php echo e(Protocol::home()); ?>/blog"><?php echo e(Lang::get('update_two.lang_blog')); ?></a>
									<?php if(Helper::get_pages('col4')): ?>
									<?php $__currentLoopData = Helper::get_pages('col4'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a href="<?php echo e(Protocol::home()); ?>/page/<?php echo e($page->page_slug); ?>"><?php echo e($page->page_name); ?></a>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">

								<div class="right-footer">
									
									<!-- Footer Logo -->
									<div class="footer-logo">										<a target="_blank" href="https://maroof.sa/30311"> <img border="0" src="https://sooqwatheq.co/img/footerleft.png"></a>							<img class="lozad" data-src="<?php echo e(Protocol::home()); ?>/application/public/uploads/settings/logo/footer/logo.png" alt="<?php echo e(config('app.name')); ?>">									</div><div class="col-md-12">															<!-- Newsletter -->									<div class="newsletter">										<div class="form-group">											<div class="col-lg-12">												<div class="input-group">													<input type="email" class="form-control" placeholder="<?php echo e(Lang::get('footer.lang_subscribe_to_our_newsletter')); ?>" id="newsletterEmail">													<span class="input-group-btn">														<button id="newsletterSubscribe" class="btn bg-teal" type="button"><?php echo e(Lang::get('footer.lang_subscribe')); ?></button>													</span>												</div>												<span class="help-block"><?php echo e(Lang::get('footer.lang_get_an_email_once_month')); ?></span>											</div>										</div>									</div>

									<!-- Accepted Payment Methods -->
									<div class="accepted-payment-methods">
										<img class="lozad" data-src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/payments.png" alt="">
																		<div class="accepted-payment-methods">
	<a href="https://3rbserv.com.eg/">power By Arabserv</a>												</div>

									</div>

								</div>

							</div>
						</div>
					</div>

					<div class="bottom-footer">

						<div class="footer-copyright">
							<p><?php echo config('footer.copyright'); ?> </p>
						</div>
						<!-- Social Media -->
						<div class="footer-social-media">

							<div class="footer-social-links">

								<a href="#language" data-toggle="modal" data-target="#language" target="_blank"><i class="fa fa-globe"></i></a>

								<?php if(config('social.facebook')): ?>
							  	<a href="<?php echo e(config('social.facebook')); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
							  	<?php endif; ?>

								<?php if(config('social.twitter')): ?>
							  	<a href="<?php echo e(config('social.twitter')); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
							  	<?php endif; ?>

							  	<?php if(config('social.google')): ?>
							  	<a href="<?php echo e(config('social.google')); ?>"  target="_blank"><i class="fa fa-google-plus"></i></a>
							  	<?php endif; ?>

							  	<?php if(config('social.android')): ?>
							  	<a href="<?php echo e(config('social.android')); ?>"  target="_blank"><i class="fa fa-android"></i></a>
							  	<?php endif; ?>

							  	<?php if(config('social.iphone')): ?>
							  	<a href="<?php echo e(config('social.iphone')); ?>"  target="_blank"><i class="fa fa-apple"></i></a>
							  	<?php endif; ?>

							  	<?php if(config('social.windows')): ?>
							  	<a href="<?php echo e(config('social.windows')); ?>"  target="_blank"><i class="fa fa-windows"></i></a>
							  	<?php endif; ?>

							</div>
						</div>

					</div>

				</div>
				<!-- /footer -->

				<!-- Choose Language -->
				<div id="language" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title"><?php echo e(Lang::get('footer.lang_choose_language')); ?></h6>
							</div>

							<div class="modal-body">

								<!-- Available Languages -->
								<div class="row">

									<?php $__currentLoopData = Countries::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="col-md-3">
										<div class="language-lnk">
											<a class="<?php echo e($key); ?>" href="<?php echo e(URL::current()); ?>?lang=<?php echo e($key); ?>"><?php echo e($name); ?></a>
										</div>
									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									
								</div>

							</div>

							<div class="modal-footer">
								<div class="help-translate">
									<?php echo e(Lang::get('footer.lang_do_you_speak_multiple_languages')); ?> <a href="mailto:<?php echo e(config('mail.from.address')); ?>"><?php echo e(Lang::get('footer.lang_help_translate')); ?></a> 
								</div>
								
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
	<!-- Load -->
	<script type="text/javascript">

    	// Initialize library to lazy load images
    	const observer = lozad('.lozad', {
		    threshold: 0.1
		});
		observer.observe();
		
    </script>

</body>
</html>
