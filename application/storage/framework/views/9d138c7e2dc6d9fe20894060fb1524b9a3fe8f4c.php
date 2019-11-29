

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
	
	<!-- Ads -->
	<div class="col-md-9">

		<!-- Filter -->
		<div class="row">
			<div class="col-md-12">
				<div class="navbar navbar-default navbar-xs navbar-component">
					<ul class="nav navbar-nav no-border visible-xs-block">
						<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
					</ul>

					<div class="navbar-collapse collapse" id="navbar-filter">
						<p class="navbar-text"><?php echo e(Lang::get('category.lang_filter')); ?></p>
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort-time-asc position-left"></i> <?php echo e(Lang::get('category.lang_by_date')); ?> <span class="caret"></span></a>
								<ul class="dropdown-menu" style="margin-top: -32px;">
									<li><a href="<?php echo e(Protocol::home()); ?>/browse"><?php echo e(Lang::get('category.lang_show_all')); ?></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?date=today"><?php echo e(Lang::get('category.lang_today')); ?></a></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?date=yesterday"><?php echo e(Lang::get('category.lang_yesterday')); ?></a></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?date=week"><?php echo e(Lang::get('category.lang_week')); ?></a></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?date=month"><?php echo e(Lang::get('category.lang_month')); ?></a></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?date=year"><?php echo e(Lang::get('category.lang_year')); ?></a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort-amount-desc position-left"></i> <?php echo e(Lang::get('category.lang_by_status')); ?> <span class="caret"></span></a>
								<ul class="dropdown-menu" style="margin-top: -32px;">
									<li><a href="<?php echo e(Protocol::home()); ?>/browse"><?php echo e(Lang::get('category.lang_show_all')); ?></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?status=featured"><?php echo e(Lang::get('category.lang_featured')); ?></a></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?status=normal"><?php echo e(Lang::get('category.lang_not_featured')); ?></a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort position-left"></i> <?php echo e(Lang::get('category.lang_by_condition')); ?> <span class="caret"></span></a>
								<ul class="dropdown-menu" style="margin-top: -32px;">
									<li><a href="<?php echo e(Protocol::home()); ?>/browse"><?php echo e(Lang::get('category.lang_show_all')); ?></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?condition=used"><?php echo e(Lang::get('category.lang_used')); ?></a></li>
									<li><a href="<?php echo e(Protocol::home()); ?>/browse?condition=new"><?php echo e(Lang::get('category.lang_new')); ?></a></li>
								</ul>
							</li>
						</ul>

						<div class="navbar-right text-right">
							<a href="<?php echo e(Protocol::home()); ?>/random" class="text-muted text-uppercase" style="line-height: 47px;"><?php echo e(Lang::get('search.lang_random')); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Browse Ads -->
		<div class="row">

            <?php if(count($ads)): ?>
            <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-4">

                <div class="card card-blog">
                    <ul class="tags">
                        <?php if($ad->is_featured): ?>
                        <li><?php echo e(Lang::get('home.lang_featured')); ?></li>
                        <?php endif; ?>

                        <?php if($ad->is_oos): ?>
                        <li class="oos"><?php echo e(Lang::get('update_three.lang_out_of_stock')); ?></li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-image">
                        <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>" <?php echo e(!is_null($ad->affiliate_link) ? 'target="_blank"' : ''); ?>>
                        <?php if($ad->photos != null): ?>
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>"></div>
                            <?php else: ?>
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(Route::currentRouteName() == 'home' ? Protocol::home().'/img/1.jpg' : Protocol::home().'/img/1.jpg'); ?>" title="<?php echo e($ad->title); ?>"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"><?php echo e($ad->title); ?></a>
                        </h5>
                        <div class="card-footer">
                            <div id="price">
                                <?php if(!is_null($ad->regular_price)): ?>
                                <span class="price price-old"> <?php echo e(Helper::getPriceFormat($ad->regular_price, $ad->currency)); ?></span>
                                <?php endif; ?>
                                <span class="price price-new"> <?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?></span>
                            </div>
                            <div class="author">
                                <div class="card__avatar"><a href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="<?php echo e(Profile::picture($ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>" class="avatar lozad" width="40" height="40"><?php if(Profile::hasStore($ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update_two.lang_verified_account')); ?>"></i><?php endif; ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 text-center mb-20">
            	<?php echo e($ads->links()); ?>

            </div>
            <?php else: ?> 
            <div class="col-md-12">
	            <div class="alert bg-info alert-styled-left">
					<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
					<?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>
			    </div>
		    </div>
            <?php endif; ?>

        </div>

	</div>

	<!-- Left Side -->
	<div class="col-md-3">
		
		<!-- Advertisement -->
		<div class="advertisment">
			<?php echo Helper::advertisements()->ad_sidebar; ?>

		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>