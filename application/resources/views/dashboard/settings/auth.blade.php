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
                    <span class="caption-subject bold font-blue uppercase">إعدادات المصادقة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/auth" method="POST">
                
                	{{ csrf_field() }}

                    <!-- After Register -->
                    <div class="form-group {{ $errors->has('need_activation') ? 'has-error' : '' }}">
                        <label class="control-label">بعد التسجيل</label>
                        <select class="form-control" name="need_activation">
                            @if ($settings->need_activation)
                            <option value="1">تحتاج التنشيط</option>
                            <option value="0">تسجيل السيارات</option>
                            @else 
                            <option value="0">تسجيل السيارات</option>
                            <option value="1">تحتاج التنشيط</option>
                            @endif
                        </select>
                        @if ($errors->has('need_activation'))
                        <span class="help-block">{{ $errors->first('need_activation') }}</span>
                        @endif
                    </div>

                    <!-- Activation Type -->
                    <div class="form-group {{ $errors->has('activation_type') ? 'has-error' : '' }}">
                        <label class="control-label">نوع التنشيط</label>
                        <select class="form-control" name="activation_type">
                            @if ($settings->activation_type == 'admin')
                            <option value="admin">من لوحة المعلومات</option>
                            <option value="email">عبر البريد الالكتروني</option>
                            <option value="sms">عبر الرسائل القصيرة</option>
                            @elseif ($settings->activation_type == 'email')
                            <option value="email">عبر البريد الالكتروني</option>
                            <option value="sms">عبر الرسائل القصيرة</option>
                            <option value="admin">من لوحة المعلومات</option>
                            @else 
                            <option value="sms">عبر الرسائل القصيرة</option>
                            <option value="email">عبر البريد الالكتروني</option>
                            <option value="admin">من لوحة المعلومات</option>
                            @endif
                        </select>
                        @if ($errors->has('activation_type'))
                        <span class="help-block">{{ $errors->first('activation_type') }}</span>
                        @endif
                    </div>

                	<!-- Activation Expired Time (minutes) -->
                    <div class="form-group {{ $errors->has('activation_expired_time') ? 'has-error' : '' }}">
                        <label class="control-label">وقت الإنتهاء منتهي الصلاحية (بالدقائق)</label>
                        <input type="text" class="form-control" name="activation_expired_time" value="{{ $settings->activation_expired_time }}"> 
                        @if ($errors->has('activation_expired_time'))
                        <span class="help-block">{{ $errors->first('activation_expired_time') }}</span>
                        @endif
                    </div>

                    <!-- Prevent Posting After X warnings -->
                    <div class="form-group {{ $errors->has('max_warnings') ? 'has-error' : '' }}">
                        <label class="control-label">منع النشر بعد التحذيرات X</label>
                        <input type="text" class="form-control" name="max_warnings" value="{{ $settings->max_warnings }}"> 
                        @if ($errors->has('max_warnings'))
                        <span class="help-block">{{ $errors->first('max_warnings') }}</span>
                        @endif
                    </div>

                    <hr>

                    <!-- Facebook -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Facebook Client ID -->
                            <div class="form-group {{ $errors->has('fb_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">Facebook Client ID</label>
                                <input type="text" class="form-control" name="fb_client_id" value="{{ config('services.facebook.client_id') }}"> 
                                @if ($errors->has('fb_client_id'))
                                <span class="help-block">{{ $errors->first('fb_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Facebook Client Secret -->
                            <div class="form-group {{ $errors->has('fb_secret') ? 'has-error' : '' }}">
                                <label class="control-label">Facebook Client Secret</label>
                                <input type="text" class="form-control" name="fb_secret" value="{{ config('services.facebook.client_secret') }}"> 
                                @if ($errors->has('fb_secret'))
                                <span class="help-block">{{ $errors->first('fb_secret') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    
                    <hr>
                    
                    <!-- Twitter -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Twitter Client ID -->
                            <div class="form-group {{ $errors->has('tw_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">Twitter Client ID</label>
                                <input type="text" class="form-control" name="tw_client_id" value="{{ config('services.twitter.client_id') }}"> 
                                @if ($errors->has('tw_client_id'))
                                <span class="help-block">{{ $errors->first('tw_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Twitter Client Secret -->
                            <div class="form-group {{ $errors->has('tw_secret') ? 'has-error' : '' }}">
                                <label class="control-label">Twitter Client Secret</label>
                                <input type="text" class="form-control" name="tw_secret" value="{{ config('services.twitter.client_secret') }}"> 
                                @if ($errors->has('tw_secret'))
                                <span class="help-block">{{ $errors->first('tw_secret') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    
                    <hr>

                    <!-- Google -->
                    <div class="row">
                        
                        <div class="col-md-6">
                            <!-- Google Client ID -->
                            <div class="form-group {{ $errors->has('go_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">Google Client ID</label>
                                <input type="text" class="form-control" name="go_client_id" value="{{ config('services.google.client_id') }}"> 
                                @if ($errors->has('go_client_id'))
                                <span class="help-block">{{ $errors->first('go_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Google Client Secret -->
                            <div class="form-group {{ $errors->has('go_client_secret') ? 'has-error' : '' }}">
                                <label class="control-label">Google Client Secret</label>
                                <input type="text" class="form-control" name="go_client_secret" value="{{ config('services.google.client_secret') }}"> 
                                @if ($errors->has('go_client_secret'))
                                <span class="help-block">{{ $errors->first('go_client_secret') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Instagram -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Instagram Client ID -->
                            <div class="form-group {{ $errors->has('in_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">Instagram Client ID</label>
                                <input type="text" class="form-control" name="in_client_id" value="{{ config('services.instagram.client_id') }}"> 
                                @if ($errors->has('in_client_id'))
                                <span class="help-block">{{ $errors->first('in_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Instagram Client Secret -->
                            <div class="form-group {{ $errors->has('in_client_secret') ? 'has-error' : '' }}">
                                <label class="control-label">Instagram Client Secret</label>
                                <input type="text" class="form-control" name="in_client_secret" value="{{ config('services.instagram.client_secret') }}"> 
                                @if ($errors->has('in_client_secret'))
                                <span class="help-block">{{ $errors->first('in_client_secret') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Pinterest -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Pinterest Client ID -->
                            <div class="form-group {{ $errors->has('pi_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">Pinterest Client ID</label>
                                <input type="text" class="form-control" name="pi_client_id" value="{{ config('services.pinterest.client_id') }}"> 
                                @if ($errors->has('pi_client_id'))
                                <span class="help-block">{{ $errors->first('pi_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Pinterest Client Secret -->
                            <div class="form-group {{ $errors->has('pi_client_secret') ? 'has-error' : '' }}">
                                <label class="control-label">Pinterest Client Secret</label>
                                <input type="text" class="form-control" name="pi_client_secret" value="{{ config('services.pinterest.client_secret') }}"> 
                                @if ($errors->has('pi_client_secret'))
                                <span class="help-block">{{ $errors->first('pi_client_secret') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Linkedin -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Linkedin Client ID -->
                            <div class="form-group {{ $errors->has('li_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">Linkedin Client ID</label>
                                <input type="text" class="form-control" name="li_client_id" value="{{ config('services.linkedin.client_id') }}"> 
                                @if ($errors->has('li_client_id'))
                                <span class="help-block">{{ $errors->first('li_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Linkedin Client Secret -->
                            <div class="form-group {{ $errors->has('li_client_secret') ? 'has-error' : '' }}">
                                <label class="control-label">Linkedin Client Secret</label>
                                <input type="text" class="form-control" name="li_client_secret" value="{{ config('services.linkedin.client_secret') }}"> 
                                @if ($errors->has('li_client_secret'))
                                <span class="help-block">{{ $errors->first('li_client_secret') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- VK -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- VK Client ID -->
                            <div class="form-group {{ $errors->has('vk_client_id') ? 'has-error' : '' }}">
                                <label class="control-label">VK Client ID</label>
                                <input type="text" class="form-control" name="vk_client_id" value="{{ config('services.vkontakte.client_id') }}"> 
                                @if ($errors->has('vk_client_id'))
                                <span class="help-block">{{ $errors->first('vk_client_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- VK Client Secret -->
                            <div class="form-group {{ $errors->has('vk_client_secret') ? 'has-error' : '' }}">
                                <label class="control-label">VK Client Secret</label>
                                <input type="text" class="form-control" name="vk_client_secret" value="{{ config('services.vkontakte.client_secret') }}"> 
                                @if ($errors->has('vk_client_secret'))
                                <span class="help-block">{{ $errors->first('vk_client_secret') }}</span>
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