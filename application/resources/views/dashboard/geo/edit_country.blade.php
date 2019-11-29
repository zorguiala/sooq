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
                    <span class="caption-subject font-blue bold uppercase">Update "{{ $country->name }}" Country</span>
                </div>
            </div>

            <div class="portlet-body">
                
                <form method="POST" action="{{ Protocol::home() }}/dashboard/geo/countries/edit/{{ $country->id }}">
                    
                    {{ csrf_field() }}

                    <div class="row">

                        <!-- Country Name -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('name') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="name" placeholder="Enter country name" value="{{ $country->name }}" name="name">
                                <label for="name">اسم الدولة</label>
                                @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Country Sortname -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('sortname') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="sortname" placeholder="Enter country sortname" value="{{ $country->sortname }}" name="sortname">
                                <label for="sortname">اسم البلد</label>
                                @if ($errors->has('sortname'))
                                <span class="help-block">{{ $errors->first('sortname') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Phone Code -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('phonecode') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="phonecode" placeholder="Enter country phone code" value="{{ $country->phonecode }}" name="phonecode">
                                <label for="phonecode">كود الهاتف</label>
                                @if ($errors->has('phonecode'))
                                <span class="help-block">{{ $errors->first('phonecode') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button style="width: 100%" type="submit" class="btn default">تحديث البلد</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection