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
                    <span class="caption-subject font-blue bold uppercase">اشعارات المستخدمين</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-people"></i></th>
                            <th>User</th>
                            <th class="text-center">حالة المستخدم</th>
                            <th class="text-center">تاريخ</th>
                            <th class="text-center">حالة الاشعارات</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($notifications) > 0): ?>
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

						<!-- User Avatar -->
                        <td class="text-center">
                            <div class="avatar">
                                <img src="<?php echo e(Profile::picture($notification->user_id)); ?>" class="img-avatar" alt="<?php echo e(Helper::username_by_id($notification->user_id)); ?>">
                            </div>
                        </td>

                        <!-- User Info -->
                        <td>
                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($notification->user_id)); ?>"><?php echo e(Profile::full_name($notification->user_id)); ?></a>
                            <div class="small text-muted">
                                <span><?php echo e(Helper::username_by_id($notification->user_id)); ?></span> | <?php echo e(Helper::date_ago($notification->created_at)); ?>

                            </div>
                        </td>

                        <!-- User Status -->
                        <td class="text-center">
                            <?php if(Profile::isActive($notification->user_id)): ?>
                            <span class="badge badge-success badge-roundless"> نشيط </span>
                            <?php else: ?> 
                            <span class="badge badge-danger badge-roundless"> قيد الانتظار </span>
                            <?php endif; ?>
                        </td>

                        <!-- Notification Date -->
                        <td class="text-center text-muted">
                            <?php echo e(Helper::date_ago($notification->created_at)); ?>

                        </td>

                        <!-- Notification Status -->
                        <td class="text-center">
                            <?php if($notification->is_read): ?>
                            <span class="badge badge-default badge-roundless"> مقروء </span>
                            <?php else: ?> 
                            <span class="badge badge-info badge-roundless"> غير مقروء </span>
                            <?php endif; ?>
                        </td>
                            
                        <!-- Options -->
                        <td class="text-center">
                            <div class="btn-group">
                                <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                <ul class="dropdown-menu pull-right" role="menu">
                                    <?php if(!Profile::isActive($notification->user_id)): ?>
                                    <li>
                                        <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/active/<?php echo e(Helper::username_by_id($notification->user_id)); ?>">
                                            <i class="glyphicon glyphicon-ok"></i> مستخدم نشط</a>
                                    </li>
                                    <?php else: ?> 
                                    <li>
                                        <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/inactive/<?php echo e(Helper::username_by_id($notification->user_id)); ?>">
                                            <i class="glyphicon glyphicon-remove"></i> مستخدم غير نشط</a>
                                    </li>
                                    <?php endif; ?>
                                    <li class="divider"> </li>
                                    <li>
                                        <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/notifications/users/delete/<?php echo e($notification->id); ?>">
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

                <?php if(count($notifications)): ?>
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