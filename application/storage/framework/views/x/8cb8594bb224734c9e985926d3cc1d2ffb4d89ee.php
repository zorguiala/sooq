<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
	<link href="<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/uploader.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/editors/wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/editors/wysihtml5/toolbar.js"></script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/editors/wysihtml5/parsers.js"></script>
	<script>
		$(function() {

		    // Simple toolbar
		    $('.wysihtml5-min').wysihtml5({
		        parserRules:  wysihtml5ParserRules,
		        stylesheets: ["<?php echo e(Protocol::home()); ?>/content/assets/front-end/css/components.css"],
		        "font-styles": false, // Font styling, e.g. h1, h2, etc. Default true
		        "emphasis": true, // Italics, bold, etc. Default true
		        "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers. Default true
		        "html": false, // Button which allows you to edit the generated HTML. Default false
		        "link": true, // Button to insert a link. Default true
		        "image": true, // Button to insert an image. Default true,
		        "action": false, // Undo / Redo buttons,
		        "color": true, // Button to change color of font
		    });

		});

		var validateMaxImageSize = <?php echo e(Helper::getMaxImageSize('js')); ?>;
	</script>
	<script type="text/javascript" src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/uploaders/uploader.min.js?v=1.3.6"></script>
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key=<?php echo e(config('google-maps.key')); ?>'></script>
    <script src="<?php echo e(Protocol::home()); ?>/content/assets/front-end/js/plugins/locationpicker/locationpicker.jquery.min.js"></script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Edit Ad -->
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
	
	<!-- Edit Ad -->
	<div class="col-md-9">
	
		<div class="panel panel-flat">

			<form class="form-horizontal form-validate-jquery" action="<?php echo e(Protocol::home()); ?>/account/ads/edit/<?php echo e($ad->ad_id); ?>" method="POST" enctype="multipart/form-data">

				<?php echo e(csrf_field()); ?>


				<div class="panel panel-flat">

					<div class="panel-body">

						<fieldset>

							<!-- Ad Title -->
							<div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<input type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('create/ad.lang_title_placeholder')); ?>" name="title" value="<?php echo e($ad->title); ?>" required="">
									<?php if($errors->has('title')): ?>
									<span class="help-block"><?php echo e($errors->first('title')); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Ad Description -->
							<div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<textarea rows="10" cols="5" class="form-control wysihtml5 wysihtml5-min" placeholder="<?php echo e(Lang::get('create/ad.lang_description_placeholder')); ?>" name="description"><?php echo e($ad->description); ?></textarea>
								</div>
							</div>

							<!-- Ad Category -->
							<div class="form-group select-size-lg <?php echo e($errors->has('category') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<select required="" class="select-search" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_category')); ?>" name="category">
		                                <option></option>
		                                <?php if(count(Helper::parent_categories())): ?>
		                                <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            	<option class="select2-results__group" value="<?php echo e($parent->id); ?>" <?php echo e($ad->category == $parent->id ? 'selected' : ''); ?>>-- <?php echo e($parent->category_name); ?> --</option>
		                                <?php if(count(Helper::sub_categories($parent->id))): ?>
		                                <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                <option <?php echo e($ad->category == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
		                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                <?php endif; ?>
		                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                <?php endif; ?>
	                            	</select>
								</div>
							</div>

							<!-- Country -->
							<div class="form-group select-size-lg <?php echo e($errors->has('country') ? 'has-error' : ''); ?>">
	                            <div class="col-lg-12">
	                            	<select required="" class="select-search" name="country" onchange="getStates(this.value)" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_country')); ?>">
										<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option <?php echo e($ad->country == $country->sortname ? 'selected' : ''); ?> value="<?php echo e($country->sortname); ?>"><?php echo e($country->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
		                            <?php if($errors->has('country')): ?>
									<span class="help-block"><?php echo e($errors->first('country')); ?></span>
									<?php endif; ?>
	                            </div>
	                        </div>

							<?php if(Helper::settings_geo()->states_enabled): ?>
	                        <!-- State -->
							<div class="form-group select-size-lg <?php echo e($errors->has('state') ? 'has-error' : ''); ?>">
	                            <div class="col-lg-12">
	                                <select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_state')); ?>" class="select-search" name="state" onchange="getCities(this.value)" id="putStates">
	                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option value="<?php echo e($state->id); ?>" <?php echo e($ad->state == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </select>
		                            <?php if($errors->has('state')): ?>
									<span class="help-block"><?php echo e($errors->first('state')); ?></span>
									<?php endif; ?>
	                            </div>
	                        </div>
	                        <?php endif; ?>

							<?php if(Helper::settings_geo()->cities_enabled): ?>
	                        <!-- City -->
							<div class="form-group select-size-lg <?php echo e($errors->has('city') ? 'has-error' : ''); ?>">
	                            <div class="col-lg-12">
	                            	<select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_city')); ?>" class="select-search" name="city" id="putCities">
										<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option value="<?php echo e($city->id); ?>" <?php echo e($ad->city == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                    <option></option>
	                                </select>
		                            <?php if($errors->has('city')): ?>
									<span class="help-block"><?php echo e($errors->first('city')); ?></span>
									<?php endif; ?>
	                            </div>
	                        </div>
	                        <?php endif; ?>

							<!-- Ad Regular, Sale Price & Currency -->
							<div class="form-group <?php echo e($errors->has('price') ? 'has-error' : ''); ?>">

								<!-- Sale Price -->
								<div class="<?php echo e(Profile::hasStore(Auth::id()) ? 'col-md-4' : 'col-lg-8'); ?>">
									<input required="" type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('update_two.lang_sale_price')); ?>" name="price" value="<?php echo e($ad->price); ?>">
									<?php if($errors->has('price')): ?>
									<span class="help-block"><?php echo e($errors->first('price')); ?></span>
									<?php endif; ?>
								</div>
								
								<?php if( Profile::hasStore(Auth::id()) ): ?>
								<!-- Regular Price -->
								<div class="col-lg-4">
									<input type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('update_two.lang_regular_price')); ?>" name="regular_price" value="<?php echo e($ad->regular_price); ?>">
									<?php if($errors->has('regular_price')): ?>
									<span class="help-block"><?php echo e($errors->first('regular_price')); ?></span>
									<?php endif; ?>
								</div>
								<?php endif; ?>

								<!-- Select Currency -->
								<div class="col-lg-4 select-size-lg">
									<select required="" class="select" name="currency" data-placeholder="<?php echo e(Lang::get('update.lang_select_currency')); ?>">
										<option></option>
										<?php $__currentLoopData = App\Models\Currency::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option <?php echo e($ad->currency == $currency->code ? 'selected' : ''); ?> value="<?php echo e($currency->code); ?>"><?php echo e($currency->code); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </select>
		                            <?php if($errors->has('currency')): ?>
									<span class="help-block"><?php echo e($errors->first('currency')); ?></span>
									<?php endif; ?>
								</div>

							</div>

							<!-- Is Negotiable -->
							<div class="form-group select-size-lg <?php echo e($errors->has('negotiable') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<select required="" class="select" data-placeholder="<?php echo e(Lang::get('create/ad.lang_negotiable')); ?>" name="negotiable">
										<?php if($ad->negotiable): ?>
										<option value="1"><?php echo e(Lang::get('create/ad.lang_negotiable')); ?></option>
										<option value="0"><?php echo e(Lang::get('create/ad.lang_not_negotiable')); ?></option>
										<?php else: ?> 
										<option value="0"><?php echo e(Lang::get('create/ad.lang_not_negotiable')); ?></option>
										<option value="1"><?php echo e(Lang::get('create/ad.lang_negotiable')); ?></option>
										<?php endif; ?>
									</select>
									<?php if($errors->has('negotiable')): ?>
									<span class="help-block"><?php echo e($errors->first('negotiable')); ?></span>
									<?php endif; ?>
								</div>
							</div>

	            			<!-- Condition -->
							<div class="form-group select-size-lg <?php echo e($errors->has('condition') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<select required="" class="select" data-placeholder="<?php echo e(Lang::get('create/ad.lang_item_condition')); ?>" name="condition">
										<?php if($ad->is_used): ?>
										<option value="1"><?php echo e(Lang::get('category.lang_used')); ?></option>
										<option value="0"><?php echo e(Lang::get('category.lang_new')); ?></option>
										<?php else: ?> 
										<option value="0"><?php echo e(Lang::get('category.lang_new')); ?></option>
										<option value="1"><?php echo e(Lang::get('category.lang_used')); ?></option>
										<?php endif; ?>
									</select>
									<?php if($errors->has('condition')): ?>
									<span class="help-block"><?php echo e($errors->first('condition')); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<?php if(Profile::hasStore(Auth::id())): ?>
	            			<!-- Out Of Stock -->
							<div class="form-group select-size-lg <?php echo e($errors->has('oos') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<select required="" class="select" data-placeholder="Out of stock" name="oos">
										<?php if($ad->is_oos): ?>
										<option value="1"><?php echo e(Lang::get('update_three.lang_out_of_stock')); ?></option>
										<option value="0"><?php echo e(Lang::get('update_three.lang_in_stock')); ?></option>
										<?php else: ?> 
										<option value="0"><?php echo e(Lang::get('update_three.lang_in_stock')); ?></option>
										<option value="1"><?php echo e(Lang::get('update_three.lang_out_of_stock')); ?></option>
										<?php endif; ?>
									</select>
								</div>
								<?php if($errors->has('oos')): ?>
								<span class="help-block"><?php echo e($errors->first('oos')); ?></span>
								<?php endif; ?>
							</div>
							<?php endif; ?>

							<!-- Affiliate LINK -->
							<div class="form-group <?php echo e($errors->has('affiliate_link') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<?php if( Profile::hasStore(Auth::id()) ): ?>
									<input type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('update_two.lang_affiliate_link_placeholder')); ?>" name="affiliate_link" value="<?php echo e(old('affiliate_link')); ?>">
									<?php else: ?>
									<input type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('update_two.lang_affiliate_link_placeholder')); ?>" readonly="" name="affiliate_link" value="<?php echo e(old('affiliate_link')); ?>" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update.lang_youtube_video_not_available')); ?>">
									<?php endif; ?>
									<?php if($errors->has('affiliate_link')): ?>
									<span class="help-block"><?php echo e($errors->first('affiliate_link')); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Youtube Video -->
							<div class="form-group <?php echo e($errors->has('youtube') ? 'has-error' : ''); ?>">
								<div class="col-lg-12">
									<?php if( Profile::hasStore(Auth::id()) ): ?>
									<input type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('update.lang_youtube_video_placeholder')); ?>" name="youtube" value="<?php echo e(old('youtube')); ?>">
									<?php else: ?>
									<input type="text" class="form-control input-xlg" placeholder="<?php echo e(Lang::get('update.lang_youtube_video_placeholder')); ?>" readonly="" name="youtube" value="<?php echo e(old('youtube')); ?>" data-popup="tooltip" data-placement="top" data-container="body" title="<?php echo e(Lang::get('update.lang_youtube_video_not_available')); ?>">
									<?php endif; ?>
									<?php if($errors->has('youtube')): ?>
									<span class="help-block"><?php echo e($errors->first('youtube')); ?></span>
									<?php endif; ?>
								</div>
							</div>

	            			<!-- Photos Uploader -->
	            			<div class="images-uploader-box">
	                    		<ul>
	                    			<?php if(Profile::hasStore(Auth::id())): ?>
										<?php 
											$maxImages = Helper::settings_membership()->pro_ad_images;
										?>
									<?php else: ?> 
										<?php 
											$maxImages = Helper::settings_membership()->free_ad_images;
										?>
									<?php endif; ?>
		
	                    			<?php for($i = 1; $i <= $maxImages; $i++): ?>
	                            	<li>
									    <div class="images-uploader-item">

									    		<div style="top:37%; height: 100%">
									        		<a href="#" class="images-uploader-item-addphoto">
									            		<i class="icon-plus3"></i>
									            		<input onchange="uploaderGetPreview(this)" id="uploaderImageId<?php echo e($i); ?>" class="images-uploader-input" name="photos[]" type="file" accept="image/*" style="top: -10px;right: -40px;position: absolute;cursor: pointer;opacity: 0;font-size: 100px;" />
									        		</a>
									    		</div>

									    		<div class="images-uploader-nav-panel" id="remove-icon-uploaderImageId<?php echo e($i); ?>"  onclick="uploaderRemovePreview(this)" data-input-id="uploaderImageId<?php echo e($i); ?>">
										            <i class="icon-cross2 images-uploader-remove-icon"></i>
										        </div>

									    		<div class="images-uploader-preview" id="uploaderImageId<?php echo e($i); ?>Preview"></div>
									    </div>
	                            	</li>
	                            	<?php endfor; ?>
	                            </ul>
	                        </div>

	                        <!-- Old Images -->
	                        <div>
	                        	<ul style="list-style: none;padding-left: 0" class="row">
	                        		<?php for($j=0; $j < $ad->photos_number; $j++): ?>
	                        		<li class="col-sm-6 col-md-3 mb-20">
	                        			<a href="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($ad->ad_id); ?>/previews/preview_<?php echo e($j); ?>.jpg" target="_blank">
	                        				<div data-background-image="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($ad->ad_id); ?>/previews/preview_<?php echo e($j); ?>.jpg" class="lozad" style="height: 90px;width: 100%;border-radius: 5px;background-position: 50%;background-size: cover;"></div>
	                        			</a>
	                        		</li>
	                        		<?php endfor; ?>
	                        	</ul>
	                        </div>

	                        <hr>

	                        <!-- Search a location -->
							<div class="form-group">
								<div class="col-lg-6">
									<input type="text" class="form-control input-xlg" placeholder="Enter Location" id="geoLocation-address">
								</div>

								<div class="col-lg-6">
									<input type="text" class="form-control input-xlg" placeholder="Radius" id="geoLocation-radius" name="radius">
								</div>
							</div>

	                    	<!-- Geo Location Map -->
	                    	<div id="geoLocationMap" style="width: 100%; height: 450px;"></div>

	                    	<!-- Lat & Long -->
							<div class="form-group">
								<div class="col-lg-6">
									<input type="hidden" class="form-control input-xlg" id="geoLocation-lat" name="latitude">
								</div>

								<div class="col-lg-6">
									<input type="hidden" class="form-control input-xlg" id="geoLocation-lon" name="longitude">
								</div>
							</div>

			                <script>
			                    $('#geoLocationMap').locationpicker({
			                        location: {
			                            latitude: "<?php echo e($ad->latitude); ?>",
			                            longitude: "<?php echo e($ad->longitude); ?>"
			                        },
			                        radius: <?php echo e($ad->radius); ?>,
			                        inputBinding: {
			                            latitudeInput: $('#geoLocation-lat'),
			                            longitudeInput: $('#geoLocation-lon'),
			                            radiusInput: $('#geoLocation-radius'),
			                            locationNameInput: $('#geoLocation-address')
			                        },
			                        enableAutocomplete: true
			                    });
			                </script>

						</fieldset>

					</div>

					<div class="panel-footer">
						<div class="heading-elements">
							<div class="checkbox pull-left  <?php echo e($errors->has('terms') ? 'has-error' : ''); ?>" style="margin-top: -8px;">
								<label class="checkbox-inline text-grey-400">
									<input required="" type="checkbox" class="styled" name="terms">
									<?php echo e(Lang::get('create/ad.lang_i_have_confirm')); ?> <a href="<?php echo e(config('pages.terms')); ?>" target="_blank"><?php echo e(Lang::get('create/ad.lang_terms_of_service')); ?></a>
								</label>
								<?php if($errors->has('terms')): ?>
								<span class="help-block"><?php echo e($errors->first('terms')); ?></span>
								<?php endif; ?>
							</div>

							<button type="submit" class="btn btn-primary heading-btn pull-right"><?php echo e(Lang::get('update_three.lang_edit_ad')); ?></button>
						</div>
					</div>

				</div>

			</form>
		</div>

	</div>

</div>

<script type="text/javascript">
    
    /**
    * Get States
    */
    function getStates(country) {
        var _root = $('#root').attr('data-root');
        var country_id = country;
        $.ajax({
            type: "GET",
            url: _root + '/tools/geo/states/states_by_country',
            data: {
                country_id: country_id
            },
            success: function(response) {
                if (response.status == 'success') {

                	// Check if states enabled
                	if (response.states) {

                		$('#putStates').find('option').remove();
	                    $('#putStates').append($('<option>', {
	                        text: 'Select state',
	                        value: 'all'
	                    }));
	                    $.each(response.data, function(array, object) {
	                        $('#putStates').append($('<option>', {
	                            value: object.id,
	                            text: object.name
	                        }))
	                    });

                	}else if (response.cities) {

                		// Cities
                		$('#putCities').find('option').remove();
	                    $('#putCities').append($('<option>', {
	                        text: 'Select city',
	                        value: 'all'
	                    }));
	                    $.each(response.data, function(array, object) {
	                        $('#putCities').append($('<option>', {
	                            value: object.id,
	                            text: object.name
	                        }))
	                    });

                	}
                }
                if (response.status == 'error') {
                    alert(response.msg)
                }
            }
        })
    }

    /**
    * Get Cities
    */
    function getCities(state) {
        var _root = $('#root').attr('data-root');
        var state_id = state;
        $.ajax({
            type: "GET",
            url: _root + '/tools/geo/cities/cities_by_state',
            data: {
                state_id: state_id
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#putCities').find('option').remove();
                    $('#putCities').append($('<option>', {
                        text: 'Select city',
                        value: 'all'
                    }));
                    $.each(response.data, function(array, object) {
                        $('#putCities').append($('<option>', {
                            value: object.id,
                            text: object.name
                        }))
                    });
                }
                if (response.status == 'error') {
                    alert(response.msg)
                }
            }
        })
    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>