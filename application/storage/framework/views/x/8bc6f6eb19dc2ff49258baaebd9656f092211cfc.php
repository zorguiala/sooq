<?php $__env->startSection('content'); ?>

<!-- Offers -->
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
                    <span class="caption-subject font-blue-madison bold uppercase">Offers Settings</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <div class="table-scrollable">
                    <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center"><i class="icon-link"></i></th>
                                <th class="text-center">عرض بواسطة</th>
                                <th class="text-center">عرض ل</th>
                                <th class="text-center">السعر</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">أنشئت في</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if($offers): ?>
                            <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <!-- Ad ID -->
                                <td class="text-center">
                                    <a href="<?php echo e(Protocol::home()); ?>/vi/<?php echo e($offer->ad_id); ?>" target="_blank" class="text-muted"><?php echo e($offer->ad_id); ?></a>
                                </td>

                                <!-- Offer By -->
                                <td class="text-center">
                                    <a class="text-muted" href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($offer->offer_by)); ?>"><?php echo e(Helper::username_by_id($offer->offer_by)); ?></a>
                                </td>

                                <!-- Offer To -->
                                <td class="text-center">
                                    <a class="text-muted" href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($offer->offer_to)); ?>"><?php echo e(Helper::username_by_id($offer->offer_to)); ?></a>
                                </td>

                                <!-- Price -->
                                <td class="text-center text-muted">
                                    <?php echo e(Helper::getPriceFormat($offer->price, Helper::ad_details($offer->ad_id, 'currency'))); ?>

                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    <?php if(is_null($offer->is_accepted)): ?>
                                    <span class="badge badge-default badge-roundless"> قيد الانتظار </span>
                                    <?php elseif($offer->is_accepted): ?>
                                    <span class="badge badge-success badge-roundless"> وافقت </span>
                                    <?php else: ?> 
                                    <span class="badge badge-danger badge-roundless"> رفض </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Created At -->
                                <td class="text-center text-muted">
                                    <?php echo e(Helper::date_ago($offer->created_at)); ?>

                                </td>

                                <!-- Options -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/offers/delete/<?php echo e($offer->id); ?>">
                                                    <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف العرض</a>
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

                <?php if($offers): ?>
                <div class="text-center">
                    <?php echo e($offers->links()); ?>

                </div>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>