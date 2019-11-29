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
                    <span class="caption-subject font-blue-madison bold uppercase">القائمة المحظورة</span>
                </div>
                <div class="actions">
                    <a href="<?php echo e(Protocol::home()); ?>/dashboard/firewall/add" class="btn dark btn-outline sbold uppercase">Add IP</a>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-ban"></i></th>
                            <th class="text-center">بلد</th>
                            <th class="text-center">مدينة</th>
                            <th class="text-center">تاريخ الحظر</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if($firewall): ?>
                        <?php $__currentLoopData = $firewall; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <!-- IP Address -->
                            <td class="text-center text-muted">
                                <?php echo e($f->ip_address); ?>

                            </td>

                            <!-- Country -->
                            <td class="text-center text-muted">
                                <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/flags/<?php echo e(Tracker::ip($f->ip_address)->country_code()); ?>.png" style="height:24px;" class="tooltips" data-style="blue" data-container="body" data-original-title="<?php echo e(Tracker::ip($f->ip_address)->country_code()); ?>">
                            </td>

                            <!-- City -->
                            <td class="text-center text-muted">
                                <?php echo e(Tracker::ip($f->ip_address)->city()); ?>

                            </td>

                            <!-- Date -->
                            <td class="text-center text-muted">
                                <?php echo e(Helper::date_ago($f->created_at)); ?>

                            </td>  
        
                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?php echo e(Protocol::home()); ?>/dashboard/firewall/delete/<?php echo e($f->ip_address); ?>">
                                        <i style="color: #e73a3a;font-size: 15px;cursor: pointer;top: 3px;" class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>
                </table>

                <?php if($firewall): ?>
                <div class="text-center">
                    <?php echo e($firewall->links()); ?>

                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>