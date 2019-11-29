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
                    <span class="caption-subject bold font-blue uppercase">PaySafeCard اعدادات بوابة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/paysafecard" method="POST">
                
                	{{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            @foreach (Currencies::paysafecard() as $currency => $name)
                            <option value="{{ $currency }}" {{ config('paysafecard.currency') == $currency ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('paysafecard.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('paysafecard.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- PaySafeCard API Key -->
                    <div class="form-group {{ $errors->has('psc_key') ? 'has-error' : '' }}">
                        <label class="control-label">PaySafeCard API الرئيسية</label>
                        <input type="text" class="form-control" id="psc_key" placeholder="Your paysafecard api key" name="psc_key" value="{{ config('paysafecard.psc_key') }}">
                        @if ($errors->has('psc_key'))
                        <span class="help-block">{{ $errors->first('psc_key') }}</span>
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