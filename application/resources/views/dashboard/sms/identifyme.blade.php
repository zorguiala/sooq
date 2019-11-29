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
                    <span class="caption-subject bold font-blue uppercase">IdentifyMe الإعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/sms/identifyme" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Client ID -->
                    <div class="form-group {{ $errors->has('client_id') ? 'has-error' : '' }}">
                        <label class="control-label">عميل ID</label>
                        <input type="text" class="form-control" name="client_id" value="{{ config('identifyme.clientId') }}">
                        @if ($errors->has('client_id'))
                        <span class="help-block">{{ $errors->first('client_id') }}</span>
                        @endif
                    </div>

                    <!-- Client Secret -->
                    <div class="form-group {{ $errors->has('client_secret') ? 'has-error' : '' }}">
                        <label class="control-label">عميل Secret</label>
                        <input type="text" class="form-control" name="client_secret" value="{{ config('identifyme.clientSecret') }}">
                        @if ($errors->has('client_secret'))
                        <span class="help-block">{{ $errors->first('client_secret') }}</span>
                        @endif
                    </div>

                    <!-- IdentifyMe Callback -->
                    <div class="form-group {{ $errors->has('callback') ? 'has-error' : '' }}">
                        <label class="control-label">IdentifyMe Callback</label>
                        <input type="text" class="form-control" readonly="" name="callback" value="{{ Protocol::home() }}/auth/phone/callback">
                        @if ($errors->has('callback'))
                        <span class="help-block">{{ $errors->first('callback') }}</span>
                        @endif
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

@endsection