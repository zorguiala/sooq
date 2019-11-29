<?php $__env->startSection('content'); ?>

<!-- Stores -->
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
		
		<div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">إعدادات المخازن</span>
                </div>
            </div>

			<div class="portlet-body">
				<table class="table table-hover table-outline m-b-0 hidden-sm-down">
		            <thead class="thead-default">
		                <tr>
		                    <th class="text-center"><i class="icon-people"></i></th>
		                    <th>Store</th>
		                    <th class="text-center">بلد</th>
		                    <th class="text-center">مدينة</th>
		                    <th class="text-center">عنوان</th>
		                    <th class="text-center">قسم</th>
		                    <th class="text-center">خيارات</th>
		                </tr>
		            </thead>
		            <tbody>

		            	<?php if($stores): ?>
		            	<?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		                <tr>

		                	<!-- Store Cover && Status -->
		                    <td class="text-center">
		                        <div class="avatar">
		                            <img src="<?php echo e($store->logo); ?>" class="img-avatar" alt="<?php echo e($store->title); ?>">
		                            <?php if($store->status): ?>
                                    <span class="avatar-status tag-success tooltips" data-container="body" data-placement="top" data-original-title="Active Store"></span>
                                    <?php else: ?>
                                    <span class="avatar-status tag-danger tooltips" data-container="body" data-placement="top" data-original-title="Pending Active"></span>
                                    <?php endif; ?>
		                        </div>
		                    </td>

		                    <!-- Store Info -->
		                    <td>
		                        <div><a href="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>" target="_blank"><?php echo e($store->title); ?></a></div>
		                        <div class="small text-muted">
		                            <a class="text-muted" target="_blank" href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e(Helper::username_by_id($store->owner_id)); ?>"><?php echo e(Profile::full_name($store->owner_id)); ?></a> | <?php echo e(Helper::date_ago($store->created_at)); ?>

		                        </div>
		                    </td>

		                    <!-- Store Country -->
		                    <td class="text-center">
                                <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/flags/<?php echo e($store->country); ?>.png" alt="<?php echo e(Countries::country_name($store->country)); ?>" title="<?php echo e(Countries::country_name($store->country)); ?>" style="height:24px;">
                            </td>

                            <!-- City -->
                            <td class="text-center text-muted">
                            	<?php echo e(Countries::city_name($store->city)); ?>

                            </td>

                            <!-- Address -->
                            <td class="text-center text-muted">
                            	<?php if($store->address): ?>
                            	<?php echo e($store->address); ?>

                            	<?php else: ?> 
                            	N/A
                            	<?php endif; ?>
                            </td>

                            <!-- Store Category -->
                            <td class="text-center">
                                <a target="_blank" href="<?php echo e(Helper::get_category($store->category, true)); ?>">
                                    <?php echo e(Helper::get_category($store->category)); ?>

                                </a>
                            </td>
		                    
		                    <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/stores/details/<?php echo e($store->username); ?>">
                                                <i class="glyphicon glyphicon-list-alt"></i> تفاصيل المتجر</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/stores/edit/<?php echo e($store->username); ?>">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير المتجر</a>
                                        </li>
                                        <?php if($store->status): ?>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/stores/inactive/<?php echo e($store->username); ?>">
                                                <i class="glyphicon glyphicon-remove"></i> متجر غير نشط</a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/stores/active/<?php echo e($store->username); ?>">
                                                <i class="glyphicon glyphicon-ok"></i> متجر نشط</a>
                                        </li>
                                        <?php endif; ?>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/stores/delete/<?php echo e($store->username); ?>">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف المتجر</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

		                </tr>

		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                <?php endif; ?>

		            </tbody>
		        </table>

                <?php if($stores): ?>
                <div class="text-center">
                    <?php echo e($stores->links()); ?>

                </div>
                <?php endif; ?>
                    
		    </div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>