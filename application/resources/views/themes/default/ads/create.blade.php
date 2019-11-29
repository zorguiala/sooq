@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('styles')
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/uploader.min.css" rel="stylesheet">
@endsection

@section ('javascript')

	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/editors/wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/editors/wysihtml5/toolbar.js"></script>
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/editors/wysihtml5/parsers.js"></script>
	<script>
		$(function() {

		    // Simple toolbar
		    $('.wysihtml5-min').wysihtml5({
		        parserRules:  wysihtml5ParserRules,
		        stylesheets: ["{{ Protocol::home() }}/content/assets/front-end/css/components.css"],
		        "font-styles": false, // Font styling, e.g. h1, h2, etc. Default true
		        "emphasis": true, // Italics, bold, etc. Default true
		        "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers. Default true
		        "html": false, // Button which allows you to edit the generated HTML. Default false
		        "link": false, // Button to insert a link. Default true
		        "image": false, // Button to insert an image. Default true,
		        "action": false, // Undo / Redo buttons,
		        "color": true, // Button to change color of font
		    });
		});

		var validateMaxImageSize = {{ Helper::getMaxImageSize('js') }};
	</script>
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/uploaders/uploader.min.js?v=1.3.6"></script>
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key={{ config('google-maps.key') }}'></script>
    <script src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/locationpicker/locationpicker.jquery.min.js"></script>

@endsection

@section ('content')

<!-- New Ad -->
<div class="row">

	<!-- Session Messages -->
	<div class="col-md-12">

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

	</div>

	<div class="col-md-8">

		<form class="form-horizontal form-validate-jquery" action="{{ Protocol::home() }}/create" method="POST" enctype="multipart/form-data">

			{{ csrf_field() }}

			<div class="panel panel-flat">

				<div class="panel-body">

					<div class="text-center mb-20">
						<div class="icon-object border-info text-info"><i class="icon-pencil5"></i></div>
						<h5 class="content-group text-uppercase">{{ Lang::get('update_three.lang_publish_ad_for_free') }}<small class="display-block text-uppercase">{{ Lang::get('update_three.lang_enter_ad_details') }}</small></h5>
					</div>

					<fieldset style="margin-top: 60px">

						<!-- Ad Title -->
						<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('create/ad.lang_title_placeholder') }}" name="title" value="{{ old('title') }}" required="">
								@if ($errors->has('title'))
								<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>

						<!-- Ad Description -->
						<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								<textarea rows="10" cols="5" class="form-control wysihtml5 wysihtml5-min" placeholder="{{ Lang::get('create/ad.lang_description_placeholder') }}" name="description">{{ old('description') }}</textarea>
							</div>
						</div>

						<!-- Ad Category -->
						<div class="form-group select-size-lg {{ $errors->has('category') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								<select required="" class="select-search" data-placeholder="{{ Lang::get('create/ad.lang_select_category') }}" name="category">
	                                <option></option>
	                                @if(count(Helper::parent_categories()))
	                                @foreach (Helper::parent_categories() as $parent)
	                            	<option class="select2-results__group" value="{{ $parent->id }}" {{ old('category') == $parent->id ? 'selected' : '' }}>-- {{ $parent->category_name }} --</option>
	                                @if (count(Helper::sub_categories($parent->id)))
	                                @foreach (Helper::sub_categories($parent->id) as $sub)
	                                <option {{ old('category') == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
	                                @endforeach
	                                @endif
	                                @endforeach
	                                @endif
                            	</select>
							</div>
						</div>

						<!-- Country -->
						<div class="form-group select-size-lg {{ $errors->has('country') ? 'has-error' : '' }}">
                            <div class="col-lg-12">
                            	<select required="" class="select-search" name="country" onchange="getStates(this.value)" data-placeholder="{{ Lang::get('create/ad.lang_select_country') }}">
									@foreach ($countries as $country)
                                    <option {{ $user->country_code == $country->sortname ? 'selected' : '' }} value="{{ $country->sortname }}">{{ $country->name }}</option>
                                    @endforeach
								</select>
	                            @if ($errors->has('country'))
								<span class="help-block">{{ $errors->first('country') }}</span>
								@endif
                            </div>
                        </div>

						@if (Helper::settings_geo()->states_enabled)
                        <!-- State -->
						<div class="form-group select-size-lg {{ $errors->has('state') ? 'has-error' : '' }}">
                            <div class="col-lg-12">
                                <select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_state') }}" class="select-search" name="state" onchange="getCities(this.value)" id="putStates">
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ $user->state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
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
						<div class="form-group select-size-lg {{ $errors->has('city') ? 'has-error' : '' }}">
                            <div class="col-lg-12">
                            	<select required="" data-placeholder="{{ Lang::get('create/ad.lang_select_city') }}" class="select-search" name="city" id="putCities">
									@foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ $user->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                    <option></option>
                                </select>
	                            @if ($errors->has('city'))
								<span class="help-block">{{ $errors->first('city') }}</span>
								@endif
                            </div>
                        </div>
                        @endif

						<!-- Ad Regular, Sale Price & Currency -->
						<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">

							<!-- Sale Price -->
							<div class="{{ Profile::hasStore(Auth::id()) ? 'col-md-4' : 'col-lg-8' }}">
								<input required="" type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update_two.lang_sale_price') }}" name="price" value="{{ old('price') }}">
								@if ($errors->has('price'))
								<span class="help-block">{{ $errors->first('price') }}</span>
								@endif
							</div>
							
							@if ( Profile::hasStore(Auth::id()) )
							<!-- Regular Price -->
							<div class="col-lg-4">
								<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update_two.lang_regular_price') }}" name="regular_price" value="{{ old('regular_price') }}">
								@if ($errors->has('regular_price'))
								<span class="help-block">{{ $errors->first('regular_price') }}</span>
								@endif
							</div>
							@endif

							<!-- Select Currency -->
							<div class="col-lg-4 select-size-lg">
								<select required="" class="select" name="currency" data-placeholder="{{ Lang::get('update.lang_select_currency') }}">
									<option></option>
									@foreach (App\Models\Currency::get() as $currency)
                                    <option {{ Helper::settings_geo()->default_currency == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ config('currency')[$currency->code] }}</option>
                                    @endforeach
                                </select>
	                            @if ($errors->has('currency'))
								<span class="help-block">{{ $errors->first('currency') }}</span>
								@endif
							</div>

						</div>

						<!-- Is Negotiable -->
						<div class="form-group select-size-lg {{ $errors->has('negotiable') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								<select required="" class="select" data-placeholder="{{ Lang::get('create/ad.lang_negotiable') }}" name="negotiable">
									<option></option>
									<option value="1">{{ Lang::get('create/ad.lang_negotiable') }}</option>
									<option value="0">{{ Lang::get('create/ad.lang_not_negotiable') }}</option>
								</select>
								@if ($errors->has('negotiable'))
								<span class="help-block">{{ $errors->first('negotiable') }}</span>
								@endif
							</div>
						</div>

            			<!-- Condition -->
						<div class="form-group select-size-lg {{ $errors->has('condition') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								<select required="" class="select" data-placeholder="{{ Lang::get('create/ad.lang_item_condition') }}" name="condition">
									<option></option>
									<option value="1">{{ Lang::get('category.lang_used') }}</option>
									<option value="0">{{ Lang::get('category.lang_new') }}</option>
								</select>
								@if ($errors->has('condition'))
								<span class="help-block">{{ $errors->first('condition') }}</span>
								@endif
							</div>
						</div>

						<!-- Affiliate LINK -->
						<div class="form-group {{ $errors->has('affiliate_link') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								@if ( Profile::hasStore(Auth::id()) )
								<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update_two.lang_affiliate_link_placeholder') }}" name="affiliate_link" value="{{ old('affiliate_link') }}">
								@else
								<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update_two.lang_affiliate_link_placeholder') }}" readonly="" name="affiliate_link" value="{{ old('affiliate_link') }}" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update.lang_youtube_video_not_available') }}">
								@endif
								@if ($errors->has('affiliate_link'))
								<span class="help-block">{{ $errors->first('affiliate_link') }}</span>
								@endif
							</div>
						</div>

						<!-- Youtube Video -->
						<div class="form-group {{ $errors->has('youtube') ? 'has-error' : '' }}">
							<div class="col-lg-12">
								@if ( Profile::hasStore(Auth::id()) )
								<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update.lang_youtube_video_placeholder') }}" name="youtube" value="{{ old('youtube') }}">
								@else
								<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update.lang_youtube_video_placeholder') }}" readonly="" name="youtube" value="{{ old('youtube') }}" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update.lang_youtube_video_not_available') }}">
								@endif
								@if ($errors->has('youtube'))
								<span class="help-block">{{ $errors->first('youtube') }}</span>
								@endif
							</div>
						</div>

            			<!-- Photos Uploader -->
            			<div class="images-uploader-box">
                    		<ul>
                    			@if (Profile::hasStore(Auth::id()))
									@php 
										$maxImages = Helper::settings_membership()->pro_ad_images;
									@endphp
								@else 
									@php 
										$maxImages = Helper::settings_membership()->free_ad_images;
									@endphp
								@endif
	
                    			@for ($i = 1; $i <= $maxImages; $i++)
                            	<li>
								    <div class="images-uploader-item">

								    		<div style="top:37%; height: 100%">
								        		<a href="#" class="images-uploader-item-addphoto">
								            		<i class="icon-plus3"></i>
								            		<input onchange="uploaderGetPreview(this)" id="uploaderImageId{{ $i }}" class="images-uploader-input" name="photos[]" type="file" accept="image/*" style="top: -10px;right: -40px;position: absolute;cursor: pointer;opacity: 0;font-size: 100px;" />
								        		</a>
								    		</div>

								    		<div class="images-uploader-nav-panel" id="remove-icon-uploaderImageId{{ $i }}"  onclick="uploaderRemovePreview(this)" data-input-id="uploaderImageId{{ $i }}">
									            <i class="icon-cross2 images-uploader-remove-icon"></i>
									        </div>

								    		<div class="images-uploader-preview" id="uploaderImageId{{ $i }}Preview"></div>
								    </div>
                            	</li>
                            	@endfor
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
		                            latitude: '{{ config('settings.default_latitude') }}',
                                	longitude: '{{ config('settings.default_longitude') }}'
		                        },
		                        radius: 300,
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

				<div class="panel-footer has-visible-elements">
					<div class="heading-elements visible-elements">
						<div class="checkbox pull-left  {{ $errors->has('terms') ? 'has-error' : '' }}" style="margin-top: -8px;">
							<label class="checkbox-inline text-grey-400">
								<input required="" type="checkbox" class="styled" name="terms">
								{{ Lang::get('create/ad.lang_i_have_confirm') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('create/ad.lang_terms_of_service') }}</a>
							</label>
							@if ($errors->has('terms'))
							<span class="help-block">{{ $errors->first('terms') }}</span>
							@endif
						</div>

						<button type="submit" class="btn btn-primary heading-btn pull-right">{{ Lang::get('create/ad.lang_create_ad') }}</button>
					</div>
				</div>

			</div>

		</form>

	</div>

	<div class="col-md-4">

		<div class="panel">
			<div class="panel-body text-center">
				<div class="icon-object border-blue text-blue"><i class="icon-reading"></i></div>
				<h5 class="text-semibold">{{ Lang::get('create/ad.lang_terms_of_service') }}</h5>
				<p class="mb-15">{{ Lang::get('create/store.lang_terms_of_service_p') }}</p>
				<a href="{{ config('pages.terms') }}" target="_blank" class="btn btn-primary">{{ Lang::get('create/ad.lang_terms_of_service') }}</a>
			</div>
		</div>
		
		<!-- Contact us if you have any questions -->
		<div class="panel panel-body media-rtl">
			<div class="media no-margin stack-media-on-mobile">
				<div class="media-left media-middle">
					<i class="icon-lifebuoy icon-3x text-muted no-edge-top"></i>
				</div>

				<div class="media-body">
					<h6 class="media-heading text-semibold">{{ Lang::get('create/ad.lang_got_question') }}</h6>
					<span class="text-muted">{{ Lang::get('contact.lang_contact_us_directly') }}</span>
				</div>

				<div class="media-right media-middle">
					<a href="{{ Protocol::home() }}/contact" class="btn btn-primary">{{ Lang::get('create/ad.lang_contact') }}</a>
				</div>
			</div>
		</div>

		<div class="panel panel-flat">

				<div class="panel-heading">
					<h6 class="panel-title text-uppercase"> {{ Lang::get('create/ad.lang_how_to_sell_quickly') }} </h6>
				</div>

				<div class="panel-body">
					<ul class="media-list">
						<li class="media">
							<div class="media-left">
								<a href="#" class="btn border-primary text-primary btn-flat btn-icon btn-rounded btn-sm legitRipple">
									<i class="icon-pencil4"></i>
								</a>
							</div>

							<div class="media-body" style="line-height: 40px;">
								{{ Lang::get('create/ad.lang_how_to_sell_brief_title') }} 
							</div>
						</li>

						<li class="media">
							<div class="media-left">
								<a href="#" class="btn border-danger text-danger btn-flat btn-icon btn-rounded btn-sm legitRipple">
									<i class="icon-list2"></i>
								</a>
							</div>

							<div class="media-body" style="line-height: 40px;">
								{{ Lang::get('create/ad.lang_how_to_sell_correct_category') }}
							</div>
						</li>

						<li class="media">
							<div class="media-left">
								<a href="#" class="btn border-slate text-slate btn-flat btn-icon btn-rounded btn-sm legitRipple">
									<i class="icon-image2"></i>
								</a>
							</div>

							<div class="media-body" style="line-height: 40px;">
								{{ Lang::get('create/ad.lang_how_to_sell_nice_photos') }}
							</div>
						</li>

						<li class="media">
							<div class="media-left">
								<a href="#" class="btn border-success text-success btn-flat btn-icon btn-rounded btn-sm legitRipple">
									<i class="icon-cash3"></i>
								</a>
							</div>

							<div class="media-body" style="line-height: 40px;">
								{{ Lang::get('create/ad.lang_how_to_sell_reasonable_price') }}
							</div>
						</li>

						<li class="media">
							<div class="media-left">
								<a href="#" class="btn border-blue text-blue btn-flat btn-icon btn-rounded btn-sm legitRipple">
									<i class="icon-rotate-ccw3"></i>
								</a>
							</div>

							<div class="media-body" style="line-height: 40px;">
								{{ Lang::get('create/ad.lang_how_to_sell_check_the_item') }}
							</div>
						</li>
					</ul>
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

    /**
	* Check images
    */


</script>

@endsection
