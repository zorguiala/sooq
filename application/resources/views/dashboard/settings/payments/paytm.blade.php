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
                    <span class="caption-subject bold font-blue uppercase">إعدادات بوابة Paytm</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/paytm" method="POST">
                
                    {{ csrf_field() }}

                    <!-- Payment Mode -->
                    <div class="form-group {{ $errors->has('env') ? 'has-error' : '' }}">
                        <label class="control-label">بيئة</label>
                        <select class="form-control" name="env">
                            @if (config('services.paytm-wallet.env') == 'local')
                            <option value="local">Local</option>
                            <option value="production">إنتاج</option>
                            @else
                            <option value="production">إنتاج</option>
                            <option value="local">محلي</option>
                            @endif
                        </select>
                        @if ($errors->has('env'))
                        <span class="help-block">{{ $errors->first('env') }}</span>
                        @endif
                    </div>

                    <!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('services.paytm-wallet.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('services.paytm-wallet.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- Merchant Id -->
                    <div class="form-group {{ $errors->has('merchant_id') ? 'has-error' : '' }}">
                        <label class="control-label">معرف التاجر</label>
                        <input type="text" class="form-control" id="merchant_id" placeholder="Your Paytm merchant id" name="merchant_id" value="{{ config('services.paytm-wallet.merchant_id') }}">
                        @if ($errors->has('merchant_id'))
                        <span class="help-block">{{ $errors->first('merchant_id') }}</span>
                        @endif
                    </div>

                    <!-- Merchant Key -->
                    <div class="form-group {{ $errors->has('merchant_key') ? 'has-error' : '' }}">
                        <label class="control-label">Merchant مفتاح</label>
                        <input type="text" class="form-control" id="merchant_key" placeholder="Your Paytm merchant key" name="merchant_key" value="{{ config('services.paytm-wallet.merchant_key') }}">
                        @if ($errors->has('merchant_key'))
                        <span class="help-block">{{ $errors->first('merchant_key') }}</span>
                        @endif
                    </div>

                    <!-- Merchant Website -->
                    <div class="form-group {{ $errors->has('merchant_website') ? 'has-error' : '' }}">
                        <label class="control-label">Merchant موقع ويب</label>
                        <input type="text" class="form-control" id="merchant_website" placeholder="Your Paytm merchant website" name="merchant_website" value="{{ config('services.paytm-wallet.merchant_website') }}">
                        @if ($errors->has('merchant_website'))
                        <span class="help-block">{{ $errors->first('merchant_website') }}</span>
                        @endif
                    </div>

                    <!-- Channel -->
                    <div class="form-group {{ $errors->has('channel') ? 'has-error' : '' }}">
                        <label class="control-label">قناة</label>
                        <input type="text" class="form-control" id="channel" placeholder="Your Paytm channel" name="channel" value="{{ config('services.paytm-wallet.channel') }}">
                        @if ($errors->has('channel'))
                        <span class="help-block">{{ $errors->first('channel') }}</span>
                        @endif
                    </div>

                    <!-- Industry Type -->
                    <div class="form-group {{ $errors->has('industry_type') ? 'has-error' : '' }}">
                        <label class="control-label">نوع الصناعة</label>
                        <input type="text" class="form-control" id="industry_type" placeholder="Your Paytm industry type" name="industry_type" value="{{ config('services.paytm-wallet.industry_type') }}">
                        @if ($errors->has('industry_type'))
                        <span class="help-block">{{ $errors->first('industry_type') }}</span>
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