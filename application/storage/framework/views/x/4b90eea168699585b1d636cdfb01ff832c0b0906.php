<?php $__env->startSection('content'); ?>

<!-- Categories -->
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
                    <span class="caption-subject font-blue bold uppercase">إعدادات الأقسام</span>
                </div>
                <div class="actions">
                	<a href="<?php echo e(Protocol::home()); ?>/dashboard/categories/create" class="btn dark btn-outline sbold uppercase">إنشاء قسم</a>
                </div>
            </div>

			<div class="portlet-body">

				<div class="table">
					<table class="table table-hover table-outline m-b-0 hidden-sm-down">
			            <thead class="thead-default">
			                <tr>
			                    <th class="text-center"><i class="icon-link"></i></th>
			                    <th>قسم</th>
			                    <th>Parent</th>
			                    <th class="text-center">نوع القسم</th>
			                    <th class="text-center">أنشئت في</th>
			                    <th class="text-center">مجموع الإعلانات</th>
			                    <th class="text-center">خيارات</th>
			                </tr>
			            </thead>
			            <tbody>

							<?php if(count($categories)): ?>
							<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <tr>

			                	<!-- Category ID -->
			                    <td class="text-center text-muted">
			                        <?php echo e($category->id); ?>

			                    </td>

			                    <td class="text-muted">
			                    	<strong><?php echo e(Helper::get_category($category->id)); ?></strong>
			                    </td>
			                    <td class="text-muted">
			                    	<?php if($category->is_sub): ?>
			                    	<strong><?php echo e(Helper::get_category($category->parent_category)); ?></strong>
			                    	<?php else: ?> 
			                    	N/A
			                    	<?php endif; ?>
			                    </td>

								<!-- Category type -->
								<td class="text-center">
									<?php if($category->is_sub): ?>
									<span class="badge badge-success badge-roundless"> القسم الفرعي </span>
									<?php else: ?> 
									<span class="badge badge-danger badge-roundless"> القسم الرئيسي </span>
									<?php endif; ?>
								</td>

			                    <td class="text-center text-muted">
			                        <?php echo e(Helper::date_ago($category->created_at)); ?>

			                    </td>
			                    <td class="text-center text-muted">
			                        <?php echo e(Helper::count_ads_by_category($category->id)); ?>

			                    </td>
			                    <!-- Options -->
	                            <td class="text-center">
	                                <div class="btn-group">
	                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li>
	                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/categories/edit/<?php echo e($category->id); ?>">
	                                                <i class="glyphicon glyphicon-pencil"></i> تحرير القسم</a>
	                                        </li>
	                                        <li class="divider"> </li>
	                                        <li>
	                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/categories/delete/<?php echo e($category->id); ?>">
	                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف القسم</a>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </td>
			                </tr>
			                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                <?php endif; ?>

			            </tbody>
			        </table>

					<?php if(count($categories) > 0): ?>
					<div class="text-center">
						<?php echo e($categories->links()); ?>

					</div>
					<?php endif; ?>

		        </div>

		    </div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>