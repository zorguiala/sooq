



<?php $__env->startSection('seo'); ?>



<?php echo SEO::generate(); ?>




	<style type="text/css">

		.stores-box {

			width: 100%;

		    text-align: center;

		    padding-bottom: 30px;

		    position: relative;

	        min-height: 455px;

		}

		.stores-box .head {

			height: 122px;

		    background-size: cover;

		    border-radius: 5px 5px 0 0;

		    margin-bottom: 47px;

		    background-position: 50%;

		    background-repeat: no-repeat;

		}

		.store-logo {

			width: 80px;

			height: 80px;

			border-radius: 50%;

			background-size: cover;

			position: relative;

			top: 83px;

			margin: auto;

			border: 2px solid #fff;

		}

		.store-title{}

		.store-title a{

			font-family: Fira Sans, sans-serif;

			color: #848484;

			font-size: 19px;

			margin-bottom: 8px;

			display: block;

			padding-top: 10px;

		}

		.store-title a:focus, .store-title a:hover{

			color: #737373;

		}

		.store-address{}

		.store-address p{}

		.store-address p img{

		    height: 18px;

		    margin-top: -2px;

		}

		.store-category{margin-top: -5px}

		.store-category p{

			text-transform: uppercase;

			color: #000;

			font-family: Source Sans Pro;

			font-weight: 600;

			letter-spacing: 1px;

		}

		.store-stats{

			margin-top: 20px;

		    margin-bottom: 30px;

		}

		.store-contact li a{

			color: #FFF;

			height: 40px;

			width: 40px;

			padding: 7px;

		}

		.store-contact li a:focus, .store-contact li a:hover{

			color: #FFF;

		}

		.store-contact li .facebook-link{

			background-color: #3b5998;

		}

		.store-contact li .twitter-link{

			background-color: #00aced;

		}

		.store-contact li .google-link{

			background-color: #d34836;

		}

		.store-contact li .youtube-link{

			background-color: #dc143c;

		}

		.store-contact li .website-link{

			background-color: #505050;

		}

	</style>



<?php $__env->stopSection(); ?>



<?php $__env->startSection('pageHeader'); ?>



<!-- Open Your Own Store Now -->

<div class="create-store">



	<div class="create-intro">



		<p>

			<?php echo e(Lang::get('browse/stores.lang_easiest_way_to_create_store')); ?>


		</p>

		 <span class="create-small-intro">

			<?php echo e(Lang::get('browse/stores.lang_easiest_way_to_create_store_p')); ?>


		</span>



	</div>



	

	

	<!-- Open Store Now -->

	<a class="create-btn" href="<?php echo e(Protocol::home()); ?>/pricing"><?php echo e(Lang::get('browse/stores.lang_open_store_now')); ?></a>

	

</div>



<?php $__env->stopSection(); ?>





<?php $__env->startSection('content'); ?>



<style>



</style>



<div class="row">



	<!-- Stores -->

	<div class="col-md-12">



		<!-- Section Title -->

            			<section id="slider" class="slider-container slider-top-pagination">
            
				<div class="container">
					<h2 class="title font-additional font-weight-bold text-uppercase wow zoomIn" data-wow-delay="0.3s"><span class="customColor">
				<i class="fa fa-minus"></i> <?php echo e(Lang::get('header.lang_browse_stores')); ?> <i class="fa fa-minus"></i> </h2></span>
					<div class="starSeparatorBox clearfix">
						<div class="starSeparator wow zoomIn" data-wow-delay="0.3s">
							<span aria-hidden="true"><i class="fa fa-bullseye"></i></span>
						</div>
                        						</div>

						</div>

			</section>

		<div class="row">



			<?php if(count($stores)): ?>

			<?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



			<div class="col-md-4">



				<div class="stores-box panel">



					<!-- Store Header -->

					<div class="head lozad" data-background-image="<?php echo e(Profile::cover($store->cover)); ?>">



						<div class="store-logo lozad" data-background-image="<?php echo e($store->logo); ?>">

	          			</div>



					</div>



					<!-- Store Title -->

					<div class="store-title">

						<a href="<?php echo e(Protocol::home()); ?>/store/<?php echo e($store->username); ?>"><?php echo e($store->title); ?></a>

					</div>



					<!-- Store Address -->

					<div class="store-address">

						<p class="text-muted"><img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/flags/<?php echo e($store->country); ?>.png" alt="<?php echo e(Countries::country_name($store->country)); ?>"> <?php echo e(Countries::country_name($store->country)); ?> , <?php echo e((Helper::settings_geo()->cities_enabled) ?  Countries::city_name($store->city) : ''); ?></p>

					</div>



					<!-- Category -->

					<div class="store-category">

						<p><?php echo e(Helper::get_category($store->category)); ?></p>

					</div>



					<!-- Store Stats -->

					<div class="store-stats">

						

						<div class="panel-body panel-body-accent pb-15">

							<div class="row">



								<!-- Ads -->

								<div class="col-xs-4">

									<div class="text-uppercase text-size-mini text-muted"><?php echo e(Lang::get('store.lang_posts')); ?></div>

									<h5 class="text-semibold no-margin"><?php echo e(Helper::count_store_ads($store->owner_id)); ?></h5>

								</div>



								<!-- Views -->

								<div class="col-xs-4">

									<div class="text-uppercase text-size-mini text-muted"><?php echo e(Lang::get('store.lang_views')); ?></div>

									<h5 class="text-semibold no-margin"><?php echo e(Helper::count_store_views($store->owner_id)); ?></h5>

								</div>



								<!-- Likes -->

								<div class="col-xs-4">

									<div class="text-uppercase text-size-mini text-muted"><?php echo e(Lang::get('store.lang_likes')); ?></div>

									<h5 class="text-semibold no-margin"><?php echo e(Helper::count_store_likes($store->owner_id)); ?></h5>

								</div>



							</div>

						</div>



					</div>



					<!-- Store Social Media Links -->

					<div class="store-contact">

						

						<ul class="list-inline no-margin-bottom">



							<?php if($store->fb_page): ?>

							<!-- Facebook -->

							<li><a target="_blank" href="<?php echo e($store->fb_page); ?>" class="btn facebook-link btn-rounded btn-icon legitRipple"><i class="mdi mdi-facebook mdi-18px"></i></a></li>

							<?php endif; ?>



							<?php if($store->tw_page): ?>

							<!-- Twitter -->

							<li><a target="_blank" href="<?php echo e($store->tw_page); ?>" class="btn twitter-link btn-rounded btn-icon legitRipple"><i class="mdi mdi-twitter mdi-18px"></i></a></li>

							<?php endif; ?>



							<?php if($store->go_page): ?>

							<!-- Google -->

							<li><a target="_blank" href="<?php echo e($store->go_page); ?>" class="btn google-link btn-rounded btn-icon legitRipple"><i class="mdi mdi-google-plus mdi-18px"></i></a></li>

							<?php endif; ?>



							<?php if($store->yt_page): ?>

							<!-- Youtube -->

							<li><a target="_blank" href="<?php echo e($store->yt_page); ?>" class="btn youtube-link btn-rounded btn-icon legitRipple"><i class="mdi mdi-play mdi-18px"></i></a></li>

							<?php endif; ?>



							<?php if($store->website): ?>

							<!-- Website -->

							<li><a target="_blank" href="<?php echo e($store->website); ?>" class="btn website-link btn-rounded btn-icon legitRipple"><i class="mdi mdi-link-variant mdi-18px"></i></a></li>

							<?php endif; ?>



						</ul>



					</div>



				</div>



			</div>



			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			<?php else: ?>

			<?php endif; ?>







		</div>

		

	</div>



</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>