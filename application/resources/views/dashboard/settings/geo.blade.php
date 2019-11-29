@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">

        <!-- Session Messages -->
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }} 
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }} 
        </div>
        @endif
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">App Geo اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/geo" method="POST">

                    {{ csrf_field() }}

                    <!-- International -->
                    <div class="form-group {{ $errors->has('is_international') ? 'has-error' : '' }}">
                        <label class="control-label">دولي</label>
                        <select class="form-control" id="is_international" name="is_international">
                        @if ($settings->is_international)
                        <option value="1">دولي</option>
                        <option value="0">الوطني</option>
                        @else
                        <option value="0">الوطني</option>
                        <option value="1">دولي</option>
                        @endif
                    </select>
                        @if ($errors->has('is_international'))
                        <span class="help-block">{{ $errors->first('is_international') }}</span>
                        @endif
                    </div>

                    <!-- Default Country -->
                    <div class="form-group {{ $errors->has('default_country') ? 'has-error' : '' }}">
                        <label class="control-label">البلد الافتراضي</label>
                        <select class="form-control" name="default_country" id="country" onchange="getStates(this.value)">
                        @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ $settings->default_country == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                        @if ($errors->has('default_country'))
                        <span class="help-block">{{ $errors->first('default_country') }}</span>
                        @endif
                    </div>

                    <!-- Default State -->
                    <div class="form-group {{ $errors->has('default_state') ? 'has-error' : '' }}">
                        <label class="control-label">الدولة الافتراضية</label>
                        <select class="form-control" name="default_state" id="putStates" onchange="getCities(this.value)">
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ $settings->default_state == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                        @if ($errors->has('default_state'))
                        <span class="help-block">{{ $errors->first('default_state') }}</span>
                        @endif
                    </div>

                    <!-- Default City -->
                    <div class="form-group {{ $errors->has('default_city') ? 'has-error' : '' }}">
                        <label class="control-label">المدينة الافتراضية</label>
                        <select class="form-control" id="putCities" name="default_city">
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $settings->default_city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                        @if ($errors->has('default_city'))
                        <span class="help-block">{{ $errors->first('default_city') }}</span>
                        @endif
                    </div>

                    <!-- Enable States -->
                    <div class="form-group {{ $errors->has('states_enabled') ? 'has-error' : '' }}">
                        <label class="control-label">تمكين الدول</label>
                        <select class="form-control" name="states_enabled">
                        @if ($settings->states_enabled)
                        <option value="1">تمكين</option>
                        <option value="0">تعطيل</option>
                        @else
                        <option value="0">تعطيل</option>
                        <option value="1">تمكين</option>
                        @endif
                    </select>
                        @if ($errors->has('states_enabled'))
                        <span class="help-block">{{ $errors->first('states_enabled') }}</span>
                        @endif
                    </div>

                    <!-- Enable Cities -->
                    <div class="form-group {{ $errors->has('cities_enabled') ? 'has-error' : '' }}">
                        <label class="control-label">Enable Cities</label>
                        <select class="form-control" name="cities_enabled">
                        @if ($settings->cities_enabled)
                        <option value="1">تمكين</option>
                        <option value="0">تعطيل</option>
                        @else
                        <option value="0">تعطيل</option>
                        <option value="1">تمكين</option>
                        @endif
                    </select>
                        @if ($errors->has('cities_enabled'))
                        <span class="help-block">{{ $errors->first('cities_enabled') }}</span>
                        @endif
                    </div>

                    <!-- Default Currency -->
                    <div class="form-group {{ $errors->has('default_currency') ? 'has-error' : '' }}">
                        <label class="control-label">Default Currency</label>
                        <select class="form-control" name="default_currency">
                            @foreach ($currencies as $key => $value)
                            <option value="{{ $key }}" {{ $settings->default_currency == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('default_currency'))
                        <span class="help-block">{{ $errors->first('default_currency') }}</span>
                        @endif
                    </div>

                    <!-- Default Locale -->
                    <div class="form-group {{ $errors->has('default_locale') ? 'has-error' : '' }}">
                        <label class="control-label">اللغة الافتراضية</label>
                        <select class="form-control" name="default_locale">
                            @foreach ($locales as $key => $value)
                            <option value="{{ $key }}" {{ $settings->default_locale == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('default_locale'))
                        <span class="help-block">{{ $errors->first('default_locale') }}</span>
                        @endif
                    </div>

                    <!-- Trim Trailing Zeros -->
                    <div class="form-group {{ $errors->has('trim_trailing_zeros') ? 'has-error' : '' }}">
                        <label class="control-label">Trim Trailing Zeros (1900.00$ to 1900$)</label>
                        <select class="form-control" name="trim_trailing_zeros">
                            @if (config('settings.trim_trailing_zeros'))
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('trim_trailing_zeros'))
                        <span class="help-block">{{ $errors->first('trim_trailing_zeros') }}</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Google maps api key -->
                    <div class="form-group {{ $errors->has('google_maps_key') ? 'has-error' : '' }}">
                        <label class="control-label">Google maps api key (<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Get API Key</a>)</label>
                        <input class="form-control" name="google_maps_key" value="{{ config('google-maps.key') }}" placeholder="Your google maps api key">
                        @if ($errors->has('google_maps_key'))
                        <span class="help-block">{{ $errors->first('google_maps_key') }}</span>
                        @endif
                    </div>

                    <!-- Default Geo-location Address -->
                    <div class="form-group">
                        <label class="control-label">Default Geo-location Address</label>
                        <input class="form-control" placeholder="Enter default google maps address" id="geoLocation-address">
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
                                locationNameInput: $('#geoLocation-address')
                            },
                            enableAutocomplete: true
                        });
                    </script>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%">حفظ التغييرات </button>
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