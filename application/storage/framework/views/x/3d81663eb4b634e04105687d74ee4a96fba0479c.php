<?php $__env->startSection('content'); ?>

<!-- Comments -->
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
                    <span class="caption-subject font-blue-madison bold uppercase">إعدادات التعليقات</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <div class="table-responsive">

                    <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center"><i class="icon-people"></i></th>
                                <th>User</th>
                                <th class="text-center">AD ID</th>
                                <th class="text-center">Pinned</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">أنشئت في</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if($comments): ?>
                            <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                
                                <!-- User Avatar -->
                                <td class="text-center">
                                    <div class="avatar">
                                        <img src="<?php echo e(Profile::picture($comment->user_id)); ?>" class="img-avatar" alt="<?php echo e(Helper::username_by_id($comment->user_id)); ?>">
                                    </div>
                                </td>

                                <!-- User Info -->
                                <td>
                                    <?php if(Profile::hasStore($comment->user_id)): ?>
                                    <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($comment->user_id)); ?>"><?php echo e(Profile::hasStore($comment->user_id)->title); ?></a>
                                    <div class="small text-muted">
                                        <span><?php echo e(Profile::hasStore($comment->user_id)->username); ?></span> | <?php echo e(Helper::date_ago($comment->created_at)); ?>

                                    </div>
                                    <?php else: ?> 
                                    <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($comment->user_id)); ?>"><?php echo e(Profile::full_name($comment->user_id)); ?></a>
                                    <div class="small text-muted">
                                        <span><?php echo e(Helper::username_by_id($comment->user_id)); ?></span> | <?php echo e(Helper::date_ago($comment->created_at)); ?>

                                    </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Ad ID -->
                                <td class="text-center">
                                    <a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($comment->ad_id); ?>" target="_blank" class="text-muted"><?php echo e($comment->ad_id); ?></a>
                                </td>

                                <!-- Is Pinned CM -->
                                <td class="text-center">
                                    <?php if($comment->is_pinned): ?>
                                    <span class="badge badge-info badge-roundless"> Pinned </span>
                                    <?php else: ?> 
                                    <span class="badge badge-default badge-roundless"> Not Pinned </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    <?php if($comment->status): ?>
                                    <span class="badge badge-success badge-roundless"> نشرت </span>
                                    <?php else: ?> 
                                    <span class="badge badge-danger badge-roundless"> قيد الانتظار </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Created At -->
                                <td class="text-center text-muted">
                                    <?php echo e(Helper::date_ago($comment->created_at)); ?>

                                </td>

                                <!-- Options -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/comments/read/<?php echo e($comment->id); ?>">
                                                    <i class="glyphicon glyphicon-eye-open"></i> قراءة تعليق</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/comments/edit/<?php echo e($comment->id); ?>">
                                                    <i class="glyphicon glyphicon-pencil"></i> تعديل التعليق</a>
                                            </li>
                                            <li>
                                                <?php if($comment->status): ?>
                                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/comments/inactive/<?php echo e($comment->id); ?>">
                                                    <i class="glyphicon glyphicon-remove"></i> تعليق غير نشط</a>
                                                <?php else: ?> 
                                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/comments/active/<?php echo e($comment->id); ?>">
                                                    <i class="glyphicon glyphicon-ok"></i> التعليق النشط</a>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if($comment->is_pinned): ?>
                                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/comments/unpin/<?php echo e($comment->id); ?>">
                                                    <i class="glyphicon glyphicon-flash"></i> إزالة تعليق</a>
                                                <?php else: ?> 
                                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/comments/pin/<?php echo e($comment->id); ?>">
                                                    <i class="glyphicon glyphicon-pushpin"></i> Pin Comment</a>
                                                <?php endif; ?>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/comments/delete/<?php echo e($comment->id); ?>">
                                                    <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف تعليق</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </tbody>
                    </table>

                </div>

                <?php if($comments): ?>
                <div class="text-center">
                    <?php echo e($comments->links()); ?>

                </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>