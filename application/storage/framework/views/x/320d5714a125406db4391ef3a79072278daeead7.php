<?php $__env->startSection('content'); ?>

<!-- Articles -->
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
                    <span class="caption-subject font-blue bold uppercase">اعدادات المقالات</span>
                </div>
                <div class="actions">
                	<a href="<?php echo e(Protocol::home()); ?>/dashboard/articles/create" class="btn dark btn-outline sbold uppercase">إنشاء مقاله</a>
                </div>
            </div>

			<div class="portlet-body">

				<div class="">
					<table class="table table-hover table-outline m-b-0 hidden-sm-down">
			            <thead class="thead-default">
			                <tr>
			                    <th class="text-center"><i class="icon-link"></i></th>
			                    <th>عنوان</th>
			                    <th class="text-center">غلاف</th>
			                    <th class="text-center">أنشئت في</th>
			                    <th class="text-center">تم التحديث في</th>
			                    <th class="text-center">خيارات</th>
			                </tr>
			            </thead>
			            <tbody>

							<?php if(count($articles)): ?>
							<?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <tr>

			                	<!-- Articles ID -->
			                    <td class="text-center text-muted">
			                        <?php echo e($article->id); ?>

			                    </td>

			                    <!-- Title -->
			                    <td class="text-muted">
			                    	<a href="<?php echo e(Protocol::home()); ?>/blog/<?php echo e($article->slug); ?>" class="text-muted" target="_blank"><?php echo e($article->title); ?></a>
			                    </td>

			                    <!-- Cover -->
			                    <td class="text-center">
			                    	<a class="text-muted" href="<?php echo e(Protocol::home()); ?>/application/public/uploads/articles/<?php echo e($article->cover); ?>">عرض الغلاف
</a>
			                    </td>

			                    <!-- Created at -->
			                    <td class="text-muted text-center"> 
			                    	<?php echo e(Helper::date_ago($article->created_at)); ?>

			                    </td>

			                    <!-- Updated at -->
			                    <td class="text-muted text-center"> 
			                    	<?php echo e(Helper::date_ago($article->updated_at)); ?>

			                    </td>

			                    <!-- Options -->
	                            <td class="text-center">
	                                <div class="btn-group">
	                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li>
	                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/articles/edit/<?php echo e($article->id); ?>">
	                                                <i class="glyphicon glyphicon-pencil"></i> تحرير المقالة</a>
	                                        </li>
	                                        <li>
	                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/articles/delete/<?php echo e($article->id); ?>">
	                                                <i class="glyphicon glyphicon-trash"></i> حذف المقالة</a>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </td>
			                </tr>
			                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                <?php endif; ?>

			            </tbody>
			        </table>

					<?php if(count($articles) > 0): ?>
					<div class="text-center">
						<?php echo e($articles->links()); ?>

					</div>
					<?php endif; ?>

		        </div>

		    </div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>