

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">

	<!-- Blog -->
    <div class="spec ">
        <h3><?php echo e(Lang::get('update_two.lang_blog')); ?></h3>
        <div class="ser-t">
            <b></b>
            <span><i></i></span>
            <b class="line"></b>
        </div>
    </div>

	<!-- Articles -->
	<?php if(count($articles)): ?>
	<?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

	<div class="col-md-4">

		<figure class="snip1529">
  			<div class="blog-img lozad" data-background-image="<?php echo e(Protocol::home()); ?>/application/public/uploads/articles/<?php echo e($article->cover); ?>">
  			</div>
  			<figcaption class="blog-title">
    			<h3><?php echo e($article->title); ?></h3>
  			</figcaption>
  			<div class="hover"><i class="icon-plus3"></i></div>
  			<a href="<?php echo e(Protocol::home()); ?>/blog/<?php echo e($article->slug); ?>"></a>
		</figure>

	</div>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
	<?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>