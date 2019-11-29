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
                    <span class="caption-subject bold font-blue uppercase">PagSeguro اعدادات بوابة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/payments/pagseguro" method="POST">
                
                    {{ csrf_field() }}

                    <!-- Payment Currency -->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            <option value="BRL">ريال برازيلي</option>
                        </select>
                        @if ($errors->has('currency'))
                        <span class="help-block">{{ $errors->first('currency') }}</span>
                        @endif
                    </div>

                    <!-- Payment Mode -->
                    <div class="form-group {{ $errors->has('sandbox') ? 'has-error' : '' }}">
                        <label class="control-label">طريقة الدفع</label>
                        <select class="form-control" name="sandbox">
                            @if (config('pagseguro.sandbox'))
                            <option value="1">وضع الحماية</option>
                            <option value="0">وضع مباشر</option>
                            @else
                            <option value="0">وضع مباشر</option>
                            <option value="1">وضع الحماية</option>
                            @endif
                        </select>
                        @if ($errors->has('sandbox'))
                        <span class="help-block">{{ $errors->first('sandbox') }}</span>
                        @endif
                    </div>

                    <!-- Account upgrade price per day -->
                    <div class="form-group {{ $errors->has('account_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="{{ config('services.barion.account_price') }}"> 
                        @if ($errors->has('account_price'))
                        <span class="help-block">{{ $errors->first('account_price') }}</span>
                        @endif
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group {{ $errors->has('ad_price') ? 'has-error' : '' }}">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="{{ config('services.barion.ad_price') }}"> 
                        @if ($errors->has('ad_price'))
                        <span class="help-block">{{ $errors->first('ad_price') }}</span>
                        @endif
                    </div>

                    <!-- PagSeguro Email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label class="control-label">PagSeguro البريد الإلكتروني</label>
                        <input type="text" class="form-control" id="email" placeholder="Your PagSeguro email" name="email" value="{{ config('pagseguro.email') }}">
                        @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <!-- PagSeguro Token -->
                    <div class="form-group {{ $errors->has('token') ? 'has-error' : '' }}">
                        <label class="control-label">PagSeguro Token</label>
                        <input type="text" class="form-control" id="token" placeholder="Your PagSeguro token" name="token" value="{{ config('pagseguro.token') }}">
                        @if ($errors->has('token'))
                        <span class="help-block">{{ $errors->first('token') }}</span>
                        @endif
                    </div>

                    <!-- PagSeguro Notification URL -->
                    <div class="form-group {{ $errors->has('notificationURL') ? 'has-error' : '' }}">
                        <label class="control-label">PagSeguro Notification URL</label>
                        <input type="text" class="form-control" id="notificationURL" placeholder="Your PagSeguro notification url" name="notificationURL" value="{{ config('pagseguro.notificationURL') }}">
                        @if ($errors->has('notificationURL'))
                        <span class="help-block">{{ $errors->first('notificationURL') }}</span>
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