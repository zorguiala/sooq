@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- account settings -->
<div class="row">

	<!-- Session Messages -->
	<div class="col-md-12">
		@if (Session::has('success'))
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			{{ Session::get('success') }}
	    </div>
	    @endif
	    @if (Session::has('error'))
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			{{ Session::get('error') }}
	    </div>
	    @endif
	</div>

	@include (Theme::get().'.account.include.sidebar')
	
	<!-- Account Settings -->
	<div class="col-md-9">

		<!-- User settings -->
		<div class="panel">

			<div class="panel-body">
				<form action="{{ Protocol::home() }}/account/store/settings" method="POST" enctype="multipart/form-data" class="form-validate-jquery">

					{{ csrf_field() }}

					<!-- Username && Title -->
					<div class="form-group">
						<div class="row">

							<!-- Username -->
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/store.lang_store_username') }}</label>
									<input required="" class="form-control input-sm" placeholder="{{ Lang::get('create/store.lang_store_username_placeholder') }}" type="text" value="{{ $store->username }}" name="username">
									@if ($errors->has('username'))
									<span class="help-block">
										{{ $errors->first('username') }}
									</span>
									@endif
								</div>
							</div>

							<!-- Title -->
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/store.lang_store_title') }}</label>
									<input required="" class="form-control input-sm" placeholder="{{ Lang::get('create/store.lang_store_title_placeholder') }}" type="text" value="{{ $store->title }}" name="title">
									@if ($errors->has('title'))
									<span class="help-block">
										{{ $errors->first('title') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Short Description -->
					<div class="form-group">
						<div class="row">

							<!-- Short Description -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('short_desc') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/store.lang_store_short_description') }}</label>
									<input required="" class="form-control input-sm" placeholder="{{ Lang::get('create/store.lang_store_short_description_placeholder') }}" type="text" value="{{ $store->short_desc }}" name="short_desc">
									@if ($errors->has('short_desc'))
									<span class="help-block">
										{{ $errors->first('short_desc') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Long Description -->
					<div class="form-group">
						<div class="row">

							<!-- Long Description -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('long_desc') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/store.lang_store_long_description') }}</label>
									<textarea required="" class="form-control input-sm" placeholder="{{ Lang::get('create/store.lang_store_long_description_placeholder') }}" rows="10" name="long_desc">{{ $store->long_desc }}</textarea>
									@if ($errors->has('long_desc'))
									<span class="help-block">
										{{ $errors->first('long_desc') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Category && Country -->
					<div class="form-group">
						<div class="row">

							<!-- Category -->
							<div class="{{ is_null($countries) ? 'col-md-12' : 'col-md-6' }}">
								<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/store.lang_store_category') }}</label>
									<select required="" class="select-search" data-placeholder="{{ Lang::get('create/ad.lang_select_category') }}" name="category">
		                                <option></option>
		                                @if(count(Helper::parent_categories()))
		                                @foreach (Helper::parent_categories() as $parent)
		                            	<option class="select2-results__group" value="{{ $parent->id }}" {{ $store->category == $parent->id ? 'selected' : '' }}>-- {{ $parent->category_name }} --</option>
		                                @if (count(Helper::sub_categories($parent->id)))
		                                @foreach (Helper::sub_categories($parent->id) as $sub)
		                                <option {{ $store->category == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
		                                @endforeach
		                                @endif
		                                @endforeach
		                                @endif
	                            	</select>
									@if ($errors->has('category'))
									<span class="help-block">{{ $errors->first('category') }}</span>
									@endif
								</div>
							</div>

							<!-- Country -->
							<div class="col-md-6">
								<div class="form-group form-group-material {{ $errors->has('country') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/ad.lang_country') }}</label>
									<select required="" class="select-search" name="country" onchange="getStates(this.value)">
										@foreach ($countries as $country)
	                                    <option {{ $store->country == $country->sortname ? 'selected' : '' }} value="{{ $country->sortname }}">{{ $country->name }}</option>
	                                    @endforeach
									</select>
									@if ($errors->has('country'))
									<span class="help-block">
										{{ $errors->first('country') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- State && City -->
					<div class="form-group">
						<div class="row">

							@if (Helper::settings_geo()->states_enabled)
							<!-- State -->
							<div class="{{ !Helper::settings_geo()->cities_enabled ? 'col-md-12' : 'col-md-6' }}">
								<div class="form-group form-group-material {{ $errors->has('state') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/ad.lang_state') }}</label>
									<select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_state') }}" class="select-search" name="state" onchange="getCities(this.value)" id="putStates">
	                                    @foreach ($states as $state)
	                                    <option value="{{ $state->id }}" {{ $store->state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
	                                    @endforeach
	                                </select>
	                                @if ($errors->has('state'))
									<span class="help-block">{{ $errors->first('state') }}</span>
									@endif
								</div>
							</div>
							@endif

							@if (Helper::settings_geo()->cities_enabled)
							<!-- City -->
							<div class="{{ !Helper::settings_geo()->states_enabled ? 'col-md-12' : 'col-md-6' }}">
								<div class="form-group form-group-material {{ $errors->has('city') ? 'has-error' : '' }}">
									<label>{{ Lang::get('create/ad.lang_city') }}</label>
									<select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_city') }}" class="select-search" name="city" id="putCities">
										@foreach ($cities as $city)
	                                    <option value="{{ $city->id }}" {{ $store->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
	                                    @endforeach
	                                    <option></option>
	                                </select>
	                                @if ($errors->has('city'))
									<span class="help-block">{{ $errors->first('city') }}</span>
									@endif
								</div>
							</div>
							@endif

						</div>
					</div>

					<!-- Address -->
					<div class="form-group">
						<div class="row">

							<!-- Address -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/store/settings.lang_store_address') }}</label>
									<input class="form-control input-sm" placeholder="{{ Lang::get('account/store/settings.lang_store_address_placeholder') }}" type="text" value="{{ $store->address }}" name="address">
									@if ($errors->has('address'))
									<span class="help-block">
										{{ $errors->first('address') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Facebook Page -->
					<div class="form-group">
						<div class="row">

							<!-- Facebook Page -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('fb_page') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/store/settings.lang_store_facebook') }}</label>
									<input class="form-control input-sm" placeholder="{{ Lang::get('account/store/settings.lang_store_facebook_placeholder') }}" type="text" value="{{ $store->fb_page }}" name="fb_page">
									@if ($errors->has('fb_page'))
									<span class="help-block">
										{{ $errors->first('fb_page') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Twitter Page -->
					<div class="form-group">
						<div class="row">

							<!-- Twitter Page -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('tw_page') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/store/settings.lang_store_twitter') }}</label>
									<input class="form-control input-sm" placeholder="{{ Lang::get('account/store/settings.lang_store_twitter_placeholder') }}" type="text" value="{{ $store->tw_page }}" name="tw_page">
									@if ($errors->has('tw_page'))
									<span class="help-block">
										{{ $errors->first('tw_page') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Google Page -->
					<div class="form-group">
						<div class="row">

							<!-- Google Page -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('go_page') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/store/settings.lang_store_google') }}</label>
									<input class="form-control input-sm" placeholder="{{ Lang::get('account/store/settings.lang_store_google_placeholder') }}" type="text" value="{{ $store->go_page }}" name="go_page">
									@if ($errors->has('go_page'))
									<span class="help-block">
										{{ $errors->first('go_page') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- YouTube Page -->
					<div class="form-group">
						<div class="row">

							<!-- YouTube Page -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('yt_page') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/store/settings.lang_store_youtube') }}</label>
									<input class="form-control input-sm" placeholder="{{ Lang::get('account/store/settings.lang_store_youtube_placeholder') }}" type="text" value="{{ $store->yt_page }}" name="yt_page">
									@if ($errors->has('yt_page'))
									<span class="help-block">
										{{ $errors->first('yt_page') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Store Website -->
					<div class="form-group">
						<div class="row">

							<!-- Store Website -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
									<label>Website</label>
									<input class="form-control input-sm" placeholder="Your store website" type="text" value="{{ $store->website }}" name="website">
									@if ($errors->has('website'))
									<span class="help-block">
										{{ $errors->first('website') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Live Chat -->
					<div class="form-group">
						<div class="row">

							<!-- Store Website -->
							<div class="col-md-12">
								<div class="form-group {{ $errors->has('tawk') ? 'has-error' : '' }}">
									<label>Live Chat</label>
									<input class="form-control input-sm" placeholder="Your tawk.to id" type="text" value="{{ $store->tawk }}" name="tawk">
									@if ($errors->has('tawk'))
									<span class="help-block">
										{{ $errors->first('tawk') }}
									</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<!-- Store Logo -->
					<div class="form-group">
						<div class="row">

							<!-- Upload logo -->
							<div class="col-md-6">
								<div class="form-group form-group-material {{ $errors->has('logo') ? 'has-error' : '' }}">
									<label style="width: 100%;">{{ Lang::get('create/store.lang_store_logo') }}</label>
									<input type="file" class="file-styled" name="logo" accept="image/*">
	                                @if ($errors->has('logo'))
									<span class="help-block">{{ $errors->first('logo') }}</span>
									@endif
								</div>
							</div>

							<!-- Upload Cover -->
							<div class="col-md-6">
								<div class="form-group form-group-material {{ $errors->has('cover') ? 'has-error' : '' }}">
									<label style="width: 100%;">{{ Lang::get('update.lang_store_cover') }}</label>
									<input type="file" class="file-styled" name="cover" accept="image/*">
	                                @if ($errors->has('cover'))
									<span class="help-block">{{ $errors->first('cover') }}</span>
									@endif
								</div>
							</div>

						</div>
					</div>

                    <div class="pull-right">
                    	<button type="submit" class="btn btn-primary legitRipple">{{ Lang::get('account/store/settings.lang_save_changes') }}</button>
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

@endsection