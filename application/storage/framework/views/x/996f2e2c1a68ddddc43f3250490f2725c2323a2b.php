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
				<form action="<?php echo e(Protocol::home()); ?>/account/settings" method="POST" enctype="multipart/form-data" class="form-validate-jquery">

					<?php echo e(csrf_field()); ?>


					<!-- First && Last Name -->
					<div class="form-group">
						<div class="row">

							<!-- First Name -->
							<div class="col-md-6">
								<div class="form-group <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/settings.lang_first_name')); ?></label>
									<input required="required" class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/settings.lang_first_name_placeholder')); ?>" type="text" value="<?php echo e($user->first_name); ?>" name="first_name">
									<?php if($errors->has('first_name')): ?>
									<span class="help-block">
										<?php echo e($errors->first('first_name')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Last Name -->
							<div class="col-md-6">
								<div class="form-group <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/settings.lang_last_name')); ?></label>
									<input required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/settings.lang_last_name_placeholder')); ?>" type="text" value="<?php echo e($user->last_name); ?>" name="last_name">
									<?php if($errors->has('last_name')): ?>
									<span class="help-block">
										<?php echo e($errors->first('last_name')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Username && Email -->
					<div class="form-group">
						<div class="row">

							<!-- Username -->
							<div class="col-md-6">
								<div class="form-group <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/settings.lang_username')); ?></label>
									<input required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/settings.lang_username_placeholder')); ?>" type="text" value="<?php echo e($user->username); ?>" name="username">
									<?php if($errors->has('username')): ?>
									<span class="help-block">
										<?php echo e($errors->first('username')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

							<!-- E-mail Address -->
							<div class="col-md-6">
								<div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/settings.lang_email_address')); ?></label>
									<input id="validateEmail" class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/settings.lang_email_address_placeholder')); ?>" type="email" value="<?php echo e($user->email); ?>" name="email">
									<?php if($errors->has('email')): ?>
									<span class="help-block">
										<?php echo e($errors->first('email')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Gender && Country -->
					<div class="form-group">
						<div class="row">

							<!-- Gender -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('gender') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/settings.lang_gender')); ?></label>
									<select required="" class="select" name="gender">
										<?php if($user->gender): ?>
										<option value="1"><?php echo e(Lang::get('account/settings.lang_gender_male')); ?></option>
										<option value="0"><?php echo e(Lang::get('account/settings.lang_gender_female')); ?></option>
										<?php else: ?>
										<option value="0"><?php echo e(Lang::get('account/settings.lang_gender_female')); ?></option>
										<option value="1"><?php echo e(Lang::get('account/settings.lang_gender_male')); ?></option>
										<?php endif; ?>
									</select>
									<?php if($errors->has('gender')): ?>
									<span class="help-block">
										<?php echo e($errors->first('gender')); ?>

									</span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Country -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('country') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('create/ad.lang_country')); ?></label>
									<select required="" class="select-search" name="country" onchange="getStates(this.value)">
										<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                    <option <?php echo e($user->country_code == $country->sortname ? 'selected' : ''); ?> value="<?php echo e($country->sortname); ?>"><?php echo e($country->name); ?></option>
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
	                                    <option value="<?php echo e($state->id); ?>" <?php echo e($user->state == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
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
	                                    <option value="<?php echo e($city->id); ?>" <?php echo e($user->city == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
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

					<!-- Phone number && Phone Hidden -->
					<div class="form-group">
						<div class="row">

							<!-- Phone number -->
							<div class="col-md-6">
								<div class="row">

									<!-- Phone Code -->
									<div class="col-md-3">
										<div class="form-group <?php echo e($errors->has('phonecode') ? 'has-error' : ''); ?>">
											<label>Phone code</label>
											<select required="" class="select-search" name="phonecode" id="putPhoneCode">
												<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phonecode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($phonecode->phonecode); ?>" <?php echo e($user->phonecode == $phonecode->phonecode ? 'selected' : ''); ?>>+<?php echo e($phonecode->phonecode); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
											<?php if($errors->has('phonecode')): ?>
											<span class="help-block">
												<?php echo e($errors->first('phonecode')); ?>

											</span>
											<?php endif; ?>
										</div>
									</div>

									<!-- Phone Number -->
									<div class="col-md-9">
										<div class="form-group <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
											<label><?php echo e(Lang::get('account/settings.lang_phone_number')); ?></label>
											<input required="" class="form-control input-sm" placeholder="<?php echo e(Lang::get('account/settings.lang_phone_number_placeholder')); ?>" type="text" value="<?php echo e($user->phone); ?>" name="phone">
											<?php if($errors->has('phone')): ?>
											<span class="help-block">
												<?php echo e($errors->first('phone')); ?>

											</span>
											<?php endif; ?>
										</div>
									</div>

								</div>
							</div>

							<!-- Phone hidden -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('phone_hidden') ? 'has-error' : ''); ?>">
									<label><?php echo e(Lang::get('account/settings.lang_hide_phone_number')); ?></label>
									<select required="" class="select" name="phone_hidden">
										<?php if($user->phone_hidden): ?>
	                                    <option value="1"><?php echo e(Lang::get('account/settings.lang_hide_phone')); ?></option>
	                                    <option value="0"><?php echo e(Lang::get('account/settings.lang_show_phone')); ?></option>
	                                    <?php else: ?> 
	                                    <option value="0"><?php echo e(Lang::get('account/settings.lang_show_phone')); ?></option>
	                                    <option value="1"><?php echo e(Lang::get('account/settings.lang_hide_phone')); ?></option>
	                                    <?php endif; ?>
	                                </select>
	                                <?php if($errors->has('phone_hidden')): ?>
									<span class="help-block"><?php echo e($errors->first('phone_hidden')); ?></span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<!-- avatar -->
					<div class="form-group">
						<div class="row">

							<div class="col-md-12">
								<div class="form-group form-group-material <?php echo e($errors->has('avatar') ? 'has-error' : ''); ?>">
									<label style="width: 100%;"><?php echo e(Lang::get('account/settings.lang_upload_avatar')); ?></label>
									<input type="file" class="file-styled" name="avatar" accept="image/*">
	                                <?php if($errors->has('avatar')): ?>
									<span class="help-block"><?php echo e($errors->first('avatar')); ?></span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

					<hr>
					
					<!-- Change Password -->
					<div class="form-group">
						<div class="row">

							<!-- Old Password -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('old_password') ? 'has-error' : ''); ?>">
									<label style="width: 100%;"><?php echo e(Lang::get('account/settings.lang_old_password')); ?></label>
									<input placeholder="<?php echo e(Lang::get('account/settings.lang_old_password_placeholder')); ?>" class="form-control" type="password" name="old_password">
	                                <?php if($errors->has('old_password')): ?>
									<span class="help-block"><?php echo e($errors->first('old_password')); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- New Password -->
							<div class="col-md-6">
								<div class="form-group form-group-material <?php echo e($errors->has('new_password') ? 'has-error' : ''); ?>">
									<label style="width: 100%;"><?php echo e(Lang::get('account/settings.lang_new_password')); ?></label>
									<input placeholder="<?php echo e(Lang::get('account/settings.lang_new_password_placeholder')); ?>" class="form-control" type="password" name="new_password">
	                                <?php if($errors->has('new_password')): ?>
									<span class="help-block"><?php echo e($errors->first('new_password')); ?></span>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>

                    <div class="pull-left mt-20">
                    	<span class="label label-flat border-grey text-grey-600"><?php echo e(Lang::get('account/settings.lang_last_login', ['date' => Helper::date_ago($user->last_login_at), 'country' => Tracker::ip($user->last_login_ip)->country()])); ?></span>
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
	                        text: '<?php echo e(__('home.lang_state')); ?>',
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
	                        text: '<?php echo e(__('home.lang_city')); ?>',
	                        value: 'all'
	                    }));
	                    $.each(response.data, function(array, object) {
	                        $('#putCities').append($('<option>', {
	                            value: object.id,
	                            text: object.name
	                        }))
	                    });

                	}

                    // Change phonecode
                    //document.getElementById('putPhoneCode').value = response.phonecode;
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