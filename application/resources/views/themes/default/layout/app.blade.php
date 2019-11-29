<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <meta name="description" content="سوق واثق اكبر سوق تجاري اون لاين بالمملكه العربية السعودية بيع وشراء جميع السلع المستخدمه و الجديدة بأرخص الاسعار واقوي العروض والتواصل مع البائع مباشراً">
	<link rel="shortcut icon" href="{{ Protocol::home() }}/application/public/uploads/settings/favicon/favicon.png">
		<link href="https://sooqwatheq.co/fares/css/header3.css" rel="stylesheet">
		<link rel="stylesheet" id="switcher-css" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/color4.css" title="color4" media="all" />
		<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	@yield('seo')




	<!-- Google Fonts -->

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900|Droid+Sans|Source+Sans+Pro|Open+Sans:300,400,700|Lato|Rubik|Fira+Sans:200,300,400" rel="stylesheet" type="text/css">



	<!-- Icon Fonts -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link href="https://rawgit.com/mendelman/icons/master/icomoon/styles.css" rel="stylesheet" type="text/css">

	<link href="{{ Protocol::home() }}/content/assets/front-end/css/icons/tonicons/style.css" rel="stylesheet" type="text/css">

	<link href="https://rawgit.com/mendelman/icons/master/feather/style.css" rel="stylesheet" type="text/css">

	<link href="{{ Protocol::home() }}/content/assets/front-end/css/icons/material/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />



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


		<link href="{{ Protocol::home() }}/content/assets/front-end/css/bootstrap-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">

	<link href="{{ Protocol::home() }}/content/assets/front-end/css/core-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">



	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/style-rtl.css?v=1.3.5" rel="stylesheet" type="text/css">


	<link href="{{ Protocol::home() }}/content/assets/front-end/css/stylesheet.css" rel="stylesheet">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/header1.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ Protocol::home() }}/content/assets/front-end/icons/font/flaticon.css">


    @yield ('styles')



	<!-- Core JS files -->

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/libraries/jquery.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/libraries/jquery_ui/core.min.js"></script>



	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/app.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/ui/ripple.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/forms/validation/validate.min.js"></script>

	@yield ('javascript')

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/libraries/bootstrap.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/notifications/noty.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/components.min.js?v=1.2"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/lib/js/emojione.min.js"></script>

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/loaders/pace.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.js"></script>



	@yield ('head')



	<!-- Google Analytics Code -->

	{!! Helper::settings_seo()->google_analytics !!}



	<!-- Header Code -->

	{!! Helper::settings_seo()->header_code !!}



</head>





<body>
	<header class="scroll-fix">
		<div class="container">
			<div class="ui labeled small icon menu" style="    height: 70px;">
				<a class="item" href="/create" id="add">
					<img src="{{ Protocol::home() }}/content/assets/front-end/icons/svg/010-plus.svg" class="ui" width="25" alt="">
					<h5> <span class="font-dubai-regular"> أضف إعلان الآن</span></h5>
				</a>
				<a class="item" href="/auth/login" id="in">
					<img src="{{ Protocol::home() }}/content/assets/front-end/icons/svg/012-user.svg" class="ui" width="25" alt="">
					<h5> <span class="font-dubai-regular"> دخول </span></h5>
				</a>
				<a class="item" href="/stores" id="stores">
					<img src="{{ Protocol::home() }}/content/assets/front-end/icons/svg/019-shop-1.svg" class="ui" width="25" alt="">
					<h5> <span class="font-dubai-regular">متاجر</span></h5>
				</a>

				<div class="right menu">
					<a href="/" >
						<h2 style="padding: 20px;    float: left;"> <span class="font-dubai-regular"> سوق واثق</span>
						</h2><img width="60" height="60" alt="">
					</a>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="searchbar">
			<div class="ui right action left icon input wid87 ">
				<i class="search icon"></i>
				<input type="text" placeholder="بحث" style="text-align: center; font-family: 'cairo',sans-serif;">
				<div class="ui basic floating dropdown button item" style="background-color: white !important;">
					<i class="dropdown icon"></i>
					<div class="text">This Page</div>

					<div class="menu">
						<div class="item">This Organization</div>
						<div class="item">Entire Site</div>
					</div>
				</div>
				<div class="ui basic floating dropdown button item" style="background-color: white !important;">
					<i class="dropdown icon"></i>
					<div class="text">This Page</div>

					<div class="menu">
						<div class="item">This Organization</div>
						<div class="item">Entire Site</div>
					</div>
				</div>
			</div>
		</div>
	</div>

			{{-- <header id="header">
				<div class="header-top">
					<div class="container">
						<div class="header-container clearfix">
							<a href="#" class="logo pull-left"></a>
							<div class="header-nav navbar navbar-main-slide pull-left">
								<i class="fa fa-bars mobileMenuNav mobileMenuSwitcher onlyMobile"></i>
								<nav class="menu-container">
									<i class="fa fa-times close-menu mobileMenuSwitcher onlyMobile"></i>
									<ul class="nav navbar-nav navbar-main">
                                    <li class="active"><a href="/index.php">الرئيسية</a></li>
                                    	<li><a href="/category/1000">القسم العام</a></li>
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="#">
											السيارات <i class="fa fa-angle-down customColor"></i></a>
											<ul class="dropdown-menu">
												<li><a href="/category/cars/Ford">فورد  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars/Toyota">تويوتا  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars/Nissan">نسيان  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars/jeep">جيب  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars/GMC">جمس  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars/honda">هوندا  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars/kia">كيا  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/cars">... المزيد  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>

											</ul>
										</li>	
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="#">
											العقارات <i class="fa fa-angle-down customColor"></i></a>
											<ul class="dropdown-menu">
												<li><a href="/category/Real%20estate/Land%20for%20sale">أرض للبيع  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate/apartment%20for%20rent">شقة للايجار  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate/apartment%20for%20sale">شقة للبيع  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate/Building%20for%20sale">عمارة للبيع  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate/Building%20for%20rent">عمارة للايجار  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate/A%20kiss%20shop">محل للتقبيل  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate/Shop%20for%20rent">محل للايجار  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/category/Real%20estate">... المزيد  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>

											</ul>
										</li>	
																			<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="#">
											الاجهزه <i class="fa fa-angle-down customColor"></i></a>
											<ul class="dropdown-menu">
												<li><a href="/category/Devices/SONY">SONY - سوني </a></li>
												<li><a href="/category/Devices/HTC">HTC - إتش تي سي </a></li>
												<li><a href="/category/Devices/Toshiba">TOSHIBA - توشيبا </a></li>
												<li><a href="/category/Devices/Apple">Apple - أبل  </a></li>
												<li><a href="/category/Devices/Nokia">Nokia - نوكيا  </a></li>
												<li><a href="/category/Devices/Watch">WATCH - واتش  </a></li>
												<li><a href="/category/Devices/Galaxy">GALAXY - جلاكسي </a></li>
												<li><a href="/category/Devices">... المزيد  </a></li>
											</ul>
										</li>
                         <li><a href="/category/Financing">التمويل والتقسيط </a></li>
										<li class="dropdown">
											<a data-toggle="dropdown" class="dropdown-toggle" href="#">
											{{ Config::get('footer.column_four') }} <i class="fa fa-angle-down customColor"></i></a>
											<ul class="dropdown-menu">
												<li><a href="/stores">{{ Lang::get('header.lang_browse_stores') }}<i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/pricing">{{ Lang::get('header.lang_pricing') }}  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/contact">{{ Lang::get('footer.lang_contact') }}  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/page/Terms-of-use">شروط الاستخدام  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/page/aboutus">من نحن  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/page/Treaty">المعاهده  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
											</ul>
										</li>
					@if (Auth::check())
	                <!-- User Account -->
	                <li class="dropdown">
	                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                    	@if (Helper::count_user_notifications(null))
	                    	<span class="cart-qty font-main font-weight-semibold color-main customBgColor circle"> {{ Helper::count_user_notifications(null) }} </span>
	                    	@endif
	                        <div class="user-photo"> <img class="photo lozad" data-src="{{ Profile::picture(Auth::id()) }}" alt="Thumb"> </div>
	                        <p>{{ Auth::user()->first_name }} <span class="caret"></span></p>
	                    </a>
	                    <ul class="dropdown-menu dropdown-menu-navbar">

	                    	<!-- Account Settings -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/settings"> <i class="feather-cog"></i>
	                                <p>{{ Lang::get('header.lang_account_settings') }}</p>
	                            </a>
	                        </li>

	                        <!-- My Ads -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/ads"> <i class="feather-archive"></i>
	                                <p>{{ Lang::get('header.lang_my_submissions') }}</p>
	                            </a>
	                        </li>

							@if (Profile::hasStore(Auth::id()))

	                        <!-- My Store -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/store/{{ Profile::hasStore(Auth::id())->username }}"> <i class="feather-bag"></i>
	                                <p>{{ Lang::get('header.lang_my_store') }}</p>
	                            </a>
	                        </li>

	                        <!-- Store Settings -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/store/settings"> <i class="feather-cog"></i>
	                                <p>{{ Lang::get('header.lang_store_settings') }}</p>
	                            </a>
	                        </li>

	                        <!-- Store Feedback -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/store/feedback"> <i class="feather-paper-clip"></i>
	                                <p>{{ Lang::get('header.lang_store_feedback') }}</p>
	                                @if (Helper::count_user_notifications('store_feedback'))
	                                <span class="notification-bubble" style="margin-top: 12px;"> {{ Helper::count_user_notifications('store_feedback') }} </span>
	                                @endif
	                            </a>
	                        </li>

	                        @elseif (Auth::user()->account_type)

	                        <!-- Create Store -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/create/store"> <i class="feather-square-plus"></i>
	                                <p>{{ Lang::get('header.lang_create_store') }}</p>
	                            </a>
	                        </li>

	                        @endif

	                        <!-- Messages -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/inbox"> <i class="feather-mail"></i>
	                                <p>{{ Lang::get('header.lang_messages') }}</p>
	                                @if (Helper::count_user_notifications('messages'))
	                                <span class="cart-qty font-main font-weight-semibold color-main customBgColor circle" style="margin-top: 12px;"> {{ Helper::count_user_notifications(null) }} </span>
	                                @endif
	                            </a>
	                        </li>

	                        <!-- Received Offers -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/offers"> <i class="feather-loader"></i>

	                                <p>{{ Lang::get('header.lang_offers') }}</p>
	                                @if (Helper::count_user_notifications('offers'))
	                                <span class="cart-qty font-main font-weight-semibold color-main customBgColor circle" style="margin-top: 12px;"> {{ Helper::count_user_notifications('offers') }} </span>
	                                @endif
	                            </a>
	                        </li>

	                        <!-- Notifications -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/account/notifications"> <i class="feather-bell"></i>
	                                <p>{{ Lang::get('header.lang_notifications') }}</p>
	                                @if (Helper::count_user_notifications(null))
	                                <span class="cart-qty font-main font-weight-semibold color-main customBgColor circle" style="margin-top: 12px;"> {{ Helper::count_user_notifications(null) }} </span>
	                                @endif
	                            </a>
	                        </li>

							@if (Auth::user()->is_admin)

	                        <!-- Dashboard -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/dashboard/ads" target="_blank"> <i class="feather-help"></i>
	                                <p>{{ Lang::get('header.lang_dashboard') }}</p>
	                            </a>
	                        </li>

	                        @endif

	                        <!-- Logout -->
	                        <li>
	                            <a href="{{ Protocol::home() }}/auth/logout"> <i class="feather-power"></i>
	                                <p>{{ Lang::get('header.lang_logout') }}</p>
	                            </a>
	                        </li>

	                    </ul>
	                </li>
					@else
	                <!-- Login/Register -->
	                <li class="big-bundle">
	                    <a href="{{ Protocol::home() }}/auth/login"> 
	                        <p>{{ Lang::get('update_two.lang_my_account') }}</p>
	                    </a>
	                </li>

	                @endif
                                                        										<li><a href="#" data-target=".example-modal-lg" data-toggle="modal" class="font-additional color-main text-uppercase hover-focus-color"><i class="fa fa-search" style="font-size:17px; color:white"></i></a></li>
	                <!-- create new ad -->
									</ul>
								</nav>
							</div>
							<div class="header-right pull-right">

									<div class="subscribe-button">
									</div>
						</div>
					</div>
				</div>
			</header>  --}}
	<!-- /main navbar -->





	<!-- Page container -->

	<div class="page-container">



		<!-- Page content -->

		<div class="page-content">





			<!-- Main content -->

			<div class="content-wrapper">




				<!-- Page Header -->
				@yield('pageHeader')


				<!-- Content area -->

				<div class="content">



					@yield('content')



				</div>

				<!-- /content area -->



			</div>


			<footer>
					<div class="footer-links">
						<div class="container">
							<div class="inner btn-group-vertical">
								<div class="col ">
									<div class="btn-group">
										<h5 id="btnGroupVerticalDrop1" data-toggle="dropdown" class="dropdown-toggle">الحصول على
											التطبيق<i class="visible-xs ion-chevron-down"></i></h5>
										<div class="dropdown-menu footer-content" aria-labelledby="btnGroupVerticalDrop1">
											<div class="footer-app">
												<p><span style="color: red; font-weight: 700;">قريبا سوف يكون تطبيق سوق واثق على
														الإنترنت</span></p>
												<div>
													<a class="apple-store" href="#">قم بتنزيله من متجر <span>Apple</span></a>
												</div>
												<div>
													<a class="google-store" href="#">قم بتنزيله من متجر<span>Google
															Play</span></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col ">
									<div class="btn-group">
										<h5 id="btnGroupVerticalDrop2" data-toggle="dropdown" class="dropdown-toggle">المساعدة<i
												class="visible-xs ion-chevron-down"></i></h5>
										<div class="dropdown-menu footer-content footer-information"
											aria-labelledby="btnGroupVerticalDrop2">
											<ul class="list-unstyled">
												<li><a href="#">إتصل بنا</a></li>
												<li><a href="#">ترقية الحساب</a></li>
												<li><a href="#">المدونه</a></li>
												<li><a href="#"> من نحن</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col ">
									<div class="btn-group">
										<h5 id="btnGroupVerticalDrop3" data-toggle="dropdown" class="dropdown-toggle">روابط هامه<i
												class="visible-xs ion-chevron-down"></i></h5>
										<div class="dropdown-menu footer-content" aria-labelledby="btnGroupVerticalDrop3">
											<ul class="list-unstyled">
												<li><a href="#"> مركز رفع</a></li>
												<li><a href="#"> المنتدي</a></li>
												<li><a href="#">المعاهدة</a></li>
												<li><a href="#"> شروط الاستخدام</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col ">
									<div class="btn-group">
										<h5 id="btnGroupVerticalDrop6" data-toggle="dropdown" class="dropdown-toggle">
											معلومات الادارة<i class="visible-xs ion-chevron-down"></i></h5>
										<div class="dropdown-menu footer-content footer-content"
											aria-labelledby="btnGroupVerticalDrop6">
											<div class="contact-block">
												<div class="phone">
			
													<h4>(+966) 059 999 4012</h4>
												</div>
												<div class="address">
													<p>السعودية مدينة الدمام</p>
													<p>admin@sooqwatheq.co</p>
												</div>
											</div>
											<div class="social">
												<a href="https://www.facebook.com/sooqwatheq1/" class="facebook" target="_blank"
													title="Facebook">Facebook</a>
												<a href="https://twitter.com/sooqwatheq" target="_blank" class="twitter"
													title="Twitter">Twitter</a>
												<a href="https://plus.google.com/111259664293342210225" target="_blank"
													class="google" title="Google+">Google</a>
												<a href="#" target="_blank" class="instagram" title="Youtube">Instagram</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="footer-copyright">
						<div class="container">
							<div class="inner">
								<div class="payment">
									<img src="image/catalog/ptblock/payment.png" alt="payment">
								</div>
							</div>
						</div>
					</div>
				</footer>
				

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

	<!-- Load -->

	<script type="text/javascript">



    	// Initialize library to lazy load images

    	const observer = lozad('.lozad', {

		    threshold: 0.1

		});

		observer.observe();

		

    </script>

		<!-- Loader -->
		<!--Owl Carousel-->
	    <script src="/fares/plugins/owl-carousel/owl.carousel.min.js"></script>
	    <!-- bxSlider -->
		<script>
				$('.ui.dropdown.item').dropdown();
			$('#in').hover(function () {
				$("#in > img").attr("src", "{{ Protocol::home() }}/content/assets/front-end/icons/svg/013-user-1.svg");
			})
			$('#in').mouseleave(function () {
				$("#in > img").attr("src", "{{ Protocol::home() }}/content/assets/front-end/icons/svg/012-user.svg");
		
			})
		
		
			$('#add').hover(function () {
				$("#add > img").attr("src", "{{ Protocol::home() }}/content/assets/front-end/icons/svg/011-plus-1.svg");
			})
			$('#add').mouseleave(function () {
				$("#add > img").attr("src", "{{ Protocol::home() }}/content/assets/front-end/icons/svg/010-plus.svg");
		
			})
		
			$('#stores').hover(function () {
				$("#stores > img").attr("src", "{{ Protocol::home() }}/content/assets/front-end/icons/svg/020-shop-2.svg");
			})
			$('#stores').mouseleave(function () {
				$("#stores > img").attr("src", "{{ Protocol::home() }}/content/assets/front-end/icons/svg/019-shop-1.svg");
		
			})
		
		</script>

</body>
<script src="{{ Protocol::home() }}/content/assets/front-end/js/index.js"></script>
</html>

