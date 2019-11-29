

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	
	<!-- Sub Categories -->
	<div class="col-md-12">

		<!-- Browse By Countries -->
        <div class="spec ">
            <h3><?php echo e($parent_category->category_name); ?></h3>
            <div class="ser-t">
                <b></b>
                <span><i></i></span>
                <b class="line"></b>
            </div>
        </div>


        <?php if(count($sub_categories)): ?>

        <div class="row cat_single_wrap">

            <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-2 col-sm-4 col-xs-6 text-center">

                <div class="cat_single">
                    <div class="cat_single_bg">
                        <div class="overlay_color panel" style="transform: skewX(-6deg);">
                        </div>
                    </div>
                    <div class="cat_single_content">
                        <a href="<?php echo e(Protocol::home()); ?>/category/<?php echo e($parent_category->category_slug); ?>/<?php echo e($category->category_slug); ?>" style="color: rgb(255, 255, 255);">
                            <img data-src="<?php echo e($category->icon); ?>" class="lozad">
                            <span class="cat_title"><?php echo e($category->category_name); ?></span>
                        </a>
                    </div>
                </div>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <?php else: ?>

        <!-- Nothing to show right now -->
		<div class="alert bg-info alert-styled-left">
		<?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>
    	</div>

        <?php endif; ?>

	</div>

    <!-- Latest Ads -->
    <div class="col-md-12">

        <!-- Section Title -->
        <div class="spec ">
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
                                <div class="card__avatar"><a href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="<?php echo e(Profile::picture($ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>" class="lozad avatar" width="40" height="40"><?php if(Profile::hasStore($ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"></i><?php endif; ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>

        <?php if(count($latest_ads)): ?>
        <div class="col-md-12 text-center mb-20">
            <?php echo e($latest_ads->links()); ?>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>