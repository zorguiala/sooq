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
                    <span class="caption-subject bold font-blue uppercase">Cloudinary اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/cloud/cloudinary" method="POST">
                
                	{{ csrf_field() }}

                	<!-- Cloud Name -->
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="control-label">Cloud name</label>
                        <input type="text" class="form-control" name="name" value="{{ config('cloudder.cloudName') }}"> 
                        @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <!-- API key -->
                    <div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
                        <label class="control-label">API key</label>
                        <input type="text" class="form-control" name="key" value="{{ config('cloudder.apiKey') }}"> 
                        @if ($errors->has('key'))
                        <span class="help-block">{{ $errors->first('key') }}</span>
                        @endif
                    </div>

                    <!-- API Secret -->
                    <div class="form-group {{ $errors->has('secret') ? 'has-error' : '' }}">
                        <label class="control-label">API Secret</label>
                        <input type="text" class="form-control" name="secret" value="{{ config('cloudder.apiSecret') }}"> 
                        @if ($errors->has('secret'))
                        <span class="help-block">{{ $errors->first('secret') }}</span>
                        @endif
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%;">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

@endsection