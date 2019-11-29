<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Account Payments -->
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
	
	<!-- Account Payments -->
	<div class="col-md-9">
		
		<div class="panel panel-flat">

			<?php if(count($payments)): ?>
			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th class="text-center"><?php echo e(Lang::get('table.lang_brand')); ?></th>
							<th><?php echo e(Lang::get('table.lang_transaction_id')); ?></th>
							<th><?php echo e(Lang::get('table.lang_credit_card')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_amount')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_status')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_date')); ?></th>
							<th class="text-center"><?php echo e(Lang::get('table.lang_ends_at')); ?></th>
						</tr>
					</thead>
					<tbody>

						<?php if($payments): ?>
						<?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							
							<!-- Brand -->
							<td class="text-center">
								<span class="label label-primary"><?php echo e($payment->brand); ?></span>
							</td>

							<!-- Transaction ID -->
							<td class="text-muted">
								<?php echo e($payment->transaction_id); ?>

							</td>

							<!-- Credit Card -->
							<td class="text-muted">
								<?php if($payment->card_number): ?>
								XXXX XXXX XXXX <?php echo e($payment->card_last_four); ?>

								<?php else: ?> 
								N/A
								<?php endif; ?>
							</td>

							<!-- Amount -->
							<td class="text-center text-muted">
								<?php echo e($payment->amount); ?> <?php echo e(strtoupper($payment->currency)); ?>

							</td>

							<!-- status -->
							<td class="text-center">
								<?php if(is_null($payment->is_accepted)): ?>
								<span class="label label-default"><?php echo e(Lang::get('badges.lang_pending')); ?></span>
								<?php elseif($payment->is_accepted): ?>
								<span class="label label-success"><?php echo e(Lang::get('badges.lang_accepted')); ?></span>
								<?php else: ?> 
								<span class="label label-danger"><?php echo e(Lang::get('badges.lang_refused')); ?></span>
								<?php endif; ?>
							</td>

							<!-- Payment Date -->
							<td class="text-center text-muted">
								<?php echo e(Helper::date_ago($payment->created_at)); ?>

							</td>

							<!-- Ends Date -->
							<td class="text-center text-muted">
								<?php echo e(Helper::date_string($payment->ends_at)); ?>

							</td>

						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>

					</tbody>
				</table>
				
				<div class="pr-20 pl-20 text-center">
					
					<div class="mt-20">
						<?php echo e($payments->links()); ?>

					</div>

					<div class="mt-10 mb-20">
						<a href="<?php echo e(Protocol::home()); ?>/account/payments/ads" class="label label-flat border-grey text-grey-600"><?php echo e(Lang::get('badges.lang_ads_upgrade_history')); ?></a>
					</div>
				</div>

			</div>
			<?php else: ?>
			<div class="panel-body">
				<div class="alert bg-info alert-styled-left mt-20">
					<button type="button" class="close" data-dismiss="alert">
					<?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>
			    </div>
			</div>
			<?php endif; ?>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>