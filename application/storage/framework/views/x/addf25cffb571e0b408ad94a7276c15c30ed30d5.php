

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	<div class="col-md-9">

		<!-- Post -->
		<div class="panel">
			<div class="panel-body">
				<div class="content-group-lg">
					<div class="content-group text-center">
						<a href="#" class="display-inline-block">
							<img data-src="<?php echo e(Protocol::home()); ?>/application/public/uploads/articles/<?php echo e($article->cover); ?>" class="lozad img-responsive" alt="">
						</a>
					</div>

					<h3 class="text-semibold mb-5">
						<a href="#" class="text-default"><?php echo e($article->title); ?></a>
					</h3>

					<ul class="list-inline list-inline-separate text-muted content-group">
						<li>By <a href="#" class="text-muted"><?php echo e(Profile::full_name_by_username($article->username)); ?></a></li>
						<li><?php echo e(Helper::date_string($article->created_at)); ?></li>
					</ul>

					<div class="content-group">
						<?php echo $article->content; ?>

					</div>
				</div>
				
			</div>
		</div>
		<!-- /post -->

	</div>


	<div class="col-md-3">
		
		<div class="sidebar sidebar-default sidebar-separate">
			<div class="sidebar-content">


				<!-- Share -->
				<div class="sidebar-category">
					<div class="category-title">
						<span>Share</span>
					</div>

					<div class="category-content no-padding-bottom text-center">
						<ul class="list-inline no-margin">
							<li>
								<a href="https://www.facebook.com/sharer.php?u=<?php echo e(Protocol::home()); ?>/blog/<?php echo e($article->slug); ?>" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-facebook"></i>
								</a>
							</li>
							<li>
								<a href="https://twitter.com/share?url=<?php echo e(Protocol::home()); ?>/blog/<?php echo e($article->slug); ?>&text=<?php echo e($article->title); ?>" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-twitter"></i>
								</a>
							</li>
							<li>
								<a href="https://plus.google.com/share?url=<?php echo e(Protocol::home()); ?>/blog/<?php echo e($article->slug); ?>" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-google-plus"></i>
								</a>
							</li>
							<li>
								<a href="https://www.stumbleupon.com/submit?url=<?php echo e(Protocol::home()); ?>/blog/<?php echo e($article->slug); ?>&title=<?php echo e($article->title); ?>" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-stumbleupon"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /share -->

			</div>
		</div>

		<!-- Advertisements -->
		<?php if(Helper::ifCanSeeAds()): ?>
		<div class="advertisment">
			<?php echo Helper::advertisements()->ad_sidebar; ?>

		</div>
		<?php endif; ?>

	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>