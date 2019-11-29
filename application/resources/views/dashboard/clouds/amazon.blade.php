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
                    <span class="caption-subject bold font-blue uppercase">Amazon S3 Settings</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/cloud/amazon" method="POST">
                
                	{{ csrf_field() }}

                	<!-- Bucket Name -->
                    <div class="form-group {{ $errors->has('bucket') ? 'has-error' : '' }}">
                        <label class="control-label">Bucket name</label>
                        <input type="text" class="form-control" name="bucket" value="{{ config('filesystems.disks.s3.bucket') }}"> 
                        @if ($errors->has('bucket'))
                        <span class="help-block">{{ $errors->first('bucket') }}</span>
                        @endif
                    </div>

                    <!-- API key -->
                    <div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
                        <label class="control-label">API key</label>
                        <input type="text" class="form-control" name="key" value="{{ config('filesystems.disks.s3.key') }}"> 
                        @if ($errors->has('key'))
                        <span class="help-block">{{ $errors->first('key') }}</span>
                        @endif
                    </div>

                    <!-- API Secret -->
                    <div class="form-group {{ $errors->has('secret') ? 'has-error' : '' }}">
                        <label class="control-label">API Secret</label>
                        <input type="text" class="form-control" name="secret" value="{{ config('filesystems.disks.s3.secret') }}"> 
                        @if ($errors->has('secret'))
                        <span class="help-block">{{ $errors->first('secret') }}</span>
                        @endif
                    </div>

                    <!-- Region -->
                    <div class="form-group {{ $errors->has('region') ? 'has-error' : '' }}">
                        <label class="control-label">منطقة</label>
                        <select class="form-control" name="region">
                            @foreach ($regions as $name => $region)
                            <option {{ $region == config('filesystems.disks.s3.region') ? 'selected' : '' }} value="{{ $region }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('region'))
                        <span class="help-block">{{ $errors->first('region') }}</span>
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