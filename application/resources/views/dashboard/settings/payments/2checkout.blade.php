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
                    <span class="caption-subject bold font-blue uppercase">إعدادات بوابة 2Checkout</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/2checkout" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            @foreach (Currencies::TwoCheckout() as $currency => $name)
                            <option value="{{ $currency }}" {{ config('services.2checkout.currency') == $currency ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('services.2checkout.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('services.2checkout.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- 2Checkout Seller ID -->
                    <div class="form-group {{ $errors->has('2checkout_seller_id') ? 'has-error' : '' }}">
                        <label class="control-label">2Checkout ID البائع
</label>
                        <input type="text" class="form-control" id="2checkout_seller_id" placeholder="Your 2Checkout account seller id" name="2checkout_seller_id" value="{{ config('services.2checkout.seller_id') }}">
                        @if ($errors->has('2checkout_seller_id'))
                        <span class="help-block">{{ $errors->first('2checkout_seller_id') }}</span>
                        @endif
                    </div>

                    <!-- 2Checkout Publishable Key -->
                    <div class="form-group {{ $errors->has('2checkout_publishable_Key') ? 'has-error' : '' }}">
                        <label class="control-label">2Checkout Publishable Key</label>
                        <input type="text" class="form-control" id="2checkout_publishable_Key" placeholder="Your 2Checkout account publishable key" name="2checkout_publishable_Key" value="{{ config('services.2checkout.publishable_Key') }}">
                        @if ($errors->has('2checkout_publishable_Key'))
                        <span class="help-block">{{ $errors->first('2checkout_publishable_Key') }}</span>
                        @endif
                    </div>

                    <!-- 2Checkout Private Key -->
                    <div class="form-group {{ $errors->has('2checkout_private_Key') ? 'has-error' : '' }}">
                        <label class="control-label">2Checkout Private Key</label>
                        <input type="text" class="form-control" id="2checkout_private_Key" placeholder="Your 2Checkout account private key" name="2checkout_private_Key" value="{{ config('services.2checkout.private_key') }}">
                        @if ($errors->has('2checkout_private_Key'))
                        <span class="help-block">{{ $errors->first('2checkout_private_Key') }}</span>
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