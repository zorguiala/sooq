<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Read Message -->
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
	
	<div class="col-md-9">

		<div class="panel panel-white">

			<!-- Mail toolbar -->
			<div class="panel-toolbar panel-toolbar-inbox">
				<div class="navbar navbar-default">
					<ul class="nav navbar-nav visible-xs-block no-border">
						<li>
							<a class="text-center collapsed legitRipple" data-toggle="collapse" data-target="#inbox-toolbar-toggle-single">
								<i class="icon-circle-down2"></i>
							</a>
						</li>
					</ul>

					<div class="navbar-collapse collapse" id="inbox-toolbar-toggle-single" style="height: auto;">
						<div class="btn-group navbar-btn">

							<!-- Reply -->
							<a href="<?php echo e(Protocol::home()); ?>/account/inbox/reply?to=<?php echo e($message->msg_from); ?>&ad=<?php echo e($message->ad_id); ?>" class="btn btn-default legitRipple"><i class="icon-reply"></i> <span class="hidden-xs position-right"><?php echo e(Lang::get('account/messages/read.lang_reply')); ?></span></a>

							<!-- Delete -->
							<a href="<?php echo e(Protocol::home()); ?>/account/inbox/delete/<?php echo e($message->id); ?>" class="btn btn-default legitRipple"><i class="icon-bin"></i> <span class="hidden-xs position-right"><?php echo e(Lang::get('account/messages/read.lang_delete')); ?></span></a>

						</div>

						<div class="pull-right-lg">
							<p class="navbar-text"><?php echo e(Helper::date_ago($message->created_at)); ?></p>
						</div>
					</div>
				</div>
			</div>
			<!-- /mail toolbar -->


			<!-- Mail details -->
			<div class="media stack-media-on-mobile mail-details-read">
				<?php if(Profile::hasStore(Helper::id_by_username($message->msg_from))): ?>
				<a href="<?php echo e(Protocol::home()); ?>/store/<?php echo e(Profile::hasStore(Helper::id_by_username($message->msg_from))->username); ?>" class="media-left" target="_blank">
					<img class="lozad img-rounded" data-src="<?php echo e(Profile::picture(Helper::id_by_username($message->msg_from))); ?>">
				</a>
				<?php else: ?> 
				<a href="#" class="media-left">
					<img class="lozad img-rounded" data-src="<?php echo e(Profile::picture(Helper::id_by_username($message->msg_from))); ?>">
				</a>
				<?php endif; ?>

				<div class="media-body">
					<h6 class="media-heading"><?php echo e($message->subject); ?></h6>
					<div class="letter-icon-title text-muted">
						<ul class="list-inline list-inline-separate heading-text">
							<?php if(Profile::hasStore(Helper::id_by_username($message->msg_from))): ?>
							<li><a class="text-muted" href="<?php echo e(Protocol::home()); ?>/store/<?php echo e(Profile::hasStore(Helper::id_by_username($message->msg_from))->username); ?>" target="_blank"><?php echo e(Profile::hasStore(Helper::id_by_username($message->msg_from))->title); ?></a></li>
							<?php else: ?>
							<li><?php echo e(Profile::full_name(Helper::id_by_username($message->msg_from))); ?></li> 
							<?php endif; ?>

							<?php if($message->show_email): ?>
							<li><?php echo e($message->email); ?></li>
							<?php endif; ?>

							<?php if($message->show_phone): ?>
							<li><?php echo e($message->phone); ?></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

			</div>
			<!-- /mail details -->


			<!-- Mail container -->
			<div class="mail-container-read">
				<?php echo nl2br($message->message); ?>

			</div>
			<!-- /mail container -->

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>