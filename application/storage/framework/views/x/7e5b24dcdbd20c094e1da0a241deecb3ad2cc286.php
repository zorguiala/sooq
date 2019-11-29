<?php $__env->startSection('seo'); ?>



<?php echo SEO::generate(); ?>




<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<!-- Registration form -->

<form action="<?php echo e(Protocol::home()); ?>/auth/register" method="POST" class="form-validate-jquery">



	<?php echo e(csrf_field()); ?>




	<div class="row">

		<div class="col-lg-6 col-lg-offset-3">

	

			<!-- Sessions Message -->

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



			<div class="panel registration-form">

				<div class="panel-body">

					<div class="text-center">

						<div class="icon-object border-blue text-blue"><i class="icon-plus3"></i></div>

						<h5 class="content-group-lg"><?php echo e(Lang::get('auth/register.lang_create_account')); ?> <small class="display-block"><?php echo e(Lang::get('auth/register.lang_all_fields_are_required')); ?></small></h5>

					</div>



					<div class="row">



						<!-- First Name -->

						<div class="col-md-6">

							<div class="form-group has-feedback <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">

								<input required="" type="text" class="form-control" placeholder="<?php echo e(Lang::get('account/settings.lang_first_name')); ?>" name="first_name" value="<?php echo e(old('first_name')); ?>">

								<div class="form-control-feedback">

									<i class="icon-user-check text-muted"></i>

								</div>



								<?php if($errors->has('first_name')): ?>

								<span class="help-block"><?php echo e($errors->first('first_name')); ?></span>

								<?php endif; ?>

							</div>

						</div>



						<!-- Last Name -->

						<div class="col-md-6">

							<div class="form-group has-feedback <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">

								<input required="" type="text" class="form-control" placeholder="<?php echo e(Lang::get('account/settings.lang_last_name')); ?>" name="last_name" value="<?php echo e(old('last_name')); ?>">

								<div class="form-control-feedback">

									<i class="icon-user-check text-muted"></i>

								</div>

								<?php if($errors->has('last_name')): ?>

								<span class="help-block"><?php echo e($errors->first('last_name')); ?></span>

								<?php endif; ?>

							</div>

						</div>



					</div>



					<div class="row">



						<!-- Username -->

						<div class="col-md-6">

							<div class="form-group has-feedback <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">

								<input required="" type="text" class="form-control" placeholder="<?php echo e(Lang::get('account/settings.lang_username')); ?>" name="username" value="<?php echo e(old('username')); ?>">

								<div class="form-control-feedback">

									<i class="icon-user text-muted"></i>

								</div>

								<?php if($errors->has('username')): ?>

								<span class="help-block"><?php echo e($errors->first('username')); ?></span>

								<?php endif; ?>

							</div>

						</div>

						

						<!-- Email Address -->

						<div class="col-md-6">

							<div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">

								<input required="" type="email" class="form-control" placeholder="<?php echo e(Lang::get('auth/login.lang_email_address')); ?>" name="email" value="<?php echo e(old('email')); ?>">

								<div class="form-control-feedback">

									<i class="icon-envelop text-muted"></i>

								</div>

								<?php if($errors->has('email')): ?>

								<span class="help-block"><?php echo e($errors->first('email')); ?></span>

								<?php endif; ?>

							</div>

						</div>



					</div>



					<div class="row">



						<!-- Gender -->

						<div class="col-lg-6">

							<div class="form-group form-group-material">

								<select required="" class="select" data-placeholder="<?php echo e(Lang::get('account/settings.lang_gender')); ?>" name="gender">

									<option></option>

									<option value="1"><?php echo e(Lang::get('account/settings.lang_gender_male')); ?></option>

									<option value="0"><?php echo e(Lang::get('account/settings.lang_gender_female')); ?></option>

								</select>



								<?php if($errors->has('gender')): ?>

								<span class="help-block validation-error-label"><?php echo e($errors->first('gender')); ?></span>

								<?php endif; ?>

							</div>

						</div>



						<!-- Select Country -->

						<div class="col-md-6">

							<div class="form-group form-group-material">

                                <select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_country')); ?>" class="select-search" name="country" onchange="getStates(this.value)">

                                    <option></option>

                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option <?php echo e(Helper::settings_geo()->default_country  == $country->id ? 'selected' : ''); ?> value="<?php echo e($country->sortname); ?>"><?php echo e($country->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                                <?php if($errors->has('country')): ?>

								<span class="help-block validation-error-label"><?php echo e($errors->first('country')); ?></span>

								<?php endif; ?>

                            </div>

						</div>



					</div>



					<div class="row">

						

						<?php if(Helper::settings_geo()->states_enabled): ?>

						<!-- State -->

						<div class="<?php echo e(Helper::settings_geo()->cities_enabled ? 'col-md-6' : 'col-md-12'); ?>">

							<div class="form-group form-group-material">

                                <select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_state')); ?>" class="select-search" name="state" onchange="getCities(this.value)" id="putStates">

                                	<option></option>

                                	<?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option <?php echo e(Helper::settings_geo()->default_state == $state->id ? 'selected' : ''); ?> value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                                <?php if($errors->has('state')): ?>

								<span class="help-block validation-error-label"><?php echo e($errors->first('state')); ?></span>

								<?php endif; ?>

                            </div>

						</div>

						<?php endif; ?>



						<?php if(Helper::settings_geo()->cities_enabled): ?>

						<!-- City -->

						<div class="<?php echo e(Helper::settings_geo()->states_enabled ? 'col-md-6' : 'col-md-12'); ?>">

							<div class="form-group form-group-material">

                                <select required="" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_city')); ?>" class="select-search" name="city" id="putCities">

                                    <option></option>

                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($city->id); ?>" <?php echo e(Helper::settings_geo()->default_city  == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>

                                <?php if($errors->has('city')): ?>

								<span class="help-block validation-error-label"><?php echo e($errors->first('city')); ?></span>

								<?php endif; ?>

                            </div>

						</div>

						<?php endif; ?>



					</div>	



					<div class="row">



						<!-- Phone code -->

						<div class="col-md-3">

							<div class="form-group has-feedback <?php echo e($errors->has('phonecode') ? 'has-error' : ''); ?>">

								<select required="" class="select-search" name="phonecode" id="putPhoneCode">

									<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phonecode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<option value="<?php echo e($phonecode->phonecode); ?>" <?php echo e(old('phonecode') == $phonecode->phonecode ? 'selected' : ''); ?>>+<?php echo e($phonecode->phonecode); ?></option>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								</select>

								<?php if($errors->has('phonecode')): ?>

								<span class="help-block"><?php echo e($errors->first('phonecode')); ?></span>

								<?php endif; ?>

							</div>

						</div>



						<!-- Phone Number -->

						<div class="col-md-9">

							<div class="form-group has-feedback <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">

								<input required="" type="tel" class="form-control" placeholder="<?php echo e(Lang::get('auth/register.lang_phone_number')); ?>" name="phone" value="<?php echo e(old('phone')); ?>">

								<div class="form-control-feedback">

									<i class="icon-phone text-muted"></i>

								</div>

								<?php if($errors->has('phone')): ?>

								<span class="help-block"><?php echo e($errors->first('phone')); ?></span>

								<?php endif; ?>

							</div>

						</div>



					</div>



					<div class="row">



						<!-- Password -->

						<div class="col-md-6">

							<div class="form-group has-feedback <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">

								<input required="" type="password" class="form-control" placeholder="<?php echo e(Lang::get('auth/login.lang_password')); ?>" name="password">

								<div class="form-control-feedback">

									<i class="icon-lock2 text-muted"></i>

								</div>

								<?php if($errors->has('password')): ?>

								<span class="help-block"><?php echo e($errors->first('password')); ?></span>

								<?php endif; ?>

							</div>

						</div>



						<!-- Password Confirmation -->

						<div class="col-md-6">

							<div class="form-group has-feedback <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">

								<input required="" type="password" class="form-control" placeholder="<?php echo e(Lang::get('auth/register.lang_password_confirmation')); ?>" name="password_confirmation">

								<div class="form-control-feedback">

									<i class="icon-lock2 text-muted"></i>

								</div>

								<?php if($errors->has('password_confirmation')): ?>

								<span class="help-block"><?php echo e($errors->first('password_confirmation')); ?></span>

								<?php endif; ?>

							</div>

						</div>

					</div>



					<div class="form-group">



						<label class="checkbox-inline text-grey-400">

							<input required="" type="checkbox" class="styled" name="terms">

							<?php echo e(Lang::get('create/ad.lang_i_have_confirm')); ?> <a href="<?php echo e(config('pages.terms')); ?>" target="_blank"><?php echo e(Lang::get('create/ad.lang_terms_of_service')); ?></a>

								<?php if($errors->has('terms')): ?>

								<span class="help-block validation-error-label"><?php echo e($errors->first('terms')); ?></span>

								<?php endif; ?>

						</label>



					</div>



					<?php if(Helper::settings_security()->recaptcha): ?>

						<?php echo app('captcha')->render(); ?>

					<?php endif; ?>



					<div class="text-right">

						<button style="width: 100%;background-color: #e9e7e7;" type="submit" class="btn btn-default btn-loading"> <?php echo e(Lang::get('auth/login.lang_sigh_up')); ?></button>

					</div>

				</div>

			</div>

		</div>

	</div>

</form>

<!-- /registration form -->



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

                if (response.status == 'error') {

                    alert(response.msg)

                }

            }

        })

    }



</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>