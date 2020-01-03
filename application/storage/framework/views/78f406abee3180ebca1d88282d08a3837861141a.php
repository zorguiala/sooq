<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/quickview.css" rel="stylesheet"type="text/css" />

<div class="container">
	<div id="product-category" class="container layer-category">
		<div class="show-sidebar hidden-lg hidden-md">
			<i class="fa fa-filter"></i>
			<i class="ion-android-close"></i>
		</div>
		<div class="row">
			<aside id="column-left" class="col-sm-3 col-xs-12" style="display: none;">
				<div class="col-order-inner">
					<div class="list-group list-categories" DIR="RLT">
						<h3 style="text-align: center;">Categories</h3>
						<div class="list-categories-content">
							<a href="index.html" class="list-group-item"> Games &amp; Consoles <span>12</span></a>
							<a href="index.html" class="list-group-item">Appliances <span>0</span></a>
							<a href="index.html" class="list-group-item">Baby &amp; Kids <span>5</span></a>
							<a href="index.html" class="list-group-item">Bakeware <span>0</span></a>
							<a href="index.html" class="list-group-item">Cameras &amp; Camcoders <span>12</span></a>
							<a href="index.html" class="list-group-item">Computers &amp; Laptops <span>26</span></a>
							<a href="index.html" class="list-group-item">Cookies &amp; Crackers <span>6</span></a>
							<a href="index.html" class="list-group-item">Fashion &amp; Clothing <span>25</span></a>
							<a href="index.html" class="list-group-item">Headphone &amp; Speaker <span>0</span></a>
							<a href="index.html" class="list-group-item">Interior &amp; Furniture <span>49</span></a>
							<a href="index.html" class="list-group-item">Mobile &amp; Tablets <span>12</span></a>
							<a href="shop.html" class="list-group-item active">Shop <span>49</span></a>
							<a href="shop/cell-phones.html" class="list-group-item child">Cell Phones
								<span>0</span></a>
							<a href="index.html" class="list-group-item child">GPS &amp; Navigation <span>0</span></a>
							<a href="index.html" class="list-group-item child">Home Audio &amp; Theater
								<span>0</span></a>
							<a href="index.html" class="list-group-item child">Smart Home <span>0</span></a>
							<a href="index.html" class="list-group-item">Smartwatch <span>9</span></a>
							<a href="index.html" class="list-group-item">Tools &amp; Accessories <span>5</span></a>
							<a href="index.html" class="list-group-item">TV &amp; Audio <span>0</span></a>
							<a href="index.html" class="list-group-item">Bakery <span>0</span></a>
							<a href="index.html" class="list-group-item">Beauty &amp; Health <span>49</span></a>
							<a href="index.html" class="list-group-item">Accessories <span>39</span></a>
							<a href="index.html" class="list-group-item">Breakfast <span>0</span></a>
						</div>
					</div>
					<div class="popular-tags">
						<div class="title">
							<h3>Popular Tags</h3>
						</div>
						<ul>
							<li>
								<a href="index.html">Amazon</a>
								<a href="index.html">Apple</a>
								<a href="index.html">IPhone</a>
								<a href="index.html">Headphone</a>
								<a href="index.html">Beats</a>
								<a href="index.html">Bluetooth</a>
								<a href="index.html">Speaker</a>
								<a href="index.html">Bose</a>
							</li>
						</ul>
					</div>
				</div>
			</aside>
			<div id="content" class="col-sm-9">
				<div class="category-image"><img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/images/Retail.png"
						style="    width: 100%;	height: 250px;" alt="Shop" title="Shop"
						class="img-thumbnail" /></div>
				<div class="custom-category">
					<div class="tool-bar">
						<div class="row">
							<div class="col-md-3 col-xs-12">
								<div class="btn-group btn-group-sm">
									<button type="button"
										onclick="category_view.changeView('grid', 4, 'btn-grid-4')"
										class="btn btn-default btn-custom-view btn-grid-4" data-toggle="tooltip"
										data-placement="top" title="4"></button>
									<button type="button" onclick="category_view.changeView('list', 0, 'btn-list')"
										class="btn btn-default btn-custom-view btn-list" data-toggle="tooltip"
										data-placement="top" title="List"></button>
									<input type="hidden" id="category-view-type" value="grid" />
									<input type="hidden" id="category-grid-cols" value="4" />
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group input-group input-group-sm">
		
									<select id="input-sort" class="form-control"
										onchange="ptfilter.filter(this.value);">
										<option value="" selected="selected">تنظيم</option>
										<option value="">
											متميزة</option>
										<option value="">
											تاريخ</option>
										<option value="">
											(السعر (منخفض > مرتفع</option>
										<option value="">
											(السعر (مرتفع > منخفض</option>
									</select>
									<label class="input-group-addon" for="input-sort">:تنظيم حسب</label>
								</div>
							</div>
							<div class="col-md-3 col-xs-12">
								<div class="form-group input-group input-group-sm">
		
									<select id="input-limit" class="form-control"
										onchange="ptfilter.filter(this.value);">
										<option value="" selected="selected">16</option>
										<option value="">
											25</option>
									</select>
									<label class="input-group-addon" for="input-limit">:تبين</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
							<?php if(count($ads)): ?>
							<?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div dir="rtl" class="product-layout product-list col-xs-12 product-items">
							<div class="product-thumb">
								<div class="product-item">
									<div class="image swatches-image-container">
										<div class="inner">
												<?php if($ad->is_featured): ?>
												<a class="ui teal right ribbon label">إعلان متميز</a>
												<?php endif; ?>
												
											<a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>">
														<?php if($ad->photos != null): ?>
														<img src="<?php echo e(EverestCloud::getThumnail($ad->ad_id, $ad->images_host)); ?>" title="<?php echo e($ad->title); ?>" class="img-responsive img-cate-160" />
														<?php else: ?>
														<img src="<?php echo e(Route::currentRouteName() == 'home' ? Protocol::home().'/img/1.jpg' : Protocol::home().'/img/1.jpg'); ?>" title="<?php echo e($ad->title); ?>" class="img-responsive img-cate-160" />
														<?php endif; ?>
		
											</a>
											
											<div class="button-group">
												<div class="inner">
													<div class="right floated meta"> <?php echo e($ad->timeleft); ?> <i
															class="clock outline icon"></i></div>
												</div>
											</div>
										</div>
									</div>
									<div class="caption">
										<div class="inner">
		
		
												<a href="<?php echo e(Protocol::home()); ?>/listing/<?php echo e($ad->slug); ?>"><p class="product-description" style="
													
														
														direction: rtl;
														overflow: hidden;
														text-overflow: ellipsis;
														max-width: 200px;
														font-size: 14px;">
														<?php echo e($ad->title); ?></p></a>
		
											<p class="price"> <span class="price-new"><img src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/icons/svg/coins.svg"
														width="20" alt=""><?php echo e(Helper::getPriceFormat($ad->price, $ad->currency)); ?></span> </p>
													
										</div>
									</div>
									<div class="box-list">
										<div class="inner">
											<a href="<?php echo e(Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#'); ?>">
											<img class="ui medium circular image"
												style="border: 2px solid green;float: left; width: 50px"
												src="<?php echo e(Profile::picture($ad->user_id)); ?>" alt="<?php echo e(Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id)); ?>">
		
											<div style="margin-top: 13px; margin-left: 62px;"><?php echo e($ad->user_name{0}->first_name); ?> <?php echo e($ad->user_name{0}->last_name); ?></div>
										</a>
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
			</div>
		
	
</div>
		<script>
			$(document).ready(function () {
				$('.show-sidebar').click(function () {
					if ($(this).hasClass('opened')) {
						$(this).removeClass('opened');
					} else {
						$(this).addClass('opened');
					}
					$('.layer-category #column-left,.layer-category #column-right').toggle();
				});
			});
		</script>
	</div>

		
	

		



	<!-- Left Side -->
	<div class="col-md-3">
		
	</div>

</div>
<script>
    var sites = <?php echo json_encode($ads); ?>;
    console.log(sites);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>