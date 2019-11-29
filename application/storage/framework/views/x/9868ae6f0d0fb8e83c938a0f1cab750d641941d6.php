<?php $__env->startSection('content'); ?>

<!-- Pages -->
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
                    <span class="caption-subject font-blue-madison bold uppercase">إعدادات الصفحات</span>
                </div>
                <div class="actions">
                	<a href="<?php echo e(Protocol::home()); ?>/dashboard/pages/create" class="btn dark btn-outline sbold uppercase">انشاء صفحة</a>
                </div>
            </div>

			<div class="portlet-body">
				<table class="table table-hover table-outline m-b-0 hidden-sm-down">
		            <thead class="thead-default">
		                <tr>
		               		<th class="text-center"><i class="icon-link"></i></th>
		                    <th class="text-center">اسم الصفحة</th>
		                    <th class="text-center">الصفحة</th>
		                    <th class="text-center"> Footer ودجت </th>
		                    <th class="text-center">أنشئت في</th>
		                    <th class="text-center">خيارات</th>
		                </tr>
		            </thead>
		            <tbody>

						<?php if($pages): ?>
						<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                <tr>

		                	<!-- Pages ID -->
		                	<td class="text-center text-muted">
		                		<?php echo e($page->id); ?>

		                	</td>

		                	<!-- Page Name -->
		                    <td class="text-center">
		                        <a class="text-muted" href="<?php echo e(Protocol::home()); ?>/page/<?php echo e($page->page_slug); ?>" target="_blank"><?php echo e($page->page_name); ?></a>
		                    </td>

		                    <!-- Page Slug -->
		                    <td class="text-center text-muted">
		                        <?php echo e($page->page_slug); ?>

		                    </td>

		                    <!-- Page Widget -->
		                    <td class="text-center text-muted">
		                        <?php echo e(Config::get('pages.'.$page->page_col)); ?>

		                    </td>

		                    <!-- Date -->
		                    <td class="text-center text-muted">
		                        <?php echo e(Helper::date_ago($page->created_at)); ?>

		                    </td>

		                    <!-- Options -->
		                    <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/pages/edit/<?php echo e($page->page_slug); ?>">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير الصفحة</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/pages/delete/<?php echo e($page->page_slug); ?>">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف الصفحة</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

		                </tr>
		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                <?php endif; ?>

		            </tbody>
		        </table>

		        <?php if($pages): ?>
                <div class="text-center">
                    <?php echo e($pages->links()); ?>

                </div>
                <?php endif; ?>
                
		    </div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>