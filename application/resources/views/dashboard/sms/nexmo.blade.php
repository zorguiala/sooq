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
                    <span class="caption-subject bold font-blue uppercase">Nexmo اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/sms/nexmo" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Nexmo Key -->
                    <div class="form-group {{ $errors->has('nexmo_key') ? 'has-error' : '' }}">
                        <label class="control-label">Nexmo مفتاح</label>
                        <input type="text" class="form-control" name="nexmo_key" value="{{ config('services.nexmo.key') }}">
                        @if ($errors->has('nexmo_key'))
                        <span class="help-block">{{ $errors->first('nexmo_key') }}</span>
                        @endif
                    </div>

                    <!-- Nexmo Secret -->
                    <div class="form-group {{ $errors->has('nexmo_secret') ? 'has-error' : '' }}">
                        <label class="control-label">Nexmo سري</label>
                        <input type="text" class="form-control" name="nexmo_secret" value="{{ config('services.nexmo.secret') }}">
                        @if ($errors->has('nexmo_secret'))
                        <span class="help-block">{{ $errors->first('nexmo_secret') }}</span>
                        @endif
                    </div>

                    <!-- Nexmo SMS From -->
                    <div class="form-group {{ $errors->has('sms_from') ? 'has-error' : '' }}">
                        <label class="control-label">Nexmo الرسائل القصيرة من</label>
                        <input type="text" class="form-control" name="sms_from" value="{{ config('services.nexmo.sms_from') }}">
                        @if ($errors->has('sms_from'))
                        <span class="help-block">{{ $errors->first('sms_from') }}</span>
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