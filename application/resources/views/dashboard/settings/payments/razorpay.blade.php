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
                    <span class="caption-subject bold font-blue uppercase">RazorPay اعدادات بوابة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/razorpay" method="POST" enctype="multipart/form-data">
                
                    {{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            <option value="INR">روبية هندية</option>
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                    <!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('razorpay.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('razorpay.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- RazorPay Public Key -->
                    <div class="form-group {{ $errors->has('razor_key') ? 'has-error' : '' }}">
                        <label class="control-label">RazorPay مفتاح عام</label>
                        <input type="text" class="form-control" id="razor_key" placeholder="Your razorpay public key" name="razor_key" value="{{ config('razorpay.razor_key') }}">
                        @if ($errors->has('razor_key'))
                        <span class="help-block">{{ $errors->first('razor_key') }}</span>
                        @endif
                    </div>

                    <!-- RazorPay Secret Key -->
                    <div class="form-group {{ $errors->has('razor_secret') ? 'has-error' : '' }}">
                        <label class="control-label">RazorPay سر المفتاح</label>
                        <input type="text" class="form-control" id="razor_secret" placeholder="Your razorpay secret key" name="razor_secret" value="{{ config('razorpay.razor_secret') }}">
                        @if ($errors->has('razor_secret'))
                        <span class="help-block">{{ $errors->first('razor_secret') }}</span>
                        @endif
                    </div>

                    <!-- Payment Gateway Logo -->
                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                        <label class="control-label">شعار بوابة الدفع</label>
                        <input accept="image/*" type="file" class="form-control" id="logo" name="logo">
                        @if ($errors->has('logo'))
                        <span class="help-block">{{ $errors->first('logo') }}</span>
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