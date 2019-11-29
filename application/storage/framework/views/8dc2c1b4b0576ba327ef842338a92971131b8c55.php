<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>

<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/icons/et-line-font/et-line.css" rel="stylesheet"
    type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>


<!-- Carousel Plugi0n JS -->
<link rel="stylesheet" type="text/css"
    href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/slick/slick.css" />
<link rel="stylesheet" type="text/css"
    href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/slick/slick-theme.css" />
<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/slick/slick.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.your-class').slick({
            autoplay: true,
            arrows: true,
            dots: true,
            infinite: true,
            pauseOnFocus: true,
            pauseOnHover: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
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
        
        <div class="ui horizontal segments" style="margin: 0px;    text-align: center;">
            <div class="ui segment">

                <div class="imgover">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/car.svg" width="50" alt="">
                </div>

                <a class="menuu" href="#">
                    السيارات</a>

            </div>
            <div class="ui segment">
                <div class="imgover">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/015-work.svg" width="50" alt="">
                </div>
                <a class="menuu" href="#">
                    العقارات</a>
            </div>
            <div class="ui segment">
                <div class="imgover">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/responsive.svg" width="50" alt="">
                </div>
                <a class="menuu" href="#">
                    الاجهزه </a>
            </div>

        </div>
        <div class="ui horizontal segments" style="margin: 0px;    text-align: center;">
            <div class="ui segment">
                <div class="imgover">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/018-money.svg" width="50" alt="">
                </div>
                <a class="menuu" href="/category/Financing">التمويل والتقسيط </a>
            </div>
            <div class="ui segment">
                <div class="imgover">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/store.svg" width="50" alt="">
                </div>
                <a class="menuu" href="/stores"><?php echo e(Lang::get('header.lang_browse_stores')); ?></a>
            </div>
            <div class="ui segment">
                <div class="imgover">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/diploma.svg" width="50" alt="">
                </div>
                <a class="menuu" href="/page/Treaty">المعاهده</a>
            </div>

        </div>
    </div>
</section>
<div class="block-title" style="    text-align: center;">
        <h3><span> <?php echo e(Lang::get('home.lang_latest_ads')); ?></span></h3>
    </div>
<div class="row" >

    <!-- Featured Ads -->
    <?php if($featured_ads): ?>
    <div class="container your-class">

        <?php $__currentLoopData = $featured_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="ui card card_sm" style="border: 1px solid #ff000069; width: 260px;" dir="ltr">
    <div class="content">

        <a class="right floated "
            href="<?php echo e(Profile::hasStore($f_ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($f_ad->user_id)->username : '#'); ?>">
            <div class="namecard"><?php echo e($f_ad->user_name{0}->first_name); ?> <?php echo e($f_ad->user_name{0}->last_name); ?></div>
            <img style="border: 1px solid green;" class="ui avatar image" src="<?php echo e(Profile::picture($f_ad->user_id)); ?>"
                title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"
                alt="<?php echo e(Profile::hasStore($f_ad->user_id) ? Profile::hasStore($f_ad->user_id)->title : Profile::full_name($f_ad->user_id)); ?>">

        </a>
        <div class="meta"><?php echo e($f_ad->timeleft); ?></div>
    </div>
    <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($f_ad->slug); ?>"
        <?php echo e(!is_null($f_ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
    </a>
    <div class="image"><a class="ui teal right ribbon label">إعلان متميز</a>
        <img src="<?php echo e(EverestCloud::getThumnail($f_ad->ad_id, $f_ad->images_host)); ?>" title="<?php echo e($f_ad->title); ?>">
    </div>

    <div class="content" style="padding-top: 2px;padding-bottom: 2px;color: grey;">
        <span class="right floated">
            <?php echo e($f_ad->views); ?> <i class="eye icon" style="float: right; margin-top: 18%;"></i>
        </span>
        <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/coins.svg" width="20" alt="">
        <span style="color: red; font-weight: 700;"><?php echo e(Helper::getPriceFormat($f_ad->price, $f_ad->currency)); ?></span>
    </div>
    <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($f_ad->slug); ?>"
        <?php echo e(!is_null($f_ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
        <div class="extra content" style="   direction: rtl;  text-align: center;padding-top: 0px;">
            <h4 style="  white-space: nowrap; direction: rtl;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        max-width: 200px;font-size: 14px;"> <span><?php echo e($f_ad->title); ?> </span> </h4>
        </div>
    </a>
    <div class="extra content">
        <div class="ui two buttons">
            <div class="ui basic green button bnt_card"><a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($f_ad->slug); ?>"
                    <?php echo e(!is_null($f_ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/phone.svg" width="20" alt=""
                        style="margin-top: 6%;float: right">
                    <h4 class="h_card" style="color: green;font-size: 14px;">إتصل</h4>
                </a></div>
            <div class="ui basic red button bnt_card"><a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($f_ad->slug); ?>"
                    <?php echo e(!is_null($f_ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/chatting.svg" width="20" alt=""
                        style="margin-top: 6%;float: right">
                    <h4 class="h_card" style="color: red;font-size: 14px;">دردشة</h4>
                </a></div>
        </div>
    </div>

</div> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php endif; ?>

<!-- Latest Ads -->
<div class="col-12">
    <!-- Section Title -->
    <div class="block-title" style="    text-align: center;">
            <h3><span> <?php echo e(Lang::get('home.lang_latest_ads')); ?></span></h3>
        </div>



    <div class="ui two column centered grid container">

        <?php if(count($latest_ads)): ?>
        <?php $__currentLoopData = $latest_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="ui card card_sm" style=" <?php if($ad->is_featured): ?>  border: 1px solid #ff000069;  <?php endif; ?> width: 260px;"
    dir="ltr">
    <div class="content">

        <a class="right floated "
            href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>">
            <div class="namecard"><?php echo e($ad->user_name{0}->first_name); ?> <?php echo e($ad->user_name{0}->last_name); ?></div>
            <img style="border: 1px solid green;" class="ui avatar image" src="<?php echo e(Profile::picture($ad->user_id)); ?>"
                title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"
                alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>">

        </a>
        <div class="meta"><?php echo e($ad->timeleft); ?></div>
    </div>
    <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"
        <?php echo e(!is_null($ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
    </a>
    <div class="image">
        <?php if($ad->is_featured): ?>
        <a class="ui teal right ribbon label">إعلان متميز</a>
        <?php endif; ?>
        <img src="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>">
    </div>

    <div class="content" style="padding-top: 2px;padding-bottom: 2px;color: grey;">
        <span class="right floated">
            <?php echo e($ad->views); ?> <i class="eye icon" style="float: right; margin-top: 18%;"></i>
        </span>
        <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/coins.svg" width="20" alt="">
        <span style="color: red; font-weight: 700;"><?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?></span>
    </div>
    <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"
        <?php echo e(!is_null($ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
        <div class="extra content" style="   direction: rtl;  text-align: center;padding-top: 0px;">
            <h4 style="  white-space: nowrap; direction: rtl;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 200px;font-size: 14px;"> <span><?php echo e($ad->title); ?> </span> </h4>
        </div>
    </a>
    <div class="extra content">
        <div class="ui two buttons">
            <div class="ui basic green button bnt_card"><a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"
                    <?php echo e(!is_null($ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/phone.svg" width="20" alt=""
                        style="margin-top: 6%;float: right">
                    <h4 class="h_card" style="color: green;font-size: 14px;">إتصل</h4>
                </a></div>
            <div class="ui basic red button bnt_card"><a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"
                    <?php echo e(!is_null($ad->affiliate_link) ? 'target="_blank"' : ''); ?>">
                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/chatting.svg" width="20" alt=""
                        style="margin-top: 6%;float: right">
                    <h4 class="h_card" style="color: red;font-size: 14px;">دردشة</h4>
                </a></div>
        </div>
    </div>

</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

</div>

<div style="display: flex; justify-content: center; margin:20px;">
        <a href="browse.html" class="ui negative basic button" style="width: 80%">
            <h4 style="color: red"><?php echo e(Lang::get('home.lang_see_more')); ?></h4>
        </a>
    </div>

</div>

<!-- Browse By Categories -->
<section id="freeShpping" class="borderTopSeparator " DIR="rtl">
    <div class="ui two column centered grid">
        <div class="ui piled segment ">
            <span class="customColor" aria-hidden="true"><i class="fa fa-bullhorn"></i></span>

            <div class="menuu">
                اكبر نسبه مبيعات<br> بالمملكة
            </div>
        </div>
        <div class="ui piled segment">
            <span class="customColor" aria-hidden="true"><i class="fa fa-life-bouy"></i></span>

            <div class="menuu">
                دعم فني<br> طوال اليوم
            </div>
        </div>
        <div class="ui piled segment">
            <span class="customColor" aria-hidden="true"><i class="fa fa-thumbs-up"></i></span>

            <div class="menuu">
                ضمان الشراء<br> وسرعه البيع
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
                            <input type="email" class="form-control"
                                placeholder="<?php echo e(Lang::get('footer.lang_subscribe_to_our_newsletter')); ?>"
                                id="newsletterEmail">
                        </div>
                        <div class="subscribe-button2">
                            <button type="button" id="newsletterSubscribe"
                                class="btn btn-primary font-additional hvr-wobble-bottom">
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
            success: function (response) {
                if (response.status == 'success') {

                    // Check if states enabled
                    if (response.states) {

                        $('#putStates').find('option').remove();
                        $('#putStates').append($('<option>', {
                            text: '<?php echo e(__('
                            home.lang_state ')); ?>',
                            value: 'all'
                        }));
                        $.each(response.data, function (array, object) {
                            $('#putStates').append($('<option>', {
                                value: object.id,
                                text: object.name
                            }))
                        });

                    } else if (response.cities) {

                        // Cities
                        $('#putCities').find('option').remove();
                        $('#putCities').append($('<option>', {
                            text: '<?php echo e(__('
                            home.lang_city ')); ?>',
                            value: 'all'
                        }));
                        $.each(response.data, function (array, object) {
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
            success: function (response) {
                if (response.status == 'success') {
                    $('#putCities').find('option').remove();
                    $('#putCities').append($('<option>', {
                        text: 'Select city',
                        value: 'all'
                    }));
                    $.each(response.data, function (array, object) {
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