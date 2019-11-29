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
                    <span class="caption-subject bold font-blue uppercase">Mollie إعدادات بوابة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/mollie" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            <option value="EUR">يورو</option>
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('services.mollie.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('services.mollie.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- Mollie API Key -->
                    <div class="form-group {{ $errors->has('mollie_api_key') ? 'has-error' : '' }}">
                        <label class="control-label">Mollie API Key</label>
                        <input type="text" class="form-control" id="mollie_api_key" placeholder="Your mollie api key" name="mollie_api_key" value="{{ config('mollie.keys.live') }}">
                        @if ($errors->has('mollie_api_key'))
                        <span class="help-block">{{ $errors->first('mollie_api_key') }}</span>
                        @endif
                    </div>

                    <!-- Mollie Client ID -->
                    <div class="form-group {{ $errors->has('mollie_client_id') ? 'has-error' : '' }}">
                        <label class="control-label">Mollie Client ID</label>
                        <input type="text" class="form-control" id="mollie_client_id" placeholder="Your mollie client id" name="mollie_client_id" value="{{ config('services.mollie.client_id') }}">
                        @if ($errors->has('mollie_client_id'))
                        <span class="help-block">{{ $errors->first('mollie_client_id') }}</span>
                        @endif
                    </div>

                    <!-- Mollie Secret Key -->
                    <div class="form-group {{ $errors->has('mollie_secret') ? 'has-error' : '' }}">
                        <label class="control-label">Mollie مفتاح سري</label>
                        <input type="text" class="form-control" id="mollie_secret" placeholder="Your mollie account secret key" name="mollie_secret" value="{{ config('services.mollie.client_secret') }}">
                        @if ($errors->has('mollie_secret'))
                        <span class="help-block">{{ $errors->first('mollie_secret') }}</span>
                        @endif
                    </div>

                    <!-- Mollie Redirect URL -->
                    <div class="form-group {{ $errors->has('mollie_redirect') ? 'has-error' : '' }}">
                        <label class="control-label">Mollie Redirect URL</label>
                        <input type="text" class="form-control" id="mollie_redirect" name="mollie_redirect" value="{{ Protocol::home() }}/checkout/mollie/callback">
                        @if ($errors->has('mollie_redirect'))
                        <span class="help-block">{{ $errors->first('mollie_redirect') }}</span>
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