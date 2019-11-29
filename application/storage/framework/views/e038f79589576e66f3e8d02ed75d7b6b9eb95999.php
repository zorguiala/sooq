<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

    <link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/icons/et-line-font/et-line.css" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>


<!-- Carousel Plugi0n JS -->
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

<?php $__env->startSection('pageHeader'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
			<section id="categories">
				<div class="container clearfix">
					<ul class="category-images">
						<li class="grid">
							<figure class="effect-bubba wow fadeInLeft" data-wow-delay="0.3s">
								<img src="media/categories/advvv.jpg" alt="Category">
								<figcaption>
									<div class="category-images_content">
										<h2 class="font-third font-weight-light text-uppercase color-main">
										مساحه اعلانية</h2>
										<p class="font-additional font-weight-bold text-uppercase color-main line-text line-text_white">
										اعلانك هنا يحقق هدفك</p>
									</div>
									<a href="https://sooqwatheq.co/contact">شاهد</a>
								</figcaption>			
							</figure>
						</li>
						<li class="left-space right-space">
<iframe width="300" height="240" src="https://www.youtube.com/embed/d64bWbju2cM"></iframe>
						</li>
						<li class="grid">
							<figure class="effect-bubba wow fadeInRight" data-wow-delay="0.3s">
								<img src="media/categories/advvvxx.jpg" alt="Category">
								<figcaption>
									<div class="category-images_content">
										<h2 class="font-third font-weight-light text-uppercase color-main">
										منصة سوق واثق</h2>
										<p class="font-additional font-weight-bold text-uppercase color-main line-text line-text_white">
										 بدار بحجز نسختك الان واختر الخطه المناسبة لك</p>
									</div>
									<a href="https://sooqwatheq.co/page/script">شاهد</a>
								</figcaption>			
							</figure>
						</li>
					</ul>
				</div>
			</section>

<div class="row" style="margin: -40px -10px 50px -10px">

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
			<section id="slider" class="slider-container slider-top-pagination">
            
				<div class="container">
					<h2 class="title font-additional font-weight-bold text-uppercase wow zoomIn" data-wow-delay="0.3s"><span class="customColor">
				<i class="fa fa-minus"></i> <?php echo e(Lang::get('home.lang_top_interesting')); ?> <i class="fa fa-minus"></i> </h2></span>
					<div class="starSeparatorBox clearfix">
						<div class="starSeparator wow zoomIn" data-wow-delay="0.3s">
							<span aria-hidden="true"><i class="fa fa-bullseye"></i></span>
						</div>
                        						</div>

						</div>

			</section>
                <!-- Featured Ads -->
    <?php if($featured_ads): ?>
    <div class="your-class">

        <?php $__currentLoopData = $featured_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="col-md-3 col-xs-6">

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
                    <?php if($f_ad->photos_number== 0): ?>

                                            <div  class="img card-ad-cover lozad" data-background-image="https://sooqwatheq.co/img/1.jpg" title="<?php echo e($f_ad->title); ?>"></div>
                    <?php endif; ?>
                    <?php if($f_ad->photos_number!= 0): ?>
                                            <div  class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($f_ad->ad_id, $f_ad->images_host)); ?>" title="<?php echo e($f_ad->title); ?>"></div>
                    <?php endif; ?>

                    </a>
                    <div class="card__avatar_new"><a href="<?php echo e(Profile::hasStore($f_ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($f_ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"style="margin-left: 30px;"><img data-src="<?php echo e(Profile::picture($f_ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($f_ad->user_id) ? Profile::hasStore($f_ad->user_id)->title : Profile::full_name($f_ad->user_id)); ?>" class="avatar lozad" width="40" height="40"><?php if(Profile::hasStore($f_ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"></i><?php endif; ?></a></div>
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
                            <span class="price price-new"><i class="fa fa-money"  aria-hidden="true" style="font-size:25px; color:green"></i> <b><?php echo e(Helper::getPriceFormat($f_ad->price, $f_ad->currency)); ?></b></span>
                        </div>
                        <div class="author">

                            <div id="date">
                                <span class="date" style="display: inline-flex;"><?php echo e($f_ad->timeleft); ?> 
                                </span><i class="fa fa-calendar"   style="font-size:15px; color: #8a8c8a;"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
    <?php endif; ?>

    <!-- Latest Ads -->
    <div class="col-md-12">
        <!-- Section Title -->

            			<section id="slider" class="slider-container slider-top-pagination">
            
				<div class="container">
					<h2 class="title font-additional font-weight-bold text-uppercase wow zoomIn" data-wow-delay="0.3s"><span class="customColor">
				<i class="fa fa-minus"></i> <?php echo e(Lang::get('home.lang_latest_ads')); ?> <i class="fa fa-minus"></i> </h2></span>
					<div class="starSeparatorBox clearfix">
						<div class="starSeparator wow zoomIn" data-wow-delay="0.3s">
							<span aria-hidden="true"><i class="fa fa-bullseye"></i></span>
						</div>
                        						</div>

						</div>

			</section>
        <div class="row">

            <?php if(count($latest_ads)): ?>
            <?php $__currentLoopData = $latest_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-3 col-xs-6">

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
                        <?php if($ad->photos_number != 0): ?>
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>"></div>
                            <?php endif; ?>
                            <?php if($ad->photos_number== 0): ?>
                            <div class="img card-ad-cover lozad" data-background-image="https://sooqwatheq.co/img/1.jpg" title="<?php echo e($ad->title); ?>"></div>
                            <?php endif; ?>
                        </a>
                        
                    </div>
                    <div class="card__avatar_new"><a href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40" style="margin-left: 30px;"><img data-src="<?php echo e(Profile::picture($ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>" class="avatar lozad" width="40" height="40"><?php if(Profile::hasStore($ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"></i><?php endif; ?></a></div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"><?php echo e($ad->title); ?></a>
                        </h5>
                        <div class="card-footer">
                            <div id="price">
                                <?php if(!is_null($ad->regular_price)): ?>
                                <span class="price price-old"> <?php echo e(Helper::getPriceFormat($ad->regular_price, $ad->currency)); ?></span>
                                <?php endif; ?>
                                <span class="price price-new"><i class="fa fa-money"  aria-hidden="true" style="font-size:20px; color:gray"></i> <?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?></span>
                            </div>
                            <div class="author">

                                <div id="date">
                                <span class="date" style="display: inline-flex;"><?php echo e($ad->timeleft); ?> 
                                </span><i class="fa fa-calendar"   style="font-size:15px; color: #8a8c8a;"></i>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>

        <!-- Browse All -->
        <div class="btn-morphing" class="customColor"><a href="<?php echo e(Protocol::home()); ?>/browse" class="btn btn-default btn-round btn-toggle" style="color: #ff8300;"><?php echo e(Lang::get('home.lang_see_more')); ?></a></div>

    </div>

    <!-- Browse By Categories -->
						<section id="brands" class="paralax brands-box" style="background-image: url('media/paralax/444.png');">
				<div class="container">
					<div class="starSeparatorBox clearfix">
						<div class="starSeparator wow zoomIn" data-wow-delay="0.3s">
							<span aria-hidden="true"><i class="fa fa-bullseye"></i></span>
						</div>
						<ul class="brands-list">
							<li>
								<a href="category/cars/audi" class="brand-item wow fadeInLeft" data-wow-delay="0.3s">
									<img src="media/brands/1.png" alt="Brand">
								</a>
							</li>
							<li>
								<a href="category/cars/kia" class="brand-item wow fadeInLeft" data-wow-delay="0.3s">
									<img src="media/brands/2.png" alt="Brand">
								</a>
							</li>
							<li>
								<a href="category/cars/Ford" class="brand-item wow fadeInUp" data-wow-delay="0.3s">
									<img src="media/brands/3.png" alt="Brand">
								</a>
							</li>
							<li>
								<a href="category/cars/Chevrolet" class="brand-item wow fadeInUp" data-wow-delay="0.3s">
									<img src="media/brands/4.png" alt="Brand">
								</a>
							</li>
							<li>
								<a href="category/cars/hyundai" class="brand-item wow fadeInRight" data-wow-delay="0.3s">
									<img src="media/brands/5.png" alt="Brand">
								</a>
							</li>
							<li>
								<a href="category/cars/mazda" class="brand-item wow fadeInRight" data-wow-delay="0.3s">
									<img src="media/brands/6.png" alt="Brand">
								</a>
							</li>
						</ul>
					</div>
				</div>
			</section>

			<section id="freeShpping" class="borderTopSeparator">
				<div class="container freeshpping-container">
					<div class="row" style="justify-content: center; display: flex;">
						<div class="freeshpping col-lg-3 col-md-3 col-sm-4 col-lg-6 clearfix">
							<div class="freeshpping-item font-additional wow fadeInLeft" data-wow-delay="0.3s">
								<span class="customColor" aria-hidden="true"><i class="fa fa-bullhorn"></i></span>
								اكبر نسبه مبيعات<br> بالمملكة
							</div>
						</div>
						<div class="freeshpping col-lg-3 col-md-3 col-sm-4 col-lg-6 clearfix">
							<div class="freeshpping-item font-additional wow fadeInUp" data-wow-delay="0.3s">
								<span class="customColor" aria-hidden="true"><i class="fa fa-life-bouy"></i></span>
								دعم فني<br> طوال اليوم
							</div>
						</div>
						<div class="freeshpping col-lg-3 col-md-3 col-sm-4 col-lg-6 clearfix">
							<div class="freeshpping-item font-additional wow fadeInRight" data-wow-delay="0.3s">
								<span class="customColor" aria-hidden="true"><i class="fa fa-thumbs-up"></i></span>
								ضمان الشراء<br> وسرعه البيع
							</div>
						</div>
					</div>
				</div>
			</section>

    <!-- Quick Stats -->
 			<section id="subscribe" class="subscribe-row background-container">
				<div class="container">
					<div class="subscribe-container clearfix wow fadeInUp" data-wow-delay="0.3s">
						<div class="subscribe-desc font-additional font-weight-bold">
							اشترك فى نشرتنا البريدية</div>
						<div id="mc_embed_signup" class="subscribe-form">
							<form>
								<div id="mc_embed_signup_scroll">
									<div class="mc-field-group subscribe-field">
                           		<input type="email" class="form-control" placeholder="<?php echo e(Lang::get('footer.lang_subscribe_to_our_newsletter')); ?>" id="newsletterEmail">
									</div>
					<div class="subscribe-button2">
    <button type="button" id="newsletterSubscribe" class="btn btn-primary font-additional hvr-wobble-bottom"> 
										<?php echo e(Lang::get('footer.lang_subscribe')); ?> </button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>


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