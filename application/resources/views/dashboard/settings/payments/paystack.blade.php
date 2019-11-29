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
                    <span class="caption-subject bold font-blue uppercase">إعدادات بوابة PayStack</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/paystack" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            <option value="NGN">Nigerian Naira</option>
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('paystack.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('paystack.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- Paystack API Key -->
                    <div class="form-group {{ $errors->has('publicKey') ? 'has-error' : '' }}">
                        <label class="control-label">Paystack المفتاح العام</label>
                        <input type="text" class="form-control" id="publicKey" placeholder="Your PayStack api public key" name="publicKey" value="{{ config('paystack.publicKey') }}">
                        @if ($errors->has('publicKey'))
                        <span class="help-block">{{ $errors->first('publicKey') }}</span>
                        @endif
                    </div>

                    <!-- PayStack Secret Key -->
                    <div class="form-group {{ $errors->has('secretKey') ? 'has-error' : '' }}">
                        <label class="control-label">PayStack سر مفتاح</label>
                        <input type="text" class="form-control" id="secretKey" placeholder="Your PayStack secret key" name="secretKey" value="{{ config('paystack.secretKey') }}">
                        @if ($errors->has('secretKey'))
                        <span class="help-block">{{ $errors->first('secretKey') }}</span>
                        @endif
                    </div>

                    <!-- PayStack Merchant Email -->
                    <div class="form-group {{ $errors->has('merchantEmail') ? 'has-error' : '' }}">
                        <label class="control-label">PayStack تاجر البريد الإلكتروني</label>
                        <input type="text" class="form-control" id="merchantEmail" placeholder="Your PayStack merchant email" name="merchantEmail" value="{{ config('paystack.merchantEmail') }}">
                        @if ($errors->has('merchantEmail'))
                        <span class="help-block">{{ $errors->first('merchantEmail') }}</span>
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