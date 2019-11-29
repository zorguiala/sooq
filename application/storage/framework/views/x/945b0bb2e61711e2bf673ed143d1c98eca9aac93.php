<?php $__env->startSection('content'); ?>

<!-- Currencies -->
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
                    <span class="caption-subject font-blue bold uppercase">اعدادات العملات</span>
                </div>
                <div class="actions">
                	<a href="<?php echo e(Protocol::home()); ?>/dashboard/currencies/create" class="btn dark btn-outline sbold uppercase">إنشاء عملة</a>
                </div>
            </div>

			<div class="portlet-body">

				<div class="">
					<table class="table table-hover table-outline m-b-0 hidden-sm-down">
			            <thead class="thead-default">
			                <tr>
			                    <th class="text-center"><i class="icon-link"></i></th>
			                    <th>Country</th>
			                    <th>Currency Code</th>
			                    <th>Currency Locale</th>
			                    <th class="text-center">Options</th>
			                </tr>
			            </thead>
			            <tbody>

							<?php if(count($currencies)): ?>
							<?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <tr>

			                	<!-- Currency ID -->
			                    <td class="text-center text-muted">
			                        <?php echo e($currency->id); ?>

			                    </td>

								<!-- Currency Country -->
			                    <td class="text-muted">
			                    	<strong><?php echo e(Countries::country_by_id($currency->country_id)); ?></strong>
			                    </td>

			                    <!-- Currency Code -->
			                    <td class="text-muted">
			                    	<?php echo e($currency->code); ?>

			                    </td>

			                    <!-- Currency locale -->
			                    <td class="text-muted">
			                    	<?php echo e($currency->locale); ?>

			                    </td>

			                    <!-- Options -->
	                            <td class="text-center">
	                                <div class="btn-group">
	                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li>
	                                            <a href="<?php echo e(Protocol::home()); ?>/dashboard/currencies/edit/<?php echo e($currency->code); ?>">
	                                                <i class="glyphicon glyphicon-pencil"></i> تحرير العملة</a>
	                                        </li>
	                                        <li class="divider"> </li>
	                                        <li>
	                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="<?php echo e(Protocol::home()); ?>/dashboard/currencies/delete/<?php echo e($currency->code); ?>">
	                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف العملة</a>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </td>
			                </tr>
			                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                <?php endif; ?>

			            </tbody>
			        </table>

					<?php if(count($currencies) > 0): ?>
					<div class="text-center">
						<?php echo e($currencies->links()); ?>

					</div>
					<?php endif; ?>

		        </div>

		    </div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>