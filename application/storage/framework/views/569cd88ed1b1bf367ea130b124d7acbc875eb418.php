<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
<script type='text/javascript'>
(function(a) {
    a.fn.lazyload=function(b){var c={threshold: 0,failurelimit:0,event:"scroll",effect:"show",container:window;};
if(b) {
    a.extend(c,b);
}
var d=this;if("scroll"==c.event) {
    a(c.container).bind("scroll",function(b){var e=0;d.each(function(){if(a.abovethetop(this,c)||a.leftofbegin(this,c)){
}
else if(!a.belowthefold(this,c)&&!a.rightoffold(this,c)) {
    a(this).trigger("appear");
}
else {
    if(e++>c.failurelimit){return false;
}}});
var f=a.grep(d,function(a) {
    return!a.loaded;
});
d=a(f);
})}
this.each(function() {
var b=this;if(undefined==a(b).attr("original")){a(b).attr("original",a(b).attr("src"));
}
if("scroll"!=c.event||undefined==a(b).attr("src")||c.placeholder==a(b).attr("src")||a.abovethetop(b,c)||a.leftofbegin(b,c)||a.belowthefold(b,c)||a.rightoffold(b,c)) {
if(c.placeholder){a(b).attr("src",c.placeholder);
}
else {
a(b).removeAttr("src");
}
b.loaded=false;
}
else {
b.loaded=true;
}
a(b).one("appear",function() {
if(!this.loaded){a("<img />").bind("load",function(){a(b).hide().attr("src",a(b).attr("original"))[c.effect](c.effectspeed);b.loaded=true;
}).attr("src",a(b).attr("original"));
}});
if("scroll"!=c.event) {
a(b).bind(c.event,function(c){if(!b.loaded){a(b).trigger("appear");
}})}});
a(c.container).trigger(c.event);return this;
};
a.belowthefold=function(b,c) {
if(c.container===undefined||c.container===window){var d=a(window).height()+a(window).scrollTop();
}
else {
var d=a(c.container).offset().top+a(c.container).height();
}
return d<=a(b).offset().top-c.threshold;
};
a.rightoffold=function(b,c) {
if(c.container===undefined||c.container===window){var d=a(window).width()+a(window).scrollLeft();
}
else {
var d=a(c.container).offset().left+a(c.container).width();
}
return d<=a(b).offset().left-c.threshold;
};
a.abovethetop=function(b,c) {
if(c.container===undefined||c.container===window){var d=a(window).scrollTop();
}
else {
var d=a(c.container).offset().top;
}
return d>=a(b).offset().top+c.threshold+a(b).height();
};
a.leftofbegin=function(b,c) {
if(c.container===undefined||c.container===window){var d=a(window).scrollLeft();
}
else {
var d=a(c.container).offset().left;
}
return d>=a(b).offset().left+c.threshold+a(b).width();
};
a.extend(a.expr[":"], {
"below-the-fold"
:"$.belowthefold(a, {threshold : 0, container: window})","above-the-fold": "!$.belowthefold(a, {threshold : 0, container: window})","right-of-fold":"$.rightoffold(a, {threshold : 0, container: window})","left-of-fold":"!$.rightoffold(a, {threshold : 0, container: window})";
})})(jQuery);$(function() {
$("img").lazyload({placeholder: "http://i22.servimg.com/u/f22/15/42/72/40/grey10.gif",effect:"fadeIn",threshold:"-50";
})})</script>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <meta name="description" content="سوق واثق اكبر سوق تجاري اون لاين بالمملكه العربية السعودية بيع وشراء جميع السلع المستخدمه و الجديدة بأرخص الاسعار واقوي العروض والتواصل مع البائع مباشراً">
	<link rel="shortcut icon" href="<?php echo e(Protocol::home()); ?>/application/public/uploads/settings/favicon/favicon.png">
		<link href="https://sooqwatheq.co/fares/css/master.css" rel="stylesheet">
		<link href="https://sooqwatheq.co/fares/css/header3.css" rel="stylesheet">
		<link rel="stylesheet" id="switcher-css" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/color1.css" title="color1" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/color2.css" title="color2" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/color3.css" title="color3" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/color4.css" title="color4" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="https://sooqwatheq.co/fares/plugins/switcher/css/color5.css" title="color5" media="all" />
		<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>





	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/core/app.js"></script>

	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/ui/ripple.min.js"></script>

	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/forms/validation/validate.min.js"></script>

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

	<?php echo Helper::settings_seo()->header_code; ?>




</head>





<body class="animated-css home-construction-v3" data-scrolling-animations="false" id="root" data-root="<?php echo e(Protocol::home()); ?>">
			<!-- Loader Landing Page -->
			<div id="ip-container" class="ip-container">
				<div class="ip-header" >
					<div class="ip-loader">
						<div class="text-center">
							<div class="ip-logo">
								<a class="logo"></a>
							</div>
						</div>
						<svg class="ip-inner" width="60px" height="60px" viewBox="0 0 80 80">
							<path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,39.3,10z"/>
							<path id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
						</svg> 
					</div>
				</div>
			</div>
			<!-- Start Switcher -->
			<div class="switcher-wrapper">	
				<div class="demo_changer">
					<div class="demo-icon customBgColor"><i class="fa fa-cog fa-spin fa-2x"></i></div>
					<div class="form_holder">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="predefined_styles">
									<div class="skin-theme-switcher">
										<h4>تغير اللون</h4>
										<a href="#" data-switchcolor="color1" class="styleswitch" style="background-color:#ff8300;"> </a>
										<a href="#" data-switchcolor="color2" class="styleswitch" style="background-color:#4fb0fd;"> </a>
										<a href="#" data-switchcolor="color3" class="styleswitch" style="background-color:#ffc73c;"> </a>							
										<a href="#" data-switchcolor="color4" class="styleswitch" style="background-color:#dc2c2c;"> </a>
										<a href="#" data-switchcolor="color5" class="styleswitch" style="background-color:#02cc8b;"> </a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Switcher -->
			<header id="header">
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
											<?php echo e(Config::get('footer.column_four')); ?> <i class="fa fa-angle-down customColor"></i></a>
											<ul class="dropdown-menu">
												<li><a href="/stores"><?php echo e(Lang::get('header.lang_browse_stores')); ?><i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/pricing"><?php echo e(Lang::get('header.lang_pricing')); ?>  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/contact"><?php echo e(Lang::get('footer.lang_contact')); ?>  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/page/Terms-of-use">شروط الاستخدام  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/page/aboutus">من نحن  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
												<li><a href="/page/Treaty">المعاهده  <i class="fa fa-minus" style="font-size:3px; color:gray"></i></a></li>
											</ul>
										</li>
					<?php if(Auth::check()): ?>
	                <!-- User Account -->
	                <li class="dropdown">
	                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                    	<?php if(Helper::count_user_notifications(null)): ?>
	                    	<span class="cart-qty font-main font-weight-semibold color-main customBgColor circle"> <?php echo e(Helper::count_user_notifications(null)); ?> </span>
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
	                                <span class="cart-qty font-main font-weight-semibold color-main customBgColor circle" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications(null)); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

	                        <!-- Received Offers -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/offers"> <i class="feather-loader"></i>

	                                <p><?php echo e(Lang::get('header.lang_offers')); ?></p>
	                                <?php if(Helper::count_user_notifications('offers')): ?>
	                                <span class="cart-qty font-main font-weight-semibold color-main customBgColor circle" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications('offers')); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

	                        <!-- Notifications -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/account/notifications"> <i class="feather-bell"></i>
	                                <p><?php echo e(Lang::get('header.lang_notifications')); ?></p>
	                                <?php if(Helper::count_user_notifications(null)): ?>
	                                <span class="cart-qty font-main font-weight-semibold color-main customBgColor circle" style="margin-top: 12px;"> <?php echo e(Helper::count_user_notifications(null)); ?> </span>
	                                <?php endif; ?>
	                            </a>
	                        </li>

							<?php if(Auth::user()->is_admin): ?>

	                        <!-- Dashboard -->
	                        <li>
	                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads" target="_blank"> <i class="feather-help"></i>
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
	                    <a href="<?php echo e(Protocol::home()); ?>/auth/login"> 
	                        <p><?php echo e(Lang::get('update_two.lang_my_account')); ?></p>
	                    </a>
	                </li>

	                <?php endif; ?>
                                                        										<li><a href="#" data-target=".example-modal-lg" data-toggle="modal" class="font-additional color-main text-uppercase hover-focus-color"><i class="fa fa-search" style="font-size:17px; color:white"></i></a></li>
	                <!-- create new ad -->
									</ul>
								</nav>
							</div>
							<div class="header-right pull-right">

									<div class="subscribe-button">
<button onclick="window.location.href='/create'" type="submit" value="Subscribe" name="subscribe"  class="btn btn-primary font-additional hvr-wobble-bottom"><?php echo e(Lang::get('update_two.lang_add_ad')); ?></button>
									</div>
						</div>
					</div>
				</div>
			</header> 
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
	<!-- /main navbar -->





	<!-- Page container -->

	<div class="page-container">



		<!-- Page content -->

		<div class="page-content">





			<!-- Main content -->

			<div class="content-wrapper">




				<!-- Page Header -->
				<?php echo $__env->yieldContent('pageHeader'); ?>


				<!-- Content area -->

				<div class="content">



					<?php echo $__env->yieldContent('content'); ?>



				</div>

				<!-- /content area -->



			<footer id="footer">
				<a class="goToTop font-additional color-main text-uppercase" href="#" id="scrollTop">
					<i class="fa fa-angle-up"></i>
					<span>اعلي</span>
				</a>
				<div class="footer-top">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 clearfix wow fadeInLeft" data-wow-delay="0.3s">
								<a href="#" class="footer-top_logo pull-left"></a>
                                
								<div class="footer-top_container clearfix">
  <span class="font-main color-additional"><p align="right">هذا الموقع لا يتدخل في أي معاملة، ولا يتعامل مع المدفوعات أو الشحن أو تقديم خدمات الضمان أو تقديم حماية المشتري</p></span>
									<ul class="footer-social-list pull-left">
										<li><a href="https://www.facebook.com/sooqwatheq1/"><span class="social_facebook" aria-hidden="true"></span></a></li>
										<li><a href="https://twitter.com/sooqwatheq"><span class="social_twitter" aria-hidden="true"></span></a></li>
										<li><a href="https://plus.google.com/111259664293342210225"><span class="social_googleplus" aria-hidden="true"></span></a></li>
										<li><a href="#"><span class="social_instagram" aria-hidden="true"></span></a></li>
                                        <li><a href="/?lang=en">EN</a></li>
										<li><a href="/?lang=ar">AR</a></li>
									</ul>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 clearfix wow fadeInUp" data-wow-delay="0.3s">
<h4 class="footer-top_title color-main font-additional font-weight-bold text-uppercase" align="center">
								المساعدة</h4>
<div class="footer-top_container clearfix" align="center">
									<ul class="footer-nav">
										<li><a href="/contact" class="font-main font-weight-normal color-additional"> 
										إتصل بنا</a></li>
										<li><a href="/pricing/" class="font-main font-weight-normal color-additional"> 
										ترقية الحساب</a></li>
										<li><a href="/blog" class="font-main font-weight-normal color-additional"> 
										المدونه</a></li>
										<li><a href="/page/aboutus" class="font-main font-weight-normal color-additional"> 
										من نحن</a></li>
									</ul>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 clearfix wow fadeInUp" data-wow-delay="0.3s">
								<h4 class="footer-top_title color-main font-additional font-weight-bold text-uppercase" align="center">
								روابط هامه</h4>
								<div class="footer-top_container clearfix" align="center">
									<ul class="footer-nav">
										<li><a href="/page/upurl" class="font-main font-weight-normal color-additional"> 
										مركز رفع</a></li>
										<li><a href="/page/Vb" class="font-main font-weight-normal color-additional"> 
										المنتدي</a></li>
										<li><a href="/page/Treaty" class="font-main font-weight-normal color-additional"> 
										المعاهدة</a></li>
										<li><a href="/page/Terms-of-use" class="font-main font-weight-normal color-additional"> 
										شروط الاستخدام</a></li>
									</ul>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 clearfix wow fadeInRight" data-wow-delay="0.3s">
								<h4 class="footer-top_title color-main font-additional font-weight-bold text-uppercase" align="center">
								معلومات الادارة</h4>
								<div class="footer-top_container clearfix  pull-right">
									<ul class="footer-contact">
										<li class="font-main font-weight-normal color-additional">
											<p align="center">السعودية مدينة الدمام</p> <span class="icon_pin" aria-hidden="true"></span></li>
										<li class="font-main font-weight-normal color-additional oneLine">
											<p align="center">0599994012</p> <span class="icon_phone" aria-hidden="true"></span></li>
										<li class="font-main font-weight-normal color-additional oneLine">
											<p align="center">admin@sooqwatheq.co</p> <span class="icon_mail" aria-hidden="true"></span>
										</li>
								
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer-bottom">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix pull-left">
								<span class="footer_copyright pull-left color-additional font-main font-weight-light wow fadeInLeft" data-wow-delay="0.3s"> © 2019 جميع الحقوق محفوظة لسوق واثق.</span>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix">
								<ul class="footer-payments pull-right wow fadeInRight" data-wow-delay="0.3s">
                                                                    <li><a target="_blank" href="https://maroof.sa/30311"> <img border="0" src="https://sooqwatheq.co/img/footerleft.png"></a></li>	
									<li><img src="/media/payments/1.jpg" alt="Payments"></li>
									<li><img src="/media/payments/2.jpg" alt="Payments"></li>
									<li><img src="/media/payments/3.jpg" alt="Payments"></li>
									<li><img src="/media/payments/4.jpg" alt="Payments"></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<div aria-hidden="false" role="dialog" tabindex="-1" class="modal fade example-modal-lg search-wrapper in">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<p class="clearfix"><button data-dismiss="modal" class="close" type="button"><span class="icon_close color-main" aria-hidden="true"></span></button></p>
        <form action="<?php echo e(Protocol::home()); ?>/search" accept-charset="UTF-8" method="get" class="form-inline form-search">
						<div class="form-group">
							<label for="textsearch" class="sr-only">عن ماذا تبحث ؟</label>
                <input name="q" class="form-control form-control-search" placeholder="<?php echo e(Lang::get('home.lang_search_what_are_you_looking')); ?>" type="text" autocomplete="off" class="form-control input-lg font-main font-weight-normal color-main">
                						</div>
						<button class="btn btn-white font-additional font-weight-normal color-main text-uppercase hover-focus-bg" type="submit">
						<?php echo e(Lang::get('home.lang_search')); ?></button>
					</form>
				</div>
			</div>
		</div>

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

		<script src="/fares/js/modernizr.custom.js"></script>
		<script src="/fares/js/jquery.placeholder.min.js"></script>
		<script src="/fares/js/smoothscroll.min.js"></script>
		<!-- Loader -->
		<script src="/fares/plugins/loader/js/classie.js"></script>
		<script src="/fares/plugins/loader/js/pathLoader.js"></script>
		<script src="/fares/plugins/loader/js/main.js"></script>
		<script src="/fares/js/classie.js"></script>
		<!--Owl Carousel-->
	    <script src="/fares/plugins/owl-carousel/owl.carousel.min.js"></script>
	    <!-- bxSlider -->
	    <script src="/fares/plugins/bxslider/jquery.bxslider.min.js"></script>
		<!--Switcher-->
		<script src="/fares/plugins/switcher/js/bootstrap-select.js"></script> 
		<script src="/fares/plugins/switcher/js/evol.colorpicker.min.js" type="text/javascript"></script> 
		<script src="/fares/plugins/switcher/js/dmss.js"></script>
	    <!-- SCRIPTS -->
	    <script type="text/javascript" src="/fares/plugins/isotope/jquery.isotope.min.js"></script> 

		<!--THEME--> 
		<script src="/fares/js/wow.min.js"></script>
		<script src="/fares/js/cssua.min.js"></script>
        <script src="/fares/js/theme.js"></script> 

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116690631-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-116690631-2');
</script>
</body>

</html>

