<?php $__env->startSection('head'); ?>
<?php echo Charts::assets(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Ad Stats -->
<div class="row">
	
	<!-- Ad Visits -->
	<div class="col-md-12">
		
		<div class="portlet light " style="float: left;width: 100%">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">إحصائيات الإعلان</span>
                </div>
            </div>

            <div class="portlet-body">

            	<!-- Ad Visits -->
            	<div style="border: 1px solid #dadada;margin-bottom: 20px;">
            		<?php echo $visits->render(); ?>

            	</div>

            	<!-- Countries -->
            	<div style="border: 1px solid #dadada;margin-bottom: 20px;">
            		<?php echo $countries->render(); ?>

            	</div>

            	<!-- browsers -->
            	<div class="col-md-6" style="border: 1px solid #dadada;margin-bottom: 20px;">
            		<?php echo $browsers->render(); ?>

            	</div>

            	<!-- platforms -->
            	<div class="col-md-6" style="border: 1px solid #dadada;margin-bottom: 20px;">
            		<?php echo $platforms->render(); ?>

            	</div>

            	<!-- Other stats -->
                <div class="table-scrollable">
                	<table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center">بلد</th>
                                <th>Region</th>
                                <th>City</th>
                                <th>Browser</th>
                                <th>Platform</th>
                                <th class="text-center">إنسان آلي</th>
                                <th class="text-center">جهاز</th>
                                <th>اسم الجهاز</th>
                                <th>الإحالات</th>
                                <th>الكلمة</th>
                                <th class="text-center">النشاط الاخير</th>
                            </tr>
                        </thead>
                        <tbody>

                        	<?php if($other_stats): ?>
                        	<?php $__currentLoopData = $other_stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        	<tr>

                        		<!-- Country -->
                                <td class="text-center">
                                    <img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/flags/<?php echo e($stat->country); ?>.png" alt="<?php echo e(Countries::country_name($stat->country)); ?>" data-container="body" data-placement="top" data-original-title="<?php echo e(Countries::country_name($stat->country)); ?>" class="tooltips" style="height:24px;">
                                </td>

                                <!-- Region -->
                                <td class="text-muted">
                                	<?php if($stat->region): ?>
                        			<?php echo e($stat->region); ?>

                        			<?php else: ?> 
                        			N/A
                        			<?php endif; ?>
                        		</td>

                                <!-- City -->
                                <td class="text-muted">
                                    <?php if($stat->city): ?>
                                    <?php echo e($stat->city); ?>

                                    <?php else: ?> 
                                    N/A
                                    <?php endif; ?>
                                </td>

                        		<!-- Browser -->
                                <td class="text-muted">
                        			<?php echo e($stat->browserName); ?> <?php echo e($stat->browserVersion); ?>

                        		</td>

                        		<!-- Platform -->
                                <td class="text-muted">
                        			<?php echo e($stat->platformName); ?> <?php echo e($stat->platformVersion); ?>

                        		</td>

                        		<!-- Roboto -->
                        		<td class="text-center">
                        			<?php if($stat->isRobot): ?>
                        			<span class="badge badge-info badge-roundless"> <?php echo e($stat->robotName); ?> </span>
                        			<?php else: ?>
                        			<span class="text-muted">N/A</span>
                        			<?php endif; ?>
                        		</td>

                        		<!-- Device -->
                        		<td class="text-center">
                        			<?php if($stat->isDesktop): ?>
                        			<span class="badge badge-default badge-roundless"> سطح المكتب </span>
                        			<?php else: ?>
                        			<span class="badge badge-default badge-roundless"> هاتف </span>
                        			<?php endif; ?>
                        		</td>

                        		<!-- Device Name -->
                                <td class="text-muted">
                                	<?php if($stat->deviceName): ?>
                        			<?php echo e($stat->deviceName); ?>

                        			<?php else: ?> 
                        			N/A
                        			<?php endif; ?>
                        		</td>

                        		<!-- Referrer -->
                                <td class="text-muted">
                                	<?php if($stat->referrer): ?>
                        			<?php echo e($stat->referrer); ?>

                        			<?php else: ?> 
                        			N/A
                        			<?php endif; ?>
                        		</td>

                        		<!-- Referrer Keyword -->
                                <td class="text-muted">
                                	<?php if($stat->referrer_keyword): ?>
                        			<?php echo e($stat->referrer_keyword); ?>

                        			<?php else: ?> 
                        			N/A
                        			<?php endif; ?>
                        		</td>

                        		<!-- Last Activity -->
                                <td class="text-muted">
                        			<?php echo e(Helper::date_ago($stat->created_at)); ?>

                        		</td>
                        		
                        	</tr>
                        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        	<?php endif; ?>

                        </tbody>
                    </table>
                </div>

                <?php if($other_stats): ?>
                <div class="text-center">
                	<?php echo e($other_stats->links()); ?>

                </div>
                <?php endif; ?>
				
			</div>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>