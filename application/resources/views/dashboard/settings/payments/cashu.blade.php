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
                    <span class="caption-subject bold font-blue uppercase">CashU إعدادات البوابة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/cashu" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency }}" {{ $currency == config('cashu.currency') ? 'selected' : '' }}>{{ $currency }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('cashu.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('cashu.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- Encryption Key -->
                    <div class="form-group {{ $errors->has('encryption_key') ? 'has-error' : '' }}">
                        <label class="control-label">Encryption Key</label>
                        <input type="text" class="form-control" id="encryption_key" placeholder="Your CashU encryption key" name="encryption_key" value="{{ config('cashu._encryption_key') }}">
                        @if ($errors->has('encryption_key'))
                        <span class="help-block">{{ $errors->first('encryption_key') }}</span>
                        @endif
                    </div>

                    <!-- Merchant ID -->
                    <div class="form-group {{ $errors->has('merchant_id') ? 'has-error' : '' }}">
                        <label class="control-label">Merchant ID</label>
                        <input type="text" class="form-control" id="merchant_id" placeholder="Your CashU merchant id" name="merchant_id" value="{{ config('cashu._merchant_id') }}">
                        @if ($errors->has('merchant_id'))
                        <span class="help-block">{{ $errors->first('merchant_id') }}</span>
                        @endif
                    </div>

                    <!-- Service Name -->
                    <div class="form-group {{ $errors->has('service_name') ? 'has-error' : '' }}">
                        <label class="control-label">Service Name</label>
                        <input type="text" class="form-control" id="service_name" placeholder="Your CashU service name" name="service_name" value="{{ config('cashu.service_name') }}">
                        @if ($errors->has('service_name'))
                        <span class="help-block">{{ $errors->first('service_name') }}</span>
                        @endif
                    </div>

                    <!-- Session ID -->
                    <div class="form-group {{ $errors->has('session_id') ? 'has-error' : '' }}">
                        <label class="control-label">Session ID</label>
                        <input type="text" class="form-control" id="session_id" placeholder="Any key for 6 char or above" name="session_id" value="{{ config('cashu._session_id') }}">
                        @if ($errors->has('session_id'))
                        <span class="help-block">{{ $errors->first('session_id') }}</span>
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