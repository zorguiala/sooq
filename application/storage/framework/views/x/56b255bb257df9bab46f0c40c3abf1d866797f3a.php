

<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Search Results -->
<div class="row">

	<!-- Results -->
	<div class="col-lg-9">
		<div class="panel panel-body pb-10">
			<p class="text-muted text-size-small results-found"><?php echo e(Lang::get('search.lang_about_x_results', ['results' => $totalResults, 'seconds' => number_format($execution_time, 4)])); ?></p>

			<div class="heading-elements" style="margin-top: 10px;">
				<ul class="list-inline list-inline-separate heading-text">

					<!-- Random Ad -->
					<li><a class="text-muted text-uppercase" href="<?php echo e(Protocol::home()); ?>/random"> <?php echo e(Lang::get('search.lang_random')); ?></a></li>

                    <!-- Create alert -->
                    <li><a class="text-uppercase" href="javascript;" style="color: #fd4848;border-radius: 10px;border: 1px solid #fd4848;padding: 3px 10px;font-size: 11px;vertical-align: middle;" data-toggle="modal" data-target="#create_alert"><i style="font-size: 15px;vertical-align: middle;" class="mdi mdi-bell"></i> <?php echo e(Lang::get('update_three.lang_create_alert')); ?></a></li>

				</ul>
        	</div>
            
		</div>

        <!-- Create Alert -->
        <div id="create_alert" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title text-uppercase"><?php echo e(Lang::get('update_three.lang_create_alert')); ?></h5>
                    </div>

                    <form action="<?php echo e(Protocol::home()); ?>/search/alert" method="POST" id="createSearchAlert">

                        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" id="createSearchAlertToken">

                        <div class="modal-body">

                            <!-- Keyword -->
                            <div class="form-group">
                                <input type="text" placeholder="<?php echo e(Lang::get('update_three.lang_keyword_to_alert')); ?>" class="form-control" name="alertKeyword" id="alertKeyword">
                            </div>

                            <!-- E-mail Address -->
                            <div class="form-group">
                                <input type="text" placeholder="<?php echo e(Lang::get('account/settings.lang_email_address_placeholder')); ?>" class="form-control" name="alertEmail" id="alertEmail">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><?php echo e(Lang::get('update_three.lang_create_alert')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ads -->
        <div class="row">
            <?php if(count($results)): ?>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

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
                            <div class="img card-ad-cover lozad" data-background-image="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>"></div>
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
                                <div class="card__avatar"><a href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="<?php echo e(Profile::picture($ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>" class="avatar lozad" width="40" height="40"><?php if(Profile::hasStore($ad->user_id)): ?><i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="Verified Account"></i><?php endif; ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?> 
            <div class="col-md-12">
                <div class="alert bg-info alert-styled-left">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    <?php echo app('translator')->getFromJson('return/info.lang_nothing_to_show'); ?>
                </div>
            </div>      
            <?php endif; ?>
        </div>
        

        <div class="text-center pb-10 pt-10">
            <?php if($results): ?>
            <?php echo e($results->appends([
                'q'        => $q,
                'country'  => $country,
                'state'    => $state,
                'city'     => $city,
                'category' => $category,
                'min'      => $min,
                'max'      => $max,
            ])->links()); ?>

            <?php endif; ?>
        </div>

	</div>

	<!-- Filter Results -->
	<div class="col-lg-3">

    	<div class="panel panel-white">
			<div class="panel-heading" style="border-bottom: 1px solid #f2f2f2;">
				<div class="panel-title text-uppercase text-muted" style="margin: -1px 0px -6px 0px;color: #7e7d7d;">
					<i class="icon-filter3 text-size-base position-left"></i>
					<?php echo e(Lang::get('search.lang_fiter_search')); ?>

				</div>
			</div>

			<div class="panel-body">
				<form action="<?php echo e(Protocol::home()); ?>/search" method="GET">

					<!-- Keyword -->
					<div class="form-group">
						<div class="has-feedback has-feedback-left">
							<input type="search" class="form-control" placeholder="<?php echo e(Lang::get('search.lang_looking_for')); ?>" value="<?php echo e($q); ?>" name="q">
							<div class="form-control-feedback">
								<i class="icon-search4 text-size-large text-muted"></i>
							</div>
						</div>
					</div>

                    <!-- Category -->
                    <div class="form-group">
                        <select class="select" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_category')); ?>" name="category">
                            <option></option>
                            <?php if(count(Helper::parent_categories())): ?>
                            <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option class="select2-results__group" value="<?php echo e($parent->id); ?>">-- <?php echo e($parent->category_name); ?> --</option>
                            <?php if(count(Helper::sub_categories($parent->id))): ?>
                            <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e(old('category') == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div class="form-group">
                        <select class="select" name="sort">
                            <option value="newest"><?php echo e(Lang::get('home.lang_newest')); ?></option>
                            <option value="oldest"><?php echo e(Lang::get('home.lang_oldest')); ?></option>
                            <option value="featured"><?php echo e(Lang::get('home.lang_featured')); ?></option>
                            <option value="views"><?php echo e(Lang::get('home.lang_views')); ?></option>
                            <option value="rating"><?php echo e(Lang::get('home.lang_rating')); ?></option>
                        </select>
                    </div>

                    <!-- Min Price -->
                    <div class="form-group">
                        <input type="text" name="min" class="form-control" placeholder="<?php echo e(Lang::get('home.lang_min_price')); ?>" value="<?php echo e($min); ?>">
                    </div>

                    <!-- Max Price -->
                    <div class="form-group">
                        <input type="text" name="max" class="form-control" placeholder="<?php echo e(Lang::get('home.lang_max_price')); ?>" value="<?php echo e($max); ?>">
                    </div>

					<button type="submit" class="btn bg-blue btn-block" style="background-color: #FF3333">
						<?php echo e(Lang::get('search.lang_fiter_search')); ?>

					</button>
				</form>
			</div>
		</div>

        <?php if(Helper::ifCanSeeAds()): ?>
		<!-- Advertisment -->
		<div class="advertisment" style="margin-bottom: 20px;">
			<?php echo Helper::advertisements()->search_sidebar; ?>

		</div>
        <?php endif; ?>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>