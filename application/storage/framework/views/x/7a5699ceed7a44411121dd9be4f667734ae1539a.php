<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('head'); ?>
<?php if(Auth::check() && Profile::hasStore(Auth::id())): ?>
<?php if(!is_null(Profile::hasStore(Auth::id())->tawk)): ?>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/<?php echo e(Profile::hasStore(Auth::id())->tawk); ?>/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">

    <div class="col-md-12">

        <?php if(!$store->status): ?>
        <div class="alert bg-danger alert-styled-left">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            <?php echo app('translator')->getFromJson('return/error.lang_store_is_not_active'); ?>
        </div>
        <?php endif; ?>

        <div class="profile-cover">
            <div class="profile-cover-img lozad" data-background-image="<?php echo e(Helper::store_cover($store->username)); ?>"></div>
            <div class="media">
                <div class="media-left">
                    <a href="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>" class="profile-thumb">
                        <img data-src="<?php echo e($store->logo); ?>" class="lozad img-circle img-md" alt="<?php echo e($store->title); ?>">
                    </a>
                </div>

                <div class="media-body">
                    <h1><?php echo e($store->title); ?> <small class="display-block">
                    <ul class="list-inline list-inline-separate text-white no-margin">
                                <li><?php echo e(Helper::date_ago($store->created_at)); ?></li>
                                <li><img data-src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/flags/<?php echo e($store->country); ?>.png" class="lozad" style="width: 18px;margin-right: 8px;"><?php echo e(Countries::country_name($store->country)); ?></li>

                                <?php if(Helper::settings_geo()->states_enabled): ?>
                                <li><?php echo e(Countries::state_name($store->state)); ?></li>
                                <?php endif; ?>

                                <?php if(Helper::settings_geo()->cities_enabled): ?>
                                <li><?php echo e(Countries::city_name($store->city)); ?></li>
                                <?php endif; ?>

                                <?php if(Auth::check() && !Auth::user()->is_admin): ?>
                                <?php if(Auth::id() == $store->owner_id): ?>
                                <li class="text-danger text-uppercase"><span class="text-muted">Ends at </span><?php echo e(Helper::dateToFormatted($store->ends_at)); ?></li>
                                <?php endif; ?>
                                <?php endif; ?>
                            </ul></small></h1>
                </div>

                <div class="media-right media-middle store-contact-url">
                    <ul class="list-inline list-inline-condensed no-margin-bottom text-nowrap">
                        <li><a data-toggle="modal" data-target="#contactStore" href="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>/contact" class="btn btn-default legitRipple"><i class="icon-envelop3 position-left"></i> <?php echo e(Lang::get('store.lang_contact_store', ['store' => $store->title])); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
            
        <!-- Store profile -->
        <div class="panel panel-flat store-panel-rtl">
            <div class="panel-body">

                    <p><?php echo nl2br($store->long_desc); ?></p>
                
            </div>

            <div class="panel-footer panel-footer-condensed"><a class="heading-elements-toggle"><i class="icon-more"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline list-inline-separate heading-text">
                        <li>
                            <b><?php echo e(Helper::count_store_ads($store->owner_id)); ?></b><span class="text-muted"> <?php echo e(Lang::get('store.lang_posts')); ?></span>
                        </li>
                        <li>
                            <b><?php echo e(Helper::count_store_views($store->owner_id)); ?></b><span class="text-muted"> <?php echo e(Lang::get('store.lang_views')); ?></span>
                        </li>
                        <li>
                            <b><?php echo e(Helper::count_store_likes($store->owner_id)); ?></b><span class="text-muted"> <?php echo e(Lang::get('store.lang_likes')); ?></span>
                        </li>
                    </ul>

                    <div class="heading-elements pull-right">
                        <ul class="list-inline store-social-media">
                            <li><a href="#" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-pin" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e($store->address); ?>"></i></a></li>
                            <?php if($store->website): ?>
                            <li><a target="_blank" href="<?php echo e($store->website); ?>" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-hyperlink"></i></a></li>
                            <?php endif; ?>

                            <?php if($store->fb_page): ?>
                            <li><a target="_blank" href="<?php echo e($store->fb_page); ?>" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-facebook"></i></a></li>
                            <?php endif; ?>

                            <?php if($store->tw_page): ?>
                            <li><a target="_blank" href="<?php echo e($store->tw_page); ?>" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-twitter"></i></a></li>
                            <?php endif; ?>

                            <?php if($store->go_page): ?>
                            <li><a target="_blank" href="<?php echo e($store->go_page); ?>" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-google"></i></a></li>
                            <?php endif; ?>

                            <?php if($store->yt_page): ?>
                            <li><a target="_blank" href="<?php echo e($store->yt_page); ?>" class="btn border-warning text-warning-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-youtube"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Contact Store Owners -->
        <div id="contactStore" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><?php echo e(Lang::get('store.lang_contact_store', ['store' => $store->title])); ?></h5>
                    </div>

                    <form action="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>/contact" method="POST" id="sendMessageStore">
                        <div class="modal-body">

                            <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

                            <!-- Your Full Name -->
                            <div class="form-group">
                                <label><?php echo e(Lang::get('store.lang_your_name')); ?></label>
                                <input type="text" placeholder="<?php echo e(Lang::get('store.lang_your_name_placeholder')); ?>" class="form-control" name="fullname">
                            </div>

                            <!-- Your E-mail Address -->
                            <div class="form-group">
                                <label><?php echo e(Lang::get('store.lang_email_address')); ?></label>
                                <input type="text" placeholder="<?php echo e(Lang::get('store.lang_email_address_placeholder')); ?>" class="form-control" name="email">
                            </div>

                            <!-- Your Phone Number -->
                            <div class="form-group">
                                <label><?php echo e(Lang::get('store.lang_phone_number')); ?></label>
                                <input type="text" placeholder="<?php echo e(Lang::get('store.lang_phone_number_placeholder')); ?>" class="form-control" name="phone">
                            </div>

                            <!-- Email Subject -->
                            <div class="form-group">
                                <label><?php echo e(Lang::get('store.lang_subject')); ?></label>
                                <input type="text" placeholder="<?php echo e(Lang::get('store.lang_subject_placeholder')); ?>" class="form-control" name="subject">
                            </div>

                            <!-- Message -->
                            <div class="form-group">
                                <label><?php echo e(Lang::get('store.lang_message')); ?></label>
                                <textarea rows="3" placeholder="<?php echo e(Lang::get('store.lang_message_placeholder')); ?>" class="form-control" name="message"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><?php echo e(Lang::get('store.lang_send_message')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
        
    <!-- Lasted Ads -->
    <div class="col-md-9">
        
        <div class="row">

            <?php if(count($ads)): ?>
            <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-4">

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
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>"></div>
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

            <div class="text-center" style="width: 100%;float: left;">
                <?php echo e($ads->links()); ?>

            </div>

            <?php else: ?>
            <div class="col-md-12">
                <div class="alert bg-info alert-styled-left">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    <?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

    </div>

    <!-- Right Side -->
    <div class="col-md-3">
        
        <!-- Categories -->
        <div class="panel panel-flat">
            <div class="category-title">
                <span><?php echo e(Lang::get('store.lang_categories')); ?></span>
            </div>

            <div class="category-content no-padding">
                <ul class="navigation navigation-alt navigation-accordion">

                    <?php if(count(Helper::parent_categories())): ?>
                    <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li class="navigation-header"><?php echo e($parent_category->category_name); ?></li>
                    <?php if(count(Helper::sub_categories($parent_category->id))): ?>
                    <?php $__currentLoopData = Helper::sub_categories($parent_category->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(Protocol::home()); ?>/category/<?php echo e($parent_category->category_slug); ?>/<?php echo e($sub->category_slug); ?>" class="text-semibold text-black"><span class="badge badge-default"><?php echo e(Helper::count_ads_by_category_user($sub->id, $store->owner_id)); ?></span> <?php echo e($sub->category_name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
        <!-- /categories -->

    </div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>