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
                    <span class="caption-subject bold font-blue uppercase">إعدادات بوابة InterKassa</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/interkassa" method="POST">
                
                    {{ csrf_field() }}

                    <!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('interkassa.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('interkassa.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- Shop Id -->
                    <div class="form-group {{ $errors->has('shop_id') ? 'has-error' : '' }}">
                        <label class="control-label">محل Id</label>
                        <input type="text" class="form-control" id="shop_id" placeholder="Your InterKassa shop id" name="shop_id" value="{{ config('interkassa.shop_id') }}">
                        @if ($errors->has('shop_id'))
                        <span class="help-block">{{ $errors->first('shop_id') }}</span>
                        @endif
                    </div>

                    <!-- Secret Key -->
                    <div class="form-group {{ $errors->has('secret_key') ? 'has-error' : '' }}">
                        <label class="control-label">مفتاح سري</label>
                        <input type="text" class="form-control" id="secret_key" placeholder="Your InterKassa secret key" name="secret_key" value="{{ config('interkassa.secret_key') }}">
                        @if ($errors->has('secret_key'))
                        <span class="help-block">{{ $errors->first('secret_key') }}</span>
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