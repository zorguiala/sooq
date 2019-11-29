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
                    <span class="caption-subject font-blue bold uppercase">فشل  تسجيل الدخول</span>
                </div>
                <div class="actions">
                    <a href="<?php echo e(Protocol::home()); ?>/dashboard/login/history/clear" class="btn dark btn-outline sbold uppercase">Clear</a>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-menu"></i></th>
                            <th class="text-center">عنوان بريد الكتروني</th>
                            <th class="text-center">بلد</th>
                            <th class="text-center">مدينة</th>
                            <th class="text-center">تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if($failed_login): ?>
                        <?php $__currentLoopData = $failed_login; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <!-- IP Address -->
                            <td class="text-center text-muted">
                                <?php echo e($f->ip_address); ?>

                            </td>

                            <!-- Email Address -->
                            <td class="text-center text-muted">
                                <?php echo e($f->email); ?>

                            </td>

                            <!-- Country -->
                            <td class="text-center text-muted">
                                <?php if(!is_null($f->country)): ?>
                                <?php echo e($f->country); ?>

                                <?php else: ?> 
                                N/A
                                <?php endif; ?>
                            </td>

                            <!-- City -->
                            <td class="text-center text-muted">
                                <?php if($f->city): ?>
                                <?php echo e($f->city); ?>

                                <?php else: ?> 
                                N/A
                                <?php endif; ?>
                            </td>

                            <!-- Date -->
                            <td class="text-center text-muted">
                                <?php echo e(Helper::date_ago($f->created_at)); ?>

                            </td> 
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>
                </table>

                <?php if($failed_login): ?>
                <div class="text-center">
                    <?php echo e($failed_login->links()); ?>

                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>