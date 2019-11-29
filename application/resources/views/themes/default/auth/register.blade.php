@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Registration form -->
<form action="{{ Protocol::home() }}/auth/register" method="POST" class="form-validate-jquery">

	{{ csrf_field() }}

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
	
			<!-- Sessions Message -->
			@if (Session::has('error'))
			<div class="alert bg-danger alert-styled-left">
				<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
				{{ Session::get('error') }}
		    </div>
		    @endif

		    @if (Session::has('success'))
			<div class="alert bg-success alert-styled-left">
				<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
				{{ Session::get('success') }}
		    </div>
		    @endif

			<div class="panel registration-form">
				<div class="panel-body">
					<div class="text-center">
						<div class="icon-object border-blue text-blue"><i class="icon-plus3"></i></div>
						<h5 class="content-group-lg">{{ Lang::get('auth/register.lang_create_account') }} <small class="display-block">{{ Lang::get('auth/register.lang_all_fields_are_required') }}</small></h5>
					</div>

					<div class="row">

						<!-- First Name -->
						<div class="col-md-6">
							<div class="form-group has-feedback {{ $errors->has('first_name') ? 'has-error' : '' }}">
								<input required="" type="text" class="form-control" placeholder="{{ Lang::get('account/settings.lang_first_name') }}" name="first_name" value="{{ old('first_name') }}">
								<div class="form-control-feedback">
									<i class="icon-user-check text-muted"></i>
								</div>

								@if ($errors->has('first_name'))
								<span class="help-block">{{ $errors->first('first_name') }}</span>
								@endif
							</div>
						</div>

						<!-- Last Name -->
						<div class="col-md-6">
							<div class="form-group has-feedback {{ $errors->has('last_name') ? 'has-error' : '' }}">
								<input required="" type="text" class="form-control" placeholder="{{ Lang::get('account/settings.lang_last_name') }}" name="last_name" value="{{ old('last_name') }}">
								<div class="form-control-feedback">
									<i class="icon-user-check text-muted"></i>
								</div>
								@if ($errors->has('last_name'))
								<span class="help-block">{{ $errors->first('last_name') }}</span>
								@endif
							</div>
						</div>

					</div>

					<div class="row">

						<!-- Username -->
						<div class="col-md-6">
							<div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
								<input required="" type="text" class="form-control" placeholder="{{ Lang::get('account/settings.lang_username') }}" name="username" value="{{ old('username') }}">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								@if ($errors->has('username'))
								<span class="help-block">{{ $errors->first('username') }}</span>
								@endif
							</div>
						</div>
						
						<!-- Email Address -->
						<div class="col-md-6">
							<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
								<input required="" type="email" class="form-control" placeholder="{{ Lang::get('auth/login.lang_email_address') }}" name="email" value="{{ old('email') }}">
								<div class="form-control-feedback">
									<i class="icon-envelop text-muted"></i>
								</div>
								@if ($errors->has('email'))
								<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>
						</div>

					</div>

					<div class="row">

						<!-- Gender -->
						<div class="col-lg-6">
							<div class="form-group form-group-material">
								<select required="" class="select" data-placeholder="{{ Lang::get('account/settings.lang_gender') }}" name="gender">
									<option></option>
									<option value="1">{{ Lang::get('account/settings.lang_gender_male') }}</option>
									<option value="0">{{ Lang::get('account/settings.lang_gender_female') }}</option>
								</select>

								@if ($errors->has('gender'))
								<span class="help-block validation-error-label">{{ $errors->first('gender') }}</span>
								@endif
							</div>
						</div>

						<!-- Select Country -->
						<div class="col-md-6">
							<div class="form-group form-group-material">
                                <select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_country') }}" class="select-search" name="country" onchange="getStates(this.value)">
                                    <option></option>
                                    @foreach ($countries as $country)
                                    <option {{ $detectedCountry == $country->sortname ? 'selected' : '' }} value="{{ $country->sortname }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
								<span class="help-block validation-error-label">{{ $errors->first('country') }}</span>
								@endif
                            </div>
						</div>

					</div>

					<div class="row">
						
						@if (Helper::settings_geo()->states_enabled)
						<!-- State -->
						<div class="{{ Helper::settings_geo()->cities_enabled ? 'col-md-6' : 'col-md-12' }}">
							<div class="form-group form-group-material">
                                <select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_state') }}" class="select-search" name="state" onchange="getCities(this.value)" id="putStates">
                                	<option></option>
                                	@foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('state'))
								<span class="help-block validation-error-label">{{ $errors->first('state') }}</span>
								@endif
                            </div>
						</div>
						@endif

						@if (Helper::settings_geo()->cities_enabled)
						<!-- City -->
						<div class="{{ Helper::settings_geo()->states_enabled ? 'col-md-6' : 'col-md-12' }}">
							<div class="form-group form-group-material">
                                <select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_city') }}" class="select-search" name="city" id="putCities">
                                    <option></option>
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('city'))
								<span class="help-block validation-error-label">{{ $errors->first('city') }}</span>
								@endif
                            </div>
						</div>
						@endif

					</div>	

					<div class="row">

						<!-- Phone code -->
						<div class="col-md-3">
							<div class="form-group has-feedback {{ $errors->has('phonecode') ? 'has-error' : '' }}">
								<select required="" class="select-search" name="phonecode" id="putPhoneCode">
									@foreach ($countries as $phonecode)
									<option value="{{ $phonecode->phonecode }}" {{ old('phonecode') == $phonecode->phonecode ? 'selected' : '' }}>+{{ $phonecode->phonecode }}</option>
									@endforeach
								</select>
								@if ($errors->has('phonecode'))
								<span class="help-block">{{ $errors->first('phonecode') }}</span>
								@endif
							</div>
						</div>

						<!-- Phone Number -->
						<div class="col-md-9">
							<div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
								<input required="" type="tel" class="form-control" placeholder="{{ Lang::get('auth/register.lang_phone_number') }}" name="phone" value="{{ old('phone') }}">
								<div class="form-control-feedback">
									<i class="icon-phone text-muted"></i>
								</div>
								@if ($errors->has('phone'))
								<span class="help-block">{{ $errors->first('phone') }}</span>
								@endif
							</div>
						</div>

					</div>

					<div class="row">

						<!-- Password -->
						<div class="col-md-6">
							<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
								<input required="" type="password" class="form-control" placeholder="{{ Lang::get('auth/login.lang_password') }}" name="password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								@if ($errors->has('password'))
								<span class="help-block">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>

						<!-- Password Confirmation -->
						<div class="col-md-6">
							<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
								<input required="" type="password" class="form-control" placeholder="{{ Lang::get('auth/register.lang_password_confirmation') }}" name="password_confirmation">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								@if ($errors->has('password_confirmation'))
								<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
								@endif
							</div>
						</div>
					</div>

					<div class="form-group">

						<label class="checkbox-inline text-grey-400">
							<input required="" type="checkbox" class="styled" name="terms">
							{{ Lang::get('create/ad.lang_i_have_confirm') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('create/ad.lang_terms_of_service') }}</a>
								@if ($errors->has('terms'))
								<span class="help-block validation-error-label">{{ $errors->first('terms') }}</span>
								@endif
						</label>

					</div>

					@if (Helper::settings_security()->recaptcha)
						@captcha
					@endif

					<div class="text-right">
						<button style="width: 100%;background-color: #e9e7e7;" type="submit" class="btn btn-default btn-loading"> {{ Lang::get('auth/login.lang_sigh_up') }}</button>
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
	                        text: '{{ __('home.lang_state') }}',
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
                        text: '{{ __('home.lang_city') }}',
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

@endsection