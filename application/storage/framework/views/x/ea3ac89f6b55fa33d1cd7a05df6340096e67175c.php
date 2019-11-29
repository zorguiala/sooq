<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

    <link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/icons/et-line-font/et-line.css" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<!-- Carousel Plugin JS -->
<link rel="stylesheet" type="text/css" href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/slick/slick-theme.css"/>
<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/slick/slick.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.your-class').slick({
            autoplay: false,
            arrows: false,
            dots: true,
            infinite: true,
            pauseOnFocus: true,
            pauseOnHover: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
            ]
        });
    });
</script>

<?php $__env->stopSection(); ?>
<nav class="navbar filter-bar filled">
<?php $__env->startSection('pageHeader'); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<div class="row" style="margin: 10px -10px 50px -10px">

    <!-- Session Messages -->
    <div class="col-md-12 mt-20">
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
<?php echo Helper::settings_seo()->header_code; ?>


    <!-- Section Title -->
    <div class="spec ">
        <h3><?php echo e(Lang::get('home.lang_top_interesting')); ?></h3>
        <div class="ser-t">
            <b></b>
            <span><i></i></span>
            <b class="line"></b>
        </div>
    </div>

    <!-- Featured Ads -->
    <?php if($featured_ads): ?>
    <div class="your-class">

        <?php $__currentLoopData = $featured_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="col-md-4">

            <div class="card card-blog">
                <ul class="tags">
                    <?php if($f_ad->is_featured): ?>
                    <li><?php echo e(Lang::get('home.lang_featured')); ?></li>
                    <?php endif; ?>

                    <?php if($f_ad->is_oos): ?>
                    <li class="oos"><?php echo e(Lang::get('update_three.lang_out_of_stock')); ?></li>
                    <?php endif; ?>
                </ul>
                <div class="card-image">
                    <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($f_ad->slug); ?>" <?php echo e(!is_null($f_ad->affiliate_link) ? 'target="_blank"' : ''); ?>>
                        <div class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($f_ad->ad_id, $f_ad->images_host)); ?> " title="<?php echo e($f_ad->title); ?>"></div>
                   
				   </a>
                </div>
                <div class="card-block">
                    <h5 class="card-title">
                        <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($f_ad->slug); ?>"><?php echo e($f_ad->title); ?></a>
                    </h5>
                    <div class="card-footer">
                        <div id="price">
                            <?php if(!is_null($f_ad->regular_price)): ?>
                            <span class="price price-old"> <?php echo e(Helper::getPriceFormat($f_ad->regular_price, $f_ad->currency)); ?></span>
                            <?php endif; ?>
                            <span class="price price-new"> <?php echo e(Helper::getPriceFormat($f_ad->price, $f_ad->currency)); ?></span>
                        </div>
                        <div class="author">
                            <div class="card__avatar"><a href="<?php echo e(Profile::hasStore($f_ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($f_ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="<?php echo e(Profile::picture($f_ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($f_ad->user_id) ? Profile::hasStore($f_ad->user_id)->title : Profile::full_name($f_ad->user_id)); ?>" class="avatar lozad" width="40" height="40"><?php if(Profile::hasStore($f_ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"></i><?php endif; ?></a></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
    <?php endif; ?>

    <!-- Latest Ads -->
	<div class="col-md-9">

		<div class="panel">

			<div class="panel-body">
            <h3><?php echo e(Lang::get('home.lang_latest_ads')); ?></h3>
            <div class="ser-t">
                <b></b>
                <span><i></i></span>
                <b class="line"></b>
            </div>
        </div>
        
        <div class="row">

            <?php if(count($latest_ads)): ?>
            <?php $__currentLoopData = $latest_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-3">

                <div class="card card-blog">
                    <ul class="tags">
                        <?php if($ad->is_featured): ?>
                        <li><?php echo e(Lang::get('home.lang_featured')); ?></li>
                        <?php endif; ?>

                        <?php if($ad->is_oos): ?>
                        <li class="oos"><?php echo e(Lang::get('update_three.lang_out_of_stock')); ?></li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-image">
                        <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>" <?php echo e(!is_null($ad->affiliate_link) ? 'target="_blank"' : ''); ?>>
                        <?php if($ad->photos != null): ?>
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>"></div>
                            <?php else: ?>
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(Route::currentRouteName() == 'home' ? Protocol::home().'/application/public/uploads/settings/logo/logo.png' : Protocol::home().'/application/public/uploads/settings/logo/footer/logo.png'); ?>" title="<?php echo e($ad->title); ?>"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"><?php echo e($ad->title); ?></a>
                        </h5>
                        <div class="card-footer">
                            <div id="price">
                                <?php if(!is_null($ad->regular_price)): ?>
                                <span class="price price-old"> <?php echo e(Helper::getPriceFormat($ad->regular_price, $ad->currency)); ?></span>
                                <?php endif; ?>
                                <span class="price price-new"> <?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?></span>
                            </div>
                            <div class="author">
                                <div class="card__avatar"><a href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="<?php echo e(Profile::picture($ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>" class="avatar lozad" width="40" height="40"><?php if(Profile::hasStore($ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"></i><?php endif; ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>

        <!-- Browse All -->
        <div class="btn-morphing"><a href="<?php echo e(Protocol::home()); ?>/browse" class="btn btn-default btn-round btn-toggle"><?php echo e(Lang::get('home.lang_see_more')); ?></a></div>

    </div>

    <!-- Browse By Categories -->
    <div class="col-md-12" style="margin-top: 20px;">

        <!-- Browse By Categories -->
        <div class="spec ">
            <h3><?php echo e(Lang::get('home.lang_browse_categories')); ?></h3>
            <div class="ser-t">
                <b></b>
                <span><i></i></span>
                <b class="line"></b>
            </div>
        </div>


        <?php if(count(Helper::parent_categories())): ?>
        <!-- Browse By Category -->

        <div class="row cat_single_wrap">

            <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 text-center">

                <div class="cat_single">
                    <div class="cat_single_bg">
                        <div class="overlay_color panel" style="transform: skewX(-6deg);">
                        </div>
                    </div>
                    <div class="cat_single_content">
                        <a href="<?php echo e(Protocol::home()); ?>/category/<?php echo e($parent_category->category_slug); ?>" style="color: rgb(255, 255, 255);">
                            <img data-src="<?php echo e($parent_category->icon); ?>" class="lozad">
                            <span class="cat_title"><?php echo e($parent_category->category_name); ?></span>
                        </a>
                    </div>
                </div>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <?php endif; ?>


    </div>

    <!-- Quick Stats -->
    <div style="margin-top: 120px;width: 100%;float: left;">

        <div class="col-sm-6 col-xs-6 col-md-3">

            <div class="statistic">
                <i class="et-line-layers"></i>
                <span><?php echo e(number_format($total_ads)); ?></span>
                <h3><?php echo e(Lang::get('home.lang_stat_submissions')); ?></h3>
            </div>

        </div>

        <div class="col-sm-6 col-xs-6 col-md-3">

            <div class="statistic">
                <i class="et-line-map"></i>
                <span><?php echo e(number_format($total_stores)); ?></span>
                <h3><?php echo e(Lang::get('home.lang_stat_stores')); ?></h3>
            </div>

        </div>

        <div class="col-sm-6 col-xs-6 col-md-3">

            <div class="statistic">
                <i class="et-line-happy"></i>
                <span><?php echo e(number_format($total_users)); ?></span>
                <h3><?php echo e(Lang::get('home.lang_stat_users')); ?></h3>
            </div>

        </div>

        <div class="col-sm-6 col-xs-6 col-md-3">

            <div class="statistic">
                <i class="et-line-linegraph"></i>
                <span><?php echo e(number_format($total_views)); ?></span>
                <h3><?php echo e(Lang::get('home.lang_stat_views')); ?></h3>
            </div>

        </div>

    </div>

</div>
	<!-- Left Side -->

	<div class="col-md-3">
	
        <form action="<?php echo e(Protocol::home()); ?>/search" accept-charset="UTF-8" method="get">
            <div class="form-group form-search">

                <input name="q" class="form-control form-control-search" placeholder="<?php echo e(Lang::get('home.lang_search_what_are_you_looking')); ?>" type="text" autocomplete="off">

                <button type="submit" class="btn btn-default btn-round btn-submit">
                    <i class="feather-search icon-2x"></i>
                </button>

            </div>

            <span class="search-advanced" data-toggle="modal" data-target="#search_form"><?php echo e(Lang::get('update_two.lang_advanced')); ?></span>
        </form>
<table align="center" cellpadding="0" cellspacing="0" dir="rtl" style="width: 100%;margin-top:10px;">

	<tbody><tr>
		<td align="center" id="title">تصفح حسب الماركة</td>
	</tr>
	<tr>
		<td align="right" id="contain" style="text-decoration:none;font-size:large">
		<ul class="tabs">
		<li class="active"><a href="#tab1" class="bra1">سيارات</a></li>
		<li id="li_tab2" class=""><a href="#tab2" class="bra2">الأجهزة</a></li>
		<li id="li_tab3" class=""><a href="#tab3" class="bra3">عقارات</a></li>
		</ul>
		<div id="show1" style="display: block;">
		<table style="width: 95%;float: right;" align="center" cellpadding="0" cellspacing="0" dir="rtl">
<tbody><tr>

<td dir="rtl"><div class="row cat_single_wrap">

<div id="img3" style="display:inline;">
<div class="sidebg">


<center>
<table>       
   
<tbody>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/Ford"><img src="https://sooqwatheq.co/application/public/uploads/categories/1c1834826f813a165bdebaf252183c0d.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/Chevrolet"><img src="https://sooqwatheq.co/application/public/uploads/categories/d9eff369c9cbda2f4091b1b88240faab.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/Toyota"><img src="https://sooqwatheq.co/application/public/uploads/categories/70d1d5a41d717ae61c04a6677157db7a.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/Nissan"><img src="https://sooqwatheq.co/application/public/uploads/categories/8a9c107abb27e1b200081cf762a160e1.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/Mercedes"><img src="https://sooqwatheq.co/application/public/uploads/categories/d5c25de23607d3b4783fb775ba07d68a.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/GMC"><img src="https://sooqwatheq.co/application/public/uploads/categories/439ac106662537ab22138a8f47b2c167.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/bmw"><img src="https://sooqwatheq.co/application/public/uploads/categories/1a03852b75adec7b13302341f4cd80af.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/Lexus"><img src="https://sooqwatheq.co/application/public/uploads/categories/46d7bb3d65c86dbae83ec3a2f0efe80a.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/jeep"><img src="https://sooqwatheq.co/application/public/uploads/categories/4c6ed709101a2a285edd9a8c5ed87106.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/hyundai"><img src="https://sooqwatheq.co/application/public/uploads/categories/dac86a5ebb4f8a6afc5f24a3ef068eb2.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/honda"><img src="https://sooqwatheq.co/application/public/uploads/categories/98e080d79d8fefbe39d315355a741ee8.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/hummer"><img src="https://sooqwatheq.co/application/public/uploads/categories/fd170ef102db9d860355527724edef70.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/infiniti"><img src="https://sooqwatheq.co/application/public/uploads/categories/ede009fee9137ddc62528900dbc966cd.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/landrover"><img src="https://sooqwatheq.co/application/public/uploads/categories/1ed8e147c0900955d9de472a7847eccb.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/mazda"><img src="https://sooqwatheq.co/application/public/uploads/categories/4a2a53a35681b715aa34b01068cb539d.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/mercury"><img src="https://sooqwatheq.co/application/public/uploads/categories/bbf8ed211888cb4e78f3f01f83a4e034.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/volkswagen"><img src="https://sooqwatheq.co/application/public/uploads/categories/fa7d21073b2ea7caed7a77368914c454.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/mitsubishi"><img src="https://sooqwatheq.co/application/public/uploads/categories/7d2921a3c093d3a73fdd0a903185d23b.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/lincoln"><img src="https://sooqwatheq.co/application/public/uploads/categories/59d2706a45838675feb2e0e7c80470b3.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/opel"><img src="https://sooqwatheq.co/application/public/uploads/categories/c9c639ac7a935969ab7e8ec43ed2498c.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/isuzu"><img src="https://sooqwatheq.co/application/public/uploads/categories/dc729f59bce60a0ff5b2f1273920ec2d.png" width="75px" height="75px"></a></td>
</tr>



<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/porsche"><img src="https://sooqwatheq.co/application/public/uploads/categories/e61fbf8e508c5652de11508a14e504b4.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/kia"><img src="https://sooqwatheq.co/application/public/uploads/categories/804e38ac03e8618ed4f40a27a789a9c4.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/maserati"><img src="https://sooqwatheq.co/application/public/uploads/categories/19795e84d7ddf6dfee69fd7192fa14a1.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/bentley"><img src="https://sooqwatheq.co/application/public/uploads/categories/d47b4ec254d66145d100ca9a3bf63468.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/austonmartin"><img src="https://sooqwatheq.co/application/public/uploads/categories/7b6b322f9446f526b3b48f1dc39ab2bb.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/cadillac"><img src="https://sooqwatheq.co/application/public/uploads/categories/af4a13c6e2214af40d7d0bd9f9a2ba5d.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/citroen"><img src="https://sooqwatheq.co/application/public/uploads/categories/ded5792aeec600a698863dab419552bb.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/daewoo"><img src="https://sooqwatheq.co/application/public/uploads/categories/9a5bac6a188225ffbf8e24bc54470958.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/daihatsu"><img src="https://sooqwatheq.co/application/public/uploads/categories/04d881f6054a3d7ffa16591d192ce8a3.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/dodge"><img src="https://sooqwatheq.co/application/public/uploads/categories/541f5ac15714b41445121004878c880b.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/ferrari"><img src="https://sooqwatheq.co/application/public/uploads/categories/55418592977bf26d31f3ed625907fe76.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/fiat"><img src="https://sooqwatheq.co/application/public/uploads/categories/cf9c43236e86b4ec68f58a1fe857e24d.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/Jaguar"><img src="https://sooqwatheq.co/application/public/uploads/categories/b99263582c4d764aba9961fd98d3f1de.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/lamborghini"><img src="https://sooqwatheq.co/application/public/uploads/categories/920f551aaa8c6f9b5c025f997ad63d25.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/rollsroyce"><img src="https://sooqwatheq.co/application/public/uploads/categories/4b2e8a4e538bcd710a654ac6379a185a.png" width="75px" height="75px"></a></td>
</tr>





<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/peugeot"><img src="https://sooqwatheq.co/application/public/uploads/categories/e705e1315ee8fc59c174dda124b5dd2f.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/subaru"><img src="https://sooqwatheq.co/application/public/uploads/categories/701814e7c22b4c4f7f3b9b65edcfb53c.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/suzuki"><img src="https://sooqwatheq.co/application/public/uploads/categories/18e2a81af9c69d68e91dcac327584f35.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/volvo"><img src="https://sooqwatheq.co/application/public/uploads/categories/8cfb1f90549edef1633b84d25733c188.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/skoda"><img src="https://sooqwatheq.co/application/public/uploads/categories/bcf46cf4d2011f42ba79b8fb59122d49.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/audi"><img src="https://sooqwatheq.co/application/public/uploads/categories/0e921427d648654bf7b4ab5fe5823088.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/renault"><img src="https://sooqwatheq.co/application/public/uploads/categories/1818eacb2fbc68a98c26788545d42d39.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/buick"><img src="https://sooqwatheq.co/application/public/uploads/categories/887dd23ddd50bcee58906354022c1602.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/saab"><img src="https://sooqwatheq.co/application/public/uploads/categories/e2fc3b1fc3a06048ea1a965200cc94f2.png" width="75px" height="75px"></a></td>
</tr>



<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/seat"><img src="https://sooqwatheq.co/application/public/uploads/categories/c3171b54a10bf96820c9592041487cf2.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/mg"><img src="https://sooqwatheq.co/application/public/uploads/categories/b6ffde7e18c4a28453edd3098c80d00b.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/proton"><img src="https://sooqwatheq.co/application/public/uploads/categories/fc7b0e466e929bff8f5449ac7b2ae730.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/ssangyong"><img src="https://sooqwatheq.co/application/public/uploads/categories/541ac754360c1a8728d3e03fb90eb4da.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/chery"><img src="https://sooqwatheq.co/application/public/uploads/categories/ffa15bdba9884cc9eb30371edfe538bd.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/geely"><img src="https://sooqwatheq.co/application/public/uploads/categories/9d0546e5a506d749f789d4e4f92667eb.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/zxauto"><img src="https://sooqwatheq.co/application/public/uploads/categories/6acfae34a2544deb488ed00241ddaedf.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/small"><img src="https://sooqwatheq.co/application/public/uploads/categories/209a2b9020c7c8cf6ee7df364a3da5cf.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/tools"><img src="https://sooqwatheq.co/application/public/uploads/categories/f062865b2e196b32e8716565304cca54.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/cars/truck"><img src="https://sooqwatheq.co/application/public/uploads/categories/dc70614aff144460014374059d9582fc.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/chrysler"><img src="https://sooqwatheq.co/application/public/uploads/categories/43b62a091f32387aa4be96971d98a46c.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/cars/geely"><img src="https://sooqwatheq.co/application/public/uploads/categories/9d0546e5a506d749f789d4e4f92667eb.png" width="75px" height="75px"></a></td>
</tr>



</tbody></table> 
</center>
</div>
</div>

            
        </div></td></tr></tbody></table></div>
		<div id="show2" style="display: none;"><table style="width: 99%" align="center" cellpadding="0" cellspacing="0" dir="rtl">
<tbody><tr>



<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Devices/SONY"><img src="https://sooqwatheq.co/application/public/uploads/categories/d468ad2903ef26abc14ffc62e6f55b6f.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Devices/HTC"><img src="https://sooqwatheq.co/application/public/uploads/categories/082771351bb69cd936bbae91b6d8f249.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Devices/Toshiba"><img src="https://sooqwatheq.co/application/public/uploads/categories/03670b2bfa32a232fcc182729def9100.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Devices/Toshiba"><img src="https://sooqwatheq.co/application/public/uploads/categories/03670b2bfa32a232fcc182729def9100.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Devices/Apple"><img src="https://sooqwatheq.co/application/public/uploads/categories/cb93fa54b82f2ab2b63a81bea83bc5af.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Devices/Nokia"><img src="https://sooqwatheq.co/application/public/uploads/categories/4f5bbf7fb28698767043589fa9513c2d.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Devices/M8"><img src="https://sooqwatheq.co/application/public/uploads/categories/b2605adad1c99c268018fe801d16d74d.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Devices/Watch"><img src="https://sooqwatheq.co/application/public/uploads/categories/aa49b0be5925325addad8dedf19efc15.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Devices/Galaxy"><img src="https://sooqwatheq.co/application/public/uploads/categories/32a6287981c8dfde20d9ce885dad5c59.png" width="75px" height="75px"></a></td>

</tr>

            </div>

</td></tr></tbody></table></div>
		<div id="show3" style="display: none;">
		
<table>       
   
<tbody>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Real%20estate/Land%20for%20sale">أرض للبيع</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/apartment%20for%20rent">شقة للايجار</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/apartment%20for%20sale">شقة للبيع</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Real%20estate/Building%20for%20sale">عمارة للبيع</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/Building%20for%20rent">عمارة للإيجار</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/A%20kiss%20shop">محل للتقبيل</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
</tr>

<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Real%20estate/Shop%20for%20rent">محل للإيجار</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/Farm%20for%20sale">مزرعة للبيع</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/Break%20for%20rent">استراحه للإيجار</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
</tr>


<tr id="imggg">

<td><a href="https://sooqwatheq.co/category/Real%20estate/Break%20for%20sale">استراحة للبيع</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/House%20for%20sale">بيت للبيع</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
<td><a href="https://sooqwatheq.co/category/Real%20estate/home%20for%20rent">بيت للإيجار</a><img src="https://sooqwatheq.co/application/public/uploads/categories/41a7a506b11a52582fd7a7e71479e815.png" width="75px" height="75px"></a></td>
</tr>



</tbody></table> 
</center>
</div>
</div>

            
            
		
		<div id="show4" style="display: none;">
4444
            </div>
            
        </div>
		
		</div>
      <script>
$(document).ready(function() {
$(".tab_content").hide(); 
$("ul.tabs li").removeClass("active"); 
$("ul.tabs li:first").addClass("active").show(); 
	$(".tab_content:first").show(); 
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
});
$(document).ready(function(){
  $("#show2").fadeOut("speed,callback");
  $("#show1").fadeIn("speed,callback");
  $("#show3").fadeOut("speed,callback");
  $("#show4").fadeOut("speed,callback");
});
$(".bra1").click(function () {
  $("#show2").fadeOut("speed,callback");
  $("#show3").fadeOut("speed,callback");
  $("#show4").fadeOut("speed,callback");
  $("#show1").fadeIn("speed,callback");
});
$(".bra2").click(function () {
  $("#show2").fadeIn("speed,callback");
  $("#show1").fadeOut("speed,callback");
  $("#show3").fadeOut("speed,callback");
  $("#show4").fadeOut("speed,callback");
});
$(".bra3").click(function () {
  $("#show2").fadeOut("speed,callback");
  $("#show3").fadeIn("speed,callback");
  $("#show4").fadeOut("speed,callback");
  $("#show1").fadeOut("speed,callback");
});
$(".bra4").click(function () {
  $("#show2").fadeOut("speed,callback");
  $("#show3").fadeOut("speed,callback");
  $("#show4").fadeIn("speed,callback");
  $("#show1").fadeOut("speed,callback");
});
</script>
		</td>
	</tr>
</tbody></table>
		<!-- Seller Card -->
	

		<!-- Advertisements -->
		<?php if(Helper::ifCanSeeAds()): ?>
		<div class="advertisment">
			<?php echo Helper::advertisements()->ad_sidebar; ?>

		</div>
		<?php endif; ?>

		<!-- Usefull Information -->
		<div class="panel panel-flat">
			<div class="panel-body">
				<ul class="media-list">

					<li class="media">
						<div class="media-left">
							<a href="#" class="btn border-grey-300 text-grey-300 btn-flat btn-rounded btn-icon btn-xs legitRipple"><i class="icon-checkmark4"></i></a>
						</div>
						
						<div class="media-body">
							<?php echo e(Lang::get('ads/show.lang_safety_avoid_scams')); ?>

						</div>
					</li>

					<li class="media">
						<div class="media-left">
							<a href="#" class="btn border-grey-300 text-grey-300 btn-flat btn-rounded btn-icon btn-xs legitRipple"><i class="icon-checkmark4"></i></a>
						</div>
						
						<div class="media-body">
							<?php echo e(Lang::get('ads/show.lang_safety_never_pay')); ?>

						</div>
					</li>

					<li class="media">
						<div class="media-left">
							<a href="#" class="btn border-grey-300 text-grey-300 btn-flat btn-rounded btn-icon btn-xs legitRipple"><i class="icon-checkmark4"></i></a>
						</div>
						
						<div class="media-body">
							<?php echo e(Lang::get('ads/show.lang_safety_dont_buy')); ?>

						</div>
					</li>

					<li class="media">
						<div class="media-left">
							<a href="#" class="btn border-grey-300 text-grey-300 btn-flat btn-rounded btn-icon btn-xs legitRipple"><i class="icon-checkmark4"></i></a>
						</div>
						
						<div class="media-body">
							<?php echo e(Lang::get('ads/show.lang_safety_this_site_is_never')); ?>

						</div>
					</li>

				</ul>
			</div>
		</div>

		<!-- Advertisements -->
		<?php if(Helper::ifCanSeeAds()): ?>
		<div class="advertisment">
			<?php echo Helper::advertisements()->ad_sidebar; ?>

		</div>
		<?php endif; ?>

	</div>


</div>

<!-- Adblock detected -->
<div class="adblock-detected" style="display: none">
	
	<div class="adblock">
		<p>We have detected that you are using an adblocking plugin in your browser.<br>Our website is made possible by displaying online advertisements to our visitors.
		Please consider supporting us by disabling your ad blocker.</p>
	</div>

</div>
<script type="text/javascript">
    
    /**
    * Get States
    */
    function getStates(country) {
        var _root = $('#root').attr('data-root');
        var country_id = country;
        $.ajax({
            type: "GET",
            url: _root + '/tools/geo/states/states_by_country',
            data: {
                country_id: country_id
            },
            success: function(response) {
                if (response.status == 'success') {

                    // Check if states enabled
                    if (response.states) {

                        $('#putStates').find('option').remove();
                        $('#putStates').append($('<option>', {
                            text: '<?php echo e(__('home.lang_state')); ?>',
                            value: 'all'
                        }));
                        $.each(response.data, function(array, object) {
                            $('#putStates').append($('<option>', {
                                value: object.id,
                                text: object.name
                            }))
                        });

                    }else if (response.cities) {

                        // Cities
                        $('#putCities').find('option').remove();
                        $('#putCities').append($('<option>', {
                            text: '<?php echo e(__('home.lang_city')); ?>',
                            value: 'all'
                        }));
                        $.each(response.data, function(array, object) {
                            $('#putCities').append($('<option>', {
                                value: object.id,
                                text: object.name
                            }))
                        });

                    }
                }
                if (response.status == 'error') {
                    alert(response.msg)
                }
            }
        })
    }

    /**
    * Get Cities
    */
    function getCities(state) {
        var _root = $('#root').attr('data-root');
        var state_id = state;
        $.ajax({
            type: "GET",
            url: _root + '/tools/geo/cities/cities_by_state',
            data: {
                state_id: state_id
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#putCities').find('option').remove();
                    $('#putCities').append($('<option>', {
                        text: 'Select city',
                        value: 'all'
                    }));
                    $.each(response.data, function(array, object) {
                        $('#putCities').append($('<option>', {
                            value: object.id,
                            text: object.name
                        }))
                    });
                }
                if (response.status == 'error') {
                    alert(response.msg)
                }
            }
        })
    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>