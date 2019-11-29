<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Store Feedback -->
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
	
	<!-- Store Feedback -->
	<div class="col-md-9">
		
		<div class="panel panel-flat">

			<div class="table-responsive">
				<table class="table table-togglable table-hover">
					<thead>
						<tr>
							<th data-toggle="true"><?php echo e(Lang::get('table.lang_full_name')); ?></th>
							<th data-hide="phone"><?php echo e(Lang::get('table.lang_email_address')); ?></th>
							<th data-hide="phone,tablet"><?php echo e(Lang::get('table.lang_phone_number')); ?></th>
							<th data-hide="phone,tablet"><?php echo e(Lang::get('table.lang_subject')); ?></th>
							<th data-hide="phone,tablet"><?php echo e(Lang::get('table.lang_message')); ?></th>
							<th data-hide="phone" class="text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
							<th data-hide="phone" class="text-center"><?php echo e(Lang::get('table.lang_date')); ?></th>
							<th class="text-center" style="width: 30px;"><i class="icon-menu"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php if($feedback): ?>
						<?php $__currentLoopData = $feedback; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<!-- Full Name -->
							<td><?php echo e($feed->name); ?></td>

							<!-- Email Address -->
							<td><a class="text-muted" href="mailto:<?php echo e($feed->email); ?>"><?php echo e($feed->email); ?></a></td>

							<!-- Phone Number -->
							<td><?php echo e($feed->phone); ?></td>

							<!-- Subject -->
							<td><?php echo e($feed->subject); ?></td>

							<!-- Message -->
							<td><?php echo e($feed->message); ?></td>

							<!-- status -->
							<?php if($feed->is_read): ?>
							<td class="text-center"><span class="label label-default"><?php echo e(Lang::get('badges.lang_read')); ?></span></td>
							<?php else: ?> 
							<td class="text-center"><span class="label label-success"><?php echo e(Lang::get('badges.lang_unread')); ?></span></td>
							<?php endif; ?>

							<!-- Date -->
							<td class="text-center"><?php echo e(Helper::date_ago($feed->created_at)); ?></td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('tooltips.lang_delete_feedback')); ?>" href="<?php echo e(Protocol::home()); ?>/account/store/feedback/delete/<?php echo e($feed->id); ?>"><i class="icon-bin"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</tbody>
				</table>

				<?php if($feedback): ?>
				<div class="text-center mb-15 mt-15">
					<?php echo e($feedback->links()); ?>

				</div>
				<?php endif; ?>


			</div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>