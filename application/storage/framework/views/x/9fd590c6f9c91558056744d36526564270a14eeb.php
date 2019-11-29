<?php $__env->startSection('content'); ?>

<!-- Store Details -->
<div class="row">

    <div class="col-md-8">
        
        <div class="portlet light ">
            <!-- STAT -->
            <div class="row list-separated profile-stat">
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title"> <?php echo e($ads_today); ?> </div>
                    <div class="uppercase profile-stat-text"> Today Ads </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title"> <?php echo e($ads_month); ?> </div>
                    <div class="uppercase profile-stat-text"> Month </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title"> <?php echo e($ads_year); ?> </div>
                    <div class="uppercase profile-stat-text"> Year </div>
                </div>
            </div>
            <!-- END STAT -->
            <div>
                <h4 class="profile-desc-title">About <?php echo e($store->title); ?></h4>
                <p class="profile-desc-text"> <?php echo nl2br($store->long_desc); ?> </p>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-globe"></i>
                    <a href="<?php echo e($store->website); ?>" target="_blank"><?php echo e($store->website); ?></a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-twitter"></i>
                    <a href="<?php echo e($store->tw_page); ?>" target="_blank">Twitter صفحة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-facebook"></i>
                    <a href="<?php echo e($store->fb_page); ?>" target="_blank">Facebook صفحة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-google-plus"></i>
                    <a href="<?php echo e($store->go_page); ?>" target="_blank">Google صفحة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-youtube"></i>
                    <a href="<?php echo e($store->yt_page); ?>" target="_blank">Youtube قناة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-map-pin"></i>
                    <a href="#"><?php echo e($store->address); ?></a>
                </div>
            </div>
        </div>

    </div>
	
	<div class="col-md-4">

		<div class="profile-sidebar" style="width: 100%;">

            <div class="portlet light profile-sidebar-portlet ">

                <div class="profile-userpic">
                    <img src="<?php echo e($store->logo); ?>" class="img-responsive" alt=""> </div>

                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?php echo e($store->title); ?> </div>
                    <div class="profile-usertitle-job"> <?php echo e($store->username); ?> </div>
                </div>

                <div class="profile-userbuttons" style="padding-bottom: 20px;">
                    <a target="_blank" href="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>" class="btn btn-circle red btn-sm">مشاهدة المتجر</a>
                </div>

            </div>
        </div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>