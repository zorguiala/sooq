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
		        "link": true, // Button to insert a link. Default true
		        "image": true, // Button to insert an image. Default true,
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

<!-- Edit Ad -->
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
	
	<!-- Edit Ad -->
	<div class="col-md-9">
	
		<div class="panel panel-flat">

			<form class="form-horizontal form-validate-jquery" action="{{ Protocol::home() }}/account/ads/edit/{{ $ad->ad_id }}" method="POST" enctype="multipart/form-data">

				{{ csrf_field() }}

				<div class="panel panel-flat">

					<div class="panel-body">

						<fieldset>

							<!-- Ad Title -->
							<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
								<div class="col-lg-12">
									<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('create/ad.lang_title_placeholder') }}" name="title" value="{{ $ad->title }}" required="">
									@if ($errors->has('title'))
									<span class="help-block">{{ $errors->first('title') }}</span>
									@endif
								</div>
							</div>

							<!-- Ad Description -->
							<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
								<div class="col-lg-12">
									<textarea rows="10" cols="5" class="form-control wysihtml5 wysihtml5-min" placeholder="{{ Lang::get('create/ad.lang_description_placeholder') }}" name="description">{{ $ad->description }}</textarea>
								</div>
							</div>

							<!-- Ad Category -->
							<div class="form-group select-size-lg {{ $errors->has('category') ? 'has-error' : '' }}">
								<div class="col-lg-12">
									<select required="" class="select-search" data-placeholder="{{ Lang::get('create/ad.lang_select_category') }}" name="category">
		                                <option></option>
		                                @if(count(Helper::parent_categories()))
		                                @foreach (Helper::parent_categories() as $parent)
		                            	<option class="select2-results__group" value="{{ $parent->id }}" {{ $ad->category == $parent->id ? 'selected' : '' }}>-- {{ $parent->category_name }} --</option>
		                                @if (count(Helper::sub_categories($parent->id)))
		                                @foreach (Helper::sub_categories($parent->id) as $sub)
		                                <option {{ $ad->category == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
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
	                                    <option {{ $ad->country == $country->sortname ? 'selected' : '' }} value="{{ $country->sortname }}">{{ $country->name }}</option>
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
	                                    <option value="{{ $state->id }}" {{ $ad->state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
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
	                                    <option value="{{ $city->id }}" {{ $ad->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
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
									<input required="" type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update_two.lang_sale_price') }}" name="price" value="{{ $ad->price }}">
									@if ($errors->has('price'))
									<span class="help-block">{{ $errors->first('price') }}</span>
									@endif
								</div>
								
								@if ( Profile::hasStore(Auth::id()) )
								<!-- Regular Price -->
								<div class="col-lg-4">
									<input type="text" class="form-control input-xlg" placeholder="{{ Lang::get('update_two.lang_regular_price') }}" name="regular_price" value="{{ $ad->regular_price }}">
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
	                                    <option {{ $ad->currency == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->code }}</option>
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
										@if ($ad->negotiable)
										<option value="1">{{ Lang::get('create/ad.lang_negotiable') }}</option>
										<option value="0">{{ Lang::get('create/ad.lang_not_negotiable') }}</option>
										@else 
										<option value="0">{{ Lang::get('create/ad.lang_not_negotiable') }}</option>
										<option value="1">{{ Lang::get('create/ad.lang_negotiable') }}</option>
										@endif
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
										@if ($ad->is_used)
										<option value="1">{{ Lang::get('category.lang_used') }}</option>
										<option value="0">{{ Lang::get('category.lang_new') }}</option>
										@else 
										<option value="0">{{ Lang::get('category.lang_new') }}</option>
										<option value="1">{{ Lang::get('category.lang_used') }}</option>
										@endif
									</select>
									@if ($errors->has('condition'))
									<span class="help-block">{{ $errors->first('condition') }}</span>
									@endif
								</div>
							</div>

							@if (Profile::hasStore(Auth::id()))
	            			<!-- Out Of Stock -->
							<div class="form-group select-size-lg {{ $errors->has('oos') ? 'has-error' : '' }}">
								<div class="col-lg-12">
									<select required="" class="select" data-placeholder="Out of stock" name="oos">
										@if ($ad->is_oos)
										<option value="1">{{ Lang::get('update_three.lang_out_of_stock') }}</option>
										<option value="0">{{ Lang::get('update_three.lang_in_stock') }}</option>
										@else 
										<option value="0">{{ Lang::get('update_three.lang_in_stock') }}</option>
										<option value="1">{{ Lang::get('update_three.lang_out_of_stock') }}</option>
										@endif
									</select>
								</div>
								@if ($errors->has('oos'))
								<span class="help-block">{{ $errors->first('oos') }}</span>
								@endif
							</div>
							@endif

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

	                        <!-- Old Images -->
	                        <div>
	                        	<ul style="list-style: none;padding-left: 0" class="row">
	                        		@for ($j=0; $j < $ad->photos_number; $j++)
	                        		<li class="col-sm-6 col-md-3 mb-20">
	                        			<a href="{{ Protocol::home() }}/application/public/uploads/images/{{ $ad->ad_id }}/previews/preview_{{ $j }}.jpg" target="_blank">
	                        				<div data-background-image="{{ Protocol::home() }}/application/public/uploads/images/{{ $ad->ad_id }}/previews/preview_{{ $j }}.jpg" class="lozad" style="height: 90px;width: 100%;border-radius: 5px;background-position: 50%;background-size: cover;"></div>
	                        			</a>
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
			                            latitude: "{{ $ad->latitude }}",
			                            longitude: "{{ $ad->longitude }}"
			                        },
			                        radius: {{ $ad->radius }},
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
							<div class="checkbox pull-left  {{ $errors->has('terms') ? 'has-error' : '' }}" style="margin-top: -8px;">
								<label class="checkbox-inline text-grey-400">
									<input required="" type="checkbox" class="styled" name="terms">
									{{ Lang::get('create/ad.lang_i_have_confirm') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('create/ad.lang_terms_of_service') }}</a>
								</label>
								@if ($errors->has('terms'))
								<span class="help-block">{{ $errors->first('terms') }}</span>
								@endif
							</div>

							<button type="submit" class="btn btn-primary heading-btn pull-right">{{ Lang::get('update_three.lang_edit_ad') }}</button>
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

@endsection