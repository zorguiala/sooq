<?php $__env->startSection('content'); ?>

<div class="row">
    
    <div class="col-md-12">
        
        <!-- Sessions Messages -->
        <?php if(Session::has('success')): ?>
        <div class="custom-alerts alert alert-success fade in">
            <?php echo e(Session::get('success')); ?>

        </div>
        <?php endif; ?>

        <?php if(Session::has('error')): ?>
        <div class="custom-alerts alert alert-danger fade in">
            <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue bold uppercase">إعدادات الإعلانات</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-link"></i></th>
                            <th>Title</th>
                            <th class="text-center">قسم</th>
                            <th class="text-center">السعر</th>
                            <th class="text-center">متميز</th>
                            <th class="text-center">ارشيف</th>
                            <th class="text-center">ينتهي عند</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if($ads): ?>
                        <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <!-- Ad Image -->
                            <td class="text-center">
                                <div class="avatar">
                                    <img src="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($ad->ad_id); ?>/thumbnails/thumbnail_0.jpg" class="img-avatar" alt="<?php echo e($ad->title); ?>">
                                    <?php if($ad->status): ?>
                                    <span class="avatar-status tag-success tooltips" data-container="body" data-placement="top" data-original-title="Active Ad"></span>
                                    <?php else: ?>
                                    <span class="avatar-status tag-danger tooltips" data-container="body" data-placement="top" data-original-title="Pending Active"></span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Ad Info -->
                            <td>
                                <a target="_blank" href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>" class="text-dots tooltips" data-container="body" data-placement="top" data-original-title="<?php echo e($ad->title); ?>"><?php echo e($ad->title); ?></a>
                                <div class="small text-muted">
                                    <a class="text-muted text-uppercase" href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($ad->user_id)); ?>"><?php echo e(Helper::username_by_id($ad->user_id)); ?></a> | <?php echo e(Helper::date_ago($ad->created_at)); ?>

                                </div>
                            </td>

                            <!-- Ad Category -->
                            <td class="text-center">
                                <a target="_blank" href="<?php echo e(Helper::get_category($ad->category, true)); ?>">
                                    <?php echo e(Helper::get_category($ad->category)); ?>

                                </a>
                            </td>

                            <!-- Ad Price -->
                            <td class="text-center text-muted">
                                <?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?>

                            </td>

                            <!-- Is a featured Ad -->
                            <td class="text-center">
                                <?php if($ad->is_featured): ?>
                                <span class="badge badge-warning badge-roundless"> متميز </span>
                                <?php else: ?> 
                                <span class="badge badge-default badge-roundless"> غير متميز </span>
                                <?php endif; ?>
                            </td>

                            <!-- Is a Archived Ad -->
                            <td class="text-center">
                                <?php if($ad->is_archived): ?>
                                <span class="badge badge-danger badge-roundless"> أرشفة </span>
                                <?php else: ?> 
                                <span class="badge badge-info badge-roundless"> لم يأرشفة </span>
                                <?php endif; ?>
                            </td>

                            <!-- Ad Ends at -->
                            <td class="text-center text-muted">
                                <?php echo e(Helper::date_string($ad->ends_at)); ?>

                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/edit/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/stats/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-stats"></i> إحصائيات الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/comments/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-comment"></i> تعليقات الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/messages/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-envelope"></i> رسائل الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/offers/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-usd"></i> عروض الإعلان</a>
                                        </li>
                                        <?php if($ad->status): ?>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/inactive/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-remove"></i> عروض الإعلان</a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/active/<?php echo e($ad->ad_id); ?>">
                                                <i class="glyphicon glyphicon-ok"></i> نشر الاعلان</a>
                                        </li>
                                        <?php endif; ?>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/ads/delete/<?php echo e($ad->ad_id); ?>">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف الإعلان</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>
                </table>

                <?php if(count($ads) > 0): ?>
                <div class="text-center">
                    <?php echo e($ads->links()); ?>

                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>