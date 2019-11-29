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
                    <span class="caption-subject font-blue-madison bold uppercase">قائمة المستخدمين</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-people"></i></th>
                            <th>المستعمل</th>
                            <th class="text-center">بلد</th>
                            <th>عنوان بريد الكتروني</th>
                            <th class="text-center">جنس</th>
                            <th class="text-center">الحساب</th>
                            <th class="text-center">مستوى</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if($users): ?>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <!-- User Avatar -->
                            <td class="text-center">
                                <div class="avatar">
                                    <img src="<?php echo e(Profile::picture($user->id)); ?>" class="img-avatar" alt="<?php echo e($user->username); ?>">
                                    <?php if($user->status): ?>
                                    <span class="avatar-status tag-success tooltips" data-container="body" data-placement="top" data-original-title="Active User"></span>
                                    <?php else: ?>
                                    <span class="avatar-status tag-danger tooltips" data-container="body" data-placement="top" data-original-title="Pending Active"></span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- User Info -->
                            <td>
                                <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e($user->username); ?>"><?php echo e($user->first_name); ?>  <?php echo e($user->last_name); ?></a>
                                <div class="small text-muted">
                                    <span><?php echo e($user->username); ?></span> | <?php echo e(Helper::date_ago($user->created_at)); ?>

                                </div>
                            </td>

                            <!-- User Country -->
                            <td class="text-center">
                                <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/flags/<?php echo e($user->country_code); ?>.png" alt="<?php echo e(Countries::country_name($user->country_code)); ?>" title="<?php echo e(Countries::country_name($user->country_code)); ?>" style="height:24px;">
                            </td>
                            <td>
                                <span class="text-muted"><?php echo e($user->email); ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($user->gender): ?>
                                <span class="text-black">ولد</span>
                                <?php else: ?> 
                                <span class="text-black">بنت</span>
                                <?php endif; ?>
                            </td>

                            <!-- Account Type -->
                            <td class="text-center">
                                <?php if($user->account_type): ?>
                                <span class="badge badge-success badge-roundless"> المحترفين </span>
                                <?php else: ?> 
                                <span class="badge badge-default badge-roundless"> اساسي </span>
                                <?php endif; ?>
                            </td>

                            <!-- User Level -->
                            <td class="text-center">
                                <?php if($user->is_admin): ?>
                                <span class="badge badge-danger badge-roundless"> Administrator </span>
                                <?php elseif(!$user->is_admin AND $user->is_moderator): ?>
                                <span class="badge badge-warning badge-roundless"> Moderator </span>
                                <?php else: ?>
                                <span class="badge badge-default badge-roundless"> Member </span>
                                <?php endif; ?>
                            </td>   
        
                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <?php if(!Profile::hasStore($user->id)): ?>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/<?php echo e($user->username); ?>/create/store">
                                                <i class="glyphicon glyphicon-shopping-cart"></i> إنشاء المتجر</a>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-user"></i> بيانات المستخدم</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/ads/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-list-alt"></i> إعلانات هذا المستخدم</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/comments/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-comment"></i> تعليقات المستخدم</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/edit/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير العضو</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/warning/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-flag"></i> إرسال تحذير</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/warnings/delete/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-warning-sign"></i> حذف التحذيرات</a>
                                        </li>
                                        <li>
                                            <?php if($user->status): ?>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/inactive/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-remove"></i> مستخدم غير نشط</a>
                                            <?php else: ?> 
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/users/active/<?php echo e($user->username); ?>">
                                                <i class="glyphicon glyphicon-ok"></i> مستخدم نشط</a>
                                            <?php endif; ?>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/users/delete/<?php echo e($user->username); ?>">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> مسح المستخدم</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>
                </table>

                <?php if($users): ?>
                <div class="text-center">
                    <?php echo e($users->links()); ?>

                </div>
                <?php endif; ?>
                
            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>