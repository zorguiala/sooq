@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">

        <!-- Session Messages -->
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }} 
        </div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }} 
        </div>
        @endif
        
        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">Update "{{ $city->name }}" City</span>
                </div>
            </div>

            <div class="portlet-body">
                
                <form method="POST" action="{{ Protocol::home() }}/dashboard/geo/cities/edit/{{ $city->id }}">
                    
                    {{ csrf_field() }}

                    <div class="row">

                        <!-- City Name -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('name') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="name" placeholder="Enter city name" value="{{ $city->name }}" name="name">
                                <label for="name">اسم المدينة</label>
                                @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('country') ? 'has-error' : '' }}">
                                <select class="form-control" id="countryGetStates" name="country">
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label for="countryGetStates">Country</label>
                                @if ($errors->has('country'))
                                <span class="help-block">{{ $errors->first('country') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('state') ? 'has-error' : '' }}">
                                <select class="form-control" id="statesByCountry" name="state">
                                    <option>اختر الدولة أولا ...</option>
                                </select>
                                <label for="statesByCountry">دولة</label>
                                @if ($errors->has('state'))
                                <span class="help-block">{{ $errors->first('state') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button style="width: 100%" type="submit" class="btn default">تحديث المدينة</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection