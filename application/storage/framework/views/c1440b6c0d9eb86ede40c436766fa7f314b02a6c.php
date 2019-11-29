<?php $__env->startSection('seo'); ?>



<?php echo SEO::generate(); ?>




<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<div class="row">

	

	<!-- Sub Categories -->

	<div class="col-md-12">



		<!-- Browse By Countries -->
        <div class="block-title" style="    text-align: center;">
				<h3><span><?php echo e($parent_category->category_name); ?></span></h3>
			</div>


						</div>

			


        <?php if(count($sub_categories)): ?>



        <div class="row" DIR="RTL">


            <div class="ui horizontal segments col-md-12" style="margin: 0px; border:0px; box-shadow: 0 0 0 0;  text-align: center;">
                <div class="row ui  centered grid" >
            <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
            

                
                    <div class="ui segment col-md-2 col-sm-3 col-xs-6" style="margin:0px;    border-radius: 0;                    box-shadow: 0 0 0 0;">
        
                        <div class="imgover">
                            <img src="<?php echo e($category->icon); ?>" width="50" alt="">
                        </div>
        
                        <a class="menuu" href="<?php echo e(Protocol::home()); ?>/category/<?php echo e($parent_category->category_slug); ?>/<?php echo e($category->category_slug); ?>">
                            <?php echo e($category->category_name); ?></a>
        
                    </div>
                



            
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

        </div>



        <?php else: ?>



        <!-- Nothing to show right now -->

		<div class="alert bg-info alert-styled-left">

		<?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>

    	</div>



        <?php endif; ?>



	</div>



    <!-- Latest Ads -->

    <div class="col-md-12 container">



        <div class="row ui  centered grid">


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
            
            </div>            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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