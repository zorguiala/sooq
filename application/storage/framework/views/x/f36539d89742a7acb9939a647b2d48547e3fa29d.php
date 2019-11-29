<?php $__env->startSection('content'); ?>

<!-- Quick stats -->
<div class="row">

    <div class="col-md-12">
        <!-- Session Messages -->
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>
    </div>

	<!-- Total Ads -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-bullhorn"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_ads); ?></span>
                </div>
                <div class="desc"> كل الاعلانات </div>
            </div>
        </a>
    </div>

    <!-- Total Categories -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-list"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_cats); ?></span>
                </div>
                <div class="desc"> ;كل الاقسام </div>
            </div>
        </a>
    </div>

    <!-- Total Stores -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-home"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_stores); ?></span>
                </div>
                <div class="desc"> كل المتاجر </div>
            </div>
        </a>
    </div>

    <!-- Total Users -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_users); ?></span>
                </div>
                <div class="desc"> كل الزوار </div>
            </div>
        </a>
    </div>

    <!-- Total Messages -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_messages); ?></span>
                </div>
                <div class="desc"> كل الرسائل </div>
            </div>
        </a>
    </div>

    <!-- Total Comments -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_comments); ?></span>
                </div>
                <div class="desc"> كل التعليقات </div>
            </div>
        </a>
    </div>

    <!-- Total Views -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-eye"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_views); ?></span>
                </div>
                <div class="desc"> كل المشاهدات </div>
            </div>
        </a>
    </div>

    <!-- Total Pages -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-file"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span><?php echo e($total_pages); ?></span>
                </div>
                <div class="desc"> كل الصفحات </div>
            </div>
        </a>
    </div>

</div>

<!-- Ads Visits -->
<div class="row">
    <div class="col-md-12">
        
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">إعلانات الإعلانات</span>
                </div>
            </div>
            <div class="portlet-body">

                <?php echo $visits->render(); ?>


            </div>
        </div>

    </div>
</div>

<!-- users and stores -->
<div class="row">
	
    <!-- users -->
	<div class="col-md-6">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">أحدث المستخدمين</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="general-item-list">

                    <?php if($latest_users): ?>
                    <?php $__currentLoopData = $latest_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">
                                <img class="item-pic rounded" src="<?php echo e(Profile::user_picture($user->id)); ?>">
                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e($user->username); ?>" class="item-name primary-link"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></a>
                                <span class="item-label"><?php echo e(Helper::date_ago($user->created_at)); ?></span>
                            </div>
                            <?php if($user->status): ?>
                            <span class="item-status">
                                <span class="badge badge-empty badge-success"></span> Active
                            </span>
                            <?php else: ?>
                            <span class="item-status">
                                <span class="badge badge-empty badge-danger"></span> Pending
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>

	</div>

    <!-- stores -->
    <div class="col-md-6">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">أحدث المتاجر</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="general-item-list">
                    <?php if($latest_stores): ?>
                    <?php $__currentLoopData = $latest_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">
                                <img class="item-pic rounded" src="<?php echo e($store->logo); ?>">
                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/stores/details/<?php echo e($store->username); ?>" class="item-name primary-link"><?php echo e($store->username); ?></a>
                                <span class="item-label"><?php echo e(Helper::date_ago($store->created_at)); ?></span>
                            </div>
                            <?php if($store->status): ?>
                            <span class="item-status">
                                <span class="badge badge-empty badge-success"></span> فتح
                            </span>
                            <?php else: ?>
                            <span class="item-status">
                                <span class="badge badge-empty badge-danger"></span> غلق
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>