<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Failed Login History -->
<div class="row">

	<!-- Session Messages -->
	<div class="col-md-12">
		<?php if(Session::has('success')): ?>
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('success')); ?>

	    </div>
	    <?php endif; ?>
	    <?php if(Session::has('error')): ?>
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('error')); ?>

	    </div>
	    <?php endif; ?>
	</div>

	<?php echo $__env->make(Theme::get().'.account.include.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<!-- Failed Login History -->
	<div class="col-md-9">
		
		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th><?php echo e(Lang::get('table.lang_email_address')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_country')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_city')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_date')); ?></th>
							<th class="col-md-2 text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
						</tr>
					</thead>
					<tbody>

						<?php if($failed_login): ?>
						<?php $__currentLoopData = $failed_login; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $login): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<!-- Email Address -->
							<td class="text-muted">
								<?php echo e($login->email); ?>

							</td>

							<!-- Country -->
							<td class="text-center"><span class="text-muted"><?php echo e($login->country); ?></span></td>

							<!-- City -->
							<td class="text-center"><span class="text-muted"><?php echo e(is_null($login->city) ? $login->city : 'N/A'); ?></span></td>

							<!-- Date -->
							<td class="text-center text-muted">
								<?php echo e(Helper::date_ago($login->created_at)); ?>

							</td>

							<!-- Status -->
							<td class="text-center"><span class="label bg-danger"><?php echo e(Lang::get('badges.lang_failed')); ?></span></td>

						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>

					</tbody>
				</table>
	
				<?php if($failed_login): ?>
				<div class="text-center mt-20 mb-20">
					<?php echo e($failed_login->links()); ?>

				</div>
				<?php endif; ?>

			</div>

			<?php if(!$failed_login): ?>
			<div class="alert alert-info alert-styled-left alert-bordered">
				<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
				<?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>
		    </div>
			<?php endif; ?>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>