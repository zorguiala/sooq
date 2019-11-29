<?php $__env->startSection('content'); ?>

<!-- Notifications -->
<div class="row">
    
    <div class="col-md-12">

        <!-- Session Messages -->
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?> 
        </div>
        <?php endif; ?>

        <div class="portlet light">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">إشعارات الإعلانات</span>
                </div>
            </div>

            <div class="portlet-body">
    
                
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-link"></i></th>
                            <th class="text-center">أرسلت بواسطة</th>
                            <th class="text-center">حالة الإعلان</th>
                            <th class="text-center">حالة الإخطار</th>
                            <th class="text-center">تاريخ</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if($notifications): ?>
                        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <!-- AD ID -->
                            <td class="text-center">
                                <a class="text-muted" target="_blank" href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($n->ad_id); ?>"><?php echo e($n->ad_id); ?></a>
                            </td>

                            <!-- Posted By -->
                            <td class="text-center">
                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($n->user_id)); ?>" target="_blank" class="text-muted"><?php echo e(Profile::full_name($n->user_id)); ?></a>
                            </td>

                            <!-- Ad Status -->
                            <td class="text-center">
                                <?php if(Helper::ad_status($n->ad_id)): ?>
                                <span class="badge badge-success badge-roundless"> نشرت </span>
                                <?php else: ?> 
                                <span class="badge badge-danger badge-roundless"> قيد الانتظار </span>
                                <?php endif; ?>
                            </td>

                            <!-- Notification Status -->
                            <td class="text-center">
                                <?php if($n->is_read): ?>
                                <span class="badge badge-default badge-roundless"> مقروء </span>
                                <?php else: ?> 
                                <span class="badge badge-info badge-roundless"> غير مقروء </span>
                                <?php endif; ?>
                            </td>

                            <!-- Created At -->
                            <td class="text-center text-muted">
                                <?php echo e(Helper::date_ago($n->created_at)); ?>

                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/edit/<?php echo e($n->ad_id); ?>">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير الإعلان</a>
                                        </li>
                                        <li>
                                            <?php if(Helper::ad_status($n->ad_id)): ?>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/inactive/<?php echo e($n->ad_id); ?>">
                                                <i class="glyphicon glyphicon-remove"></i> الإعلان غير النشط</a>
                                            <?php else: ?> 
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/ads/active/<?php echo e($n->ad_id); ?>">
                                                <i class="glyphicon glyphicon-ok"></i> الإعلان النشط</a>
                                            <?php endif; ?>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/notifications/ads/delete/<?php echo e($n->id); ?>">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف الإشعار</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>
                </table>

                <?php if($notifications): ?>
                <div class="text-center">
                    <?php echo e($notifications->links()); ?>

                </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>