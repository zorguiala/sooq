<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- account settings -->
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
	
	<!-- Account Settings -->
	<div class="col-md-9">

		<!-- User settings -->
		<div class="panel">

			<div class="panel-body">
				<form action="<?php echo e(Protocol::home()); ?>/account/store/settings" method="POST" enctype="multipart/form-data" class="form-validate-jquery">

					<?php echo e(csrf_field()); ?>


					<!-- Username && Title -->
					<div class="form-group">
						<div class="row">

							<!-- Username -->
							<div class="col-md-6">
								<div class="form-group <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/store.lang_store_username')); ?></label>
									<input required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('create/store.lang_store_username_placeholder')); ?>" type="text" value="<?php echo e($store->username); ?>" name="username">
									<?php if($errors->has('username')): ?>
									<span class="help-block">
										<?php echo e($errors->first('username')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Title -->
							<div class="col-md-6">
								<div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/store.lang_store_title')); ?></label>
									<input required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('create/store.lang_store_title_placeholder')); ?>" type="text" value="<?php echo e($store->title); ?>" name="title">
									<?php if($errors->has('title')): ?>
									<span class="help-block">
										<?php echo e($errors->first('title')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Short Description -->
					<div class="form-group">
						<div class="row">

							<!-- Short Description -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('short_desc') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/store.lang_store_short_description')); ?></label>
									<input required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('create/store.lang_store_short_description_placeholder')); ?>" type="text" value="<?php echo e($store->short_desc); ?>" name="short_desc">
									<?php if($errors->has('short_desc')): ?>
									<span class="help-block">
										<?php echo e($errors->first('short_desc')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Long Description -->
					<div class="form-group">
						<div class="row">

							<!-- Long Description -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('long_desc') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/store.lang_store_long_description')); ?></label>
									<textarea required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('create/store.lang_store_long_description_placeholder')); ?>" rows="10" name="long_desc"><?php echo e($store->long_desc); ?></textarea>
									<?php if($errors->has('long_desc')): ?>
									<span class="help-block">
										<?php echo e($errors->first('long_desc')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Category && Country -->
					<div class="form-group">
						<div class="row">

							<!-- Category -->
							<div class="<?php echo e(is_null($countries) ? 'col-md-12' : 'col-md-6'); ?>">
								<div class="form-group <?php echo e($errors->has('category') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/store.lang_store_category')); ?></label>
									<select required="" class="select-search" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_category')); ?>" name="category">
		                                <option></option>
		                                <?php if(count(Helper::parent_categories())): ?>
		                                <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            	<option class="select2-results__group" value="<?php echo e($parent->id); ?>" <?php echo e($store->category == $parent->id ? 'selected' : ''); ?>>-- <?php echo e($parent->category_name); ?> --</option>
		                                <?php if(count(Helper::sub_categories($parent->id))): ?>
		                                <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                <option <?php echo e($store->category == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
		                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                <?php endif; ?>
		                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                <?php endif; ?>
	                            	</select>
									<?php if($errors->has('category')): ?>
									<span class="help-block"><?php echo e($errors->first('category')); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Country -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('country') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/ad.lang_country')); ?></label>
									<select required="" class="select-search" name="country" onchange="getStates(this.value)">
										<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option <?php echo e($store->country == $country->sortname ? 'selected' : ''); ?> value="<?php echo e($country->sortname); ?>"><?php echo e($country->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<?php if($errors->has('country')): ?>
									<span class="help-block">
										<?php echo e($errors->first('country')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- State && City -->
					<div class="form-group">
						<div class="row">

							<?php if(Helper::settings_geo()->states_enabled): ?>
							<!-- State -->
							<div class="<?php echo e(!Helper::settings_geo()->cities_enabled ? 'col-md-12' : 'col-md-6'); ?>">
								<div class="form-group form-group-material <?php echo e($errors->has('state') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/ad.lang_state')); ?></label>
									<select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_state')); ?>" class="select-search" name="state" onchange="getCities(this.value)" id="putStates">
	                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option value="<?php echo e($state->id); ?>" <?php echo e($store->state == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
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
							<div class="<?php echo e(!Helper::settings_geo()->states_enabled ? 'col-md-12' : 'col-md-6'); ?>">
								<div class="form-group form-group-material <?php echo e($errors->has('city') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/ad.lang_city')); ?></label>
									<select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_city')); ?>" class="select-search" name="city" id="putCities">
										<?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option value="<?php echo e($city->id); ?>" <?php echo e($store->city == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
	                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                    <option></option>
	                                </select>
	                                <?php if($errors->has('city')): ?>
									<span class="help-block"><?php echo e($errors->first('city')); ?></span>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>

						</div>
					</div>

					<!-- Address -->
					<div class="form-group">
						<div class="row">

							<!-- Address -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/store/settings.lang_store_address')); ?></label>
									<input class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/store/settings.lang_store_address_placeholder')); ?>" type="text" value="<?php echo e($store->address); ?>" name="address">
									<?php if($errors->has('address')): ?>
									<span class="help-block">
										<?php echo e($errors->first('address')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Facebook Page -->
					<div class="form-group">
						<div class="row">

							<!-- Facebook Page -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('fb_page') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/store/settings.lang_store_facebook')); ?></label>
									<input class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/store/settings.lang_store_facebook_placeholder')); ?>" type="text" value="<?php echo e($store->fb_page); ?>" name="fb_page">
									<?php if($errors->has('fb_page')): ?>
									<span class="help-block">
										<?php echo e($errors->first('fb_page')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Twitter Page -->
					<div class="form-group">
						<div class="row">

							<!-- Twitter Page -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('tw_page') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/store/settings.lang_store_twitter')); ?></label>
									<input class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/store/settings.lang_store_twitter_placeholder')); ?>" type="text" value="<?php echo e($store->tw_page); ?>" name="tw_page">
									<?php if($errors->has('tw_page')): ?>
									<span class="help-block">
										<?php echo e($errors->first('tw_page')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Google Page -->
					<div class="form-group">
						<div class="row">

							<!-- Google Page -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('go_page') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/store/settings.lang_store_google')); ?></label>
									<input class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/store/settings.lang_store_google_placeholder')); ?>" type="text" value="<?php echo e($store->go_page); ?>" name="go_page">
									<?php if($errors->has('go_page')): ?>
									<span class="help-block">
										<?php echo e($errors->first('go_page')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- YouTube Page -->
					<div class="form-group">
						<div class="row">

							<!-- YouTube Page -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('yt_page') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/store/settings.lang_store_youtube')); ?></label>
									<input class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/store/settings.lang_store_youtube_placeholder')); ?>" type="text" value="<?php echo e($store->yt_page); ?>" name="yt_page">
									<?php if($errors->has('yt_page')): ?>
									<span class="help-block">
										<?php echo e($errors->first('yt_page')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Store Website -->
					<div class="form-group">
						<div class="row">

							<!-- Store Website -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('website') ? 'has-error' : ''); ?>">
									<label>Website</label>
									<input class="form-control input-sm" placeholder="Your store website" type="text" value="<?php echo e($store->website); ?>" name="website">
									<?php if($errors->has('website')): ?>
									<span class="help-block">
										<?php echo e($errors->first('website')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Live Chat -->
					<div class="form-group">
						<div class="row">

							<!-- Store Website -->
							<div class="col-md-12">
								<div class="form-group <?php echo e($errors->has('tawk') ? 'has-error' : ''); ?>">
									<label>Live Chat</label>
									<input class="form-control input-sm" placeholder="Your tawk.to id" type="text" value="<?php echo e($store->tawk); ?>" name="tawk">
									<?php if($errors->has('tawk')): ?>
									<span class="help-block">
										<?php echo e($errors->first('tawk')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Store Logo -->
					<div class="form-group">
						<div class="row">

							<!-- Upload logo -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
									<label style="width: 100%;"><?php echo e(Lang::get('create/store.lang_store_logo')); ?></label>
									<input type="file" class="file-styled" name="logo" accept="image/*">
	                                <?php if($errors->has('logo')): ?>
									<span class="help-block"><?php echo e($errors->first('logo')); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Upload Cover -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('cover') ? 'has-error' : ''); ?>">
									<label style="width: 100%;"><?php echo e(Lang::get('update.lang_store_cover')); ?></label>
									<input type="file" class="file-styled" name="cover" accept="image/*">
	                                <?php if($errors->has('cover')): ?>
									<span class="help-block"><?php echo e($errors->first('cover')); ?></span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

                    <div class="pull-right">
                    	<button type="submit" class="btn btn-primary legitRipple"><?php echo e(Lang::get('account/store/settings.lang_save_changes')); ?></button>
                    </div>

				</form>
			</div>
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