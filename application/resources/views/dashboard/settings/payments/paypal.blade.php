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
                    <span class="caption-subject bold font-blue uppercase">إعدادات بوابة PayPal</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/paypal" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            @foreach (Currencies::paypal() as $currency => $name)
                            <option value="{{ $currency }}" {{ config('services.paypal.currency') == $currency ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('services.paypal.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('services.paypal.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- PayPal Client ID -->
                    <div class="form-group {{ $errors->has('paypal_client_id') ? 'has-error' : '' }}">
                        <label class="control-label">PayPal Client ID</label>
                        <input type="text" class="form-control" id="paypal_client_id" placeholder="Your paypal account client id" name="paypal_client_id" value="{{ config('services.paypal.client_id') }}">
                        @if ($errors->has('paypal_client_id'))
                        <span class="help-block">{{ $errors->first('paypal_client_id') }}</span>
                        @endif
                    </div>

                    <!-- PayPal Secret Key -->
                    <div class="form-group {{ $errors->has('paypal_secret') ? 'has-error' : '' }}">
                        <label class="control-label">PayPal Secret Key</label>
                        <input type="text" class="form-control" id="paypal_secret" placeholder="Your paypal account secret key" name="paypal_secret" value="{{ config('services.paypal.secret') }}">
                        @if ($errors->has('paypal_secret'))
                        <span class="help-block">{{ $errors->first('paypal_secret') }}</span>
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