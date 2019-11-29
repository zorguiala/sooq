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
                    <span class="caption-subject font-blue bold uppercase">إخطارات المدفوعات</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-people"></i></th>
                            <th class="text-center">طريقة</th>
                            <th class="text-center">نوع</th>
                            <th class="text-center">كمية</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">تاريخ</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if($notifications): ?>
                        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <!-- User -->
                            <td class="text-center">
                                <a class="text-muted" target="_blank" href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($n->user_id)); ?>"><?php echo e(Helper::username_by_id($n->user_id)); ?></a>
                            </td>

                            <!-- Method -->
                            <td class="text-center">
                                <span class="badge badge-success badge-roundless"> <?php echo e($n->payment_method); ?> </span>
                            </td>

                            <!-- Type -->
                            <td class="text-center">
                                <?php if($n->payment_type == 'account'): ?>
                                <span class="badge badge-warning badge-roundless"> ترقية الحساب </span>
                                <?php else: ?> 
                                <span class="badge badge-danger badge-roundless"> ترقية الإعلان </span>
                                <?php endif; ?>
                            </td>

                            <!-- Amount -->
                            <td class="text-center text-muted">
                                <?php echo e($n->payment_amount); ?> <?php echo e(strtoupper($n->payment_currency)); ?>

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
                                    <a href="<?php echo e(Protocol::home()); ?>/dashboard/notifications/payments/delete/<?php echo e($n->id); ?>"><i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-trash"></i></a>
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