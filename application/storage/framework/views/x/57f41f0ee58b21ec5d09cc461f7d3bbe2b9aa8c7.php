<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	<div class="col-md-6" style="margin: 0 auto !important;float: none;">

		<!-- Session Messages -->
		<?php if(Session::has('error')): ?>
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('error')); ?>

	    </div>
	    <?php endif; ?>

	    <?php if(Session::has('success')): ?>
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('success')); ?>

	    </div>
	    <?php endif; ?>
		
		<form action="<?php echo e(Protocol::home()); ?>/checkout/mollie" method="POST">

			<?php echo e(csrf_field()); ?>


			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
				<h5 class="content-group">الحساب البنكي <div class="card card-blog">                    <ul class="tags">                                                                    </ul>                    <div class="card-image">                                                <div class="card-title"><li> الراجحي </li><li>503608012001162 بإسم مؤسسة موقع واثق للنشر الإلكتروني</li>                        </div></div></div><div class="card card-blog">                    <ul class="tags">                                                                    </ul>                    <div class="card-image">                                                <div class="card-title"><li> الأهلي </li><li>07164558000106 بإسم مؤسسة موقع واثق للنشر الإلكتروني</li>                        </div></div></div></h5>                      </div>                </div>                </div>			  
				</div>

	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>