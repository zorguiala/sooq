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
                    <span class="caption-subject bold font-blue uppercase">إعدادات MemberShip</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/membership" method="POST">
                
                    {{ csrf_field() }}

                    <!-- PayPal Gateway -->
                    <div class="form-group {{ $errors->has('is_paypal') ? 'has-error' : '' }}">
                        <label class="control-label">PayPal بوابة</label>
                        <select class="form-control" id="is_paypal" name="is_paypal">
                            @if ($settings->is_paypal)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_paypal'))
                        <span class="help-block">{{ $errors->first('is_paypal') }}</span>
                        @endif
                    </div>

                    <!-- 2checkout Gateway -->
                    <div class="form-group {{ $errors->has('is_2checkout') ? 'has-error' : '' }}">
                        <label class="control-label">2checkout Gateway</label>
                        <select class="form-control" id="is_2checkout" name="is_2checkout">
                            @if ($settings->is_2checkout)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_2checkout'))
                        <span class="help-block">{{ $errors->first('is_2checkout') }}</span>
                        @endif
                    </div>

                    <!-- Stripe Gateway -->
                    <div class="form-group {{ $errors->has('is_stripe') ? 'has-error' : '' }}">
                        <label class="control-label">Stripe بوابة</label>
                        <select class="form-control" id="is_stripe" name="is_stripe">
                            @if ($settings->is_stripe)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_stripe'))
                        <span class="help-block">{{ $errors->first('is_stripe') }}</span>
                        @endif
                    </div>

                    <!-- Mollie Gateway -->
                    <div class="form-group {{ $errors->has('is_mollie') ? 'has-error' : '' }}">
                        <label class="control-label">Mollie بوابة</label>
                        <select class="form-control" id="is_mollie" name="is_mollie">
                            @if ($settings->is_mollie)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_mollie'))
                        <span class="help-block">{{ $errors->first('is_mollie') }}</span>
                        @endif
                    </div>

                    <!-- PayStack Gateway -->
                    <div class="form-group {{ $errors->has('is_paystack') ? 'has-error' : '' }}">
                        <label class="control-label">PayStack Gateway</label>
                        <select class="form-control" id="is_paystack" name="is_paystack">
                            @if ($settings->is_paystack)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_paystack'))
                        <span class="help-block">{{ $errors->first('is_paystack') }}</span>
                        @endif
                    </div>

                    <!-- PaySafeCard Gateway -->
                    <div class="form-group {{ $errors->has('is_paysafecard') ? 'has-error' : '' }}">
                        <label class="control-label">PaySafeCard Gateway</label>
                        <select class="form-control" id="is_paysafecard" name="is_paysafecard">
                            @if ($settings->is_paysafecard)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_paysafecard'))
                        <span class="help-block">{{ $errors->first('is_paysafecard') }}</span>
                        @endif
                    </div>

                    <!-- Barion Gateway -->
                    <div class="form-group {{ $errors->has('is_barion') ? 'has-error' : '' }}">
                        <label class="control-label">Barion Gateway</label>
                        <select class="form-control" id="is_barion" name="is_barion">
                            @if ($settings->is_barion)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_barion'))
                        <span class="help-block">{{ $errors->first('is_barion') }}</span>
                        @endif
                    </div>

                    <!-- RazorPay Gateway -->
                    <div class="form-group {{ $errors->has('is_razorpay') ? 'has-error' : '' }}">
                        <label class="control-label">RazorPay Gateway</label>
                        <select class="form-control" id="is_razorpay" name="is_razorpay">
                            @if ($settings->is_razorpay)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_razorpay'))
                        <span class="help-block">{{ $errors->first('is_razorpay') }}</span>
                        @endif
                    </div>

                    <!-- PagSeguro Gateway -->
                    <div class="form-group {{ $errors->has('is_pagseguro') ? 'has-error' : '' }}">
                        <label class="control-label">PagSeguro Gateway</label>
                        <select class="form-control" id="is_pagseguro" name="is_pagseguro">
                            @if ($settings->is_pagseguro)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_pagseguro'))
                        <span class="help-block">{{ $errors->first('is_pagseguro') }}</span>
                        @endif
                    </div>

                    <!-- CashU Gateway -->
                    <div class="form-group {{ $errors->has('is_cashu') ? 'has-error' : '' }}">
                        <label class="control-label">CashU Gateway</label>
                        <select class="form-control" id="is_cashu" name="is_cashu">
                            @if ($settings->is_cashu)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_cashu'))
                        <span class="help-block">{{ $errors->first('is_cashu') }}</span>
                        @endif
                    </div>

                    <!-- Paytm Gateway -->
                    <div class="form-group {{ $errors->has('is_paytm') ? 'has-error' : '' }}">
                        <label class="control-label">Paytm Gateway</label>
                        <select class="form-control" id="is_paytm" name="is_paytm">
                            @if ($settings->is_paytm)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_paytm'))
                        <span class="help-block">{{ $errors->first('is_paytm') }}</span>
                        @endif
                    </div>

                    <!-- InterKassa Gateway -->
                    <div class="form-group {{ $errors->has('is_interkassa') ? 'has-error' : '' }}">
                        <label class="control-label">InterKassa Gateway</label>
                        <select class="form-control" id="is_interkassa" name="is_interkassa">
                            @if ($settings->is_interkassa)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_interkassa'))
                        <span class="help-block">{{ $errors->first('is_interkassa') }}</span>
                        @endif
                    </div>

                    <hr>

                    <div class="row">

                        <!-- Free Account Ads Per Day -->
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('free_ads_per_day') ? 'has-error' : '' }}">
                                <label class="control-label">إعلانات حساب مجاني في اليوم الواحد</label>
                                <input type="text" class="form-control" id="free_ads_per_day" name="free_ads_per_day" value="{{ $settings_membership->free_ads_per_day }}">
                                @if ($errors->has('free_ads_per_day'))
                                <span class="help-block">{{ $errors->first('free_ads_per_day') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Pro Account Ads Per Day -->
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('pro_ads_per_day') ? 'has-error' : '' }}">
                                <label class="control-label">إعلانات حساب Pro كل يوم</label>
                                <input type="text" class="form-control" id="pro_ads_per_day" name="pro_ads_per_day" value="{{ $settings_membership->pro_ads_per_day }}">
                                @if ($errors->has('pro_ads_per_day'))
                                <span class="help-block">{{ $errors->first('pro_ads_per_day') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Free Account max Ad Images -->
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('free_ad_images') ? 'has-error' : '' }}">
                                <label class="control-label">صور إعلانية كحد أقصى للحساب</label>
                                <input type="text" class="form-control" id="free_ad_images" name="free_ad_images" value="{{ $settings_membership->free_ad_images }}">
                                @if ($errors->has('free_ad_images'))
                                <span class="help-block">{{ $errors->first('free_ad_images') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Pro Account max Ad Images -->
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('pro_ad_images') ? 'has-error' : '' }}">
                                <label class="control-label">صور للإعلانات كحد أقصى</label>
                                <input type="text" class="form-control" id="pro_ad_images" name="pro_ad_images" value="{{ $settings_membership->pro_ad_images }}">
                                @if ($errors->has('pro_ad_images'))
                                <span class="help-block">{{ $errors->first('pro_ad_images') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Free Ad expiration days -->
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('free_ad_life') ? 'has-error' : '' }}">
                                <label class="control-label">أيام انتهاء صلاحية الإعلانات</label>
                                <input type="text" class="form-control" id="free_ad_life" name="free_ad_life" value="{{ $settings_membership->free_ad_life }}">
                                @if ($errors->has('free_ad_life'))
                                <span class="help-block">{{ $errors->first('free_ad_life') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Pro Ad expiration days -->
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('pro_ad_life') ? 'has-error' : '' }}">
                                <label class="control-label">أيام انتهاء صلاحية إعلانات</label>
                                <input type="text" class="form-control" id="pro_ad_life" name="pro_ad_life" value="{{ $settings_membership->pro_ad_life }}">
                                @if ($errors->has('pro_ad_life'))
                                <span class="help-block">{{ $errors->first('pro_ad_life') }}</span>
                                @endif
                            </div>
                        </div>

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