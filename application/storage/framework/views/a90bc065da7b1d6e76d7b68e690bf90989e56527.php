

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	
	<!-- Page Content -->
	<div class="col-lg-10 col-lg-offset-1">

		<!-- Page Header -->
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4><?php echo e($page->page_name); ?></h4>
				<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

				<div class="heading-elements">
					<div class="heading-btn-group pages-btns">
						<a href="<?php echo e(config('pages.terms')); ?>" class="btn btn-link btn-float text-size-small has-text legitRipple"><i style="color: #333 !important;" class="icon-help text-primary"></i> <span><?php echo e(Lang::get('create/ad.lang_terms_of_service')); ?></span></a>
						<a href="<?php echo e(Protocol::home()); ?>/contact" class="btn btn-link btn-float text-size-small has-text legitRipple"><i style="color: #333 !important;" class="icon-envelop5 text-primary"></i> <span><?php echo e(Lang::get('footer.lang_contact')); ?></span></a>
					</div>
				</div>
			</div>

			<div class="breadcrumb-line"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
				<ul class="breadcrumb">
					<li><a href="<?php echo e(Protocol::home()); ?>"><?php echo e(Lang::get('header.lang_home')); ?></a></li>
					<li class="active"><?php echo e($page->page_name); ?></li>
				</ul>

			</div>
		</div>

		<!-- Page Body -->
		<div class="panel panel-flat">
			
			<div class="panel-body page_content">
				<?php echo $page->page_content; ?>

			</div>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>