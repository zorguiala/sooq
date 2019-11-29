@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">
        
        <!-- Sessions Messages -->
        @if (Session::has('success'))
        <div class="custom-alerts alert alert-success fade in">
            {{ Session::get('success') }}
        </div>
        @endif

        @if (Session::has('error'))
        <div class="custom-alerts alert alert-danger fade in">
            {{ Session::get('error') }}
        </div>
        @endif

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue bold uppercase">اعدادات الامان</span>
                </div>
            </div>

            <div class="portlet-body">

                <form action="{{ Protocol::home() }}/dashboard/settings/security" method="POST">
                    
                    {{ csrf_field() }}

                    <!-- Blacklist username -->
                    <div class="form-group form-md-line-input {{ $errors->has('blacklist_username') ? 'has-error' : '' }}">
                        <textarea id="blacklist_username" class="form-control" rows="10" placeholder="one per line" name="blacklist_username">{{ $settings->blacklist_username }}</textarea>
                        <label for="blacklist_username">اسم مستخدم القائمة السوداء</label>
                        @if ($errors->has('blacklist_username'))
                        <span class="help-block">{{ $errors->first('blacklist_username') }}</span>
                        @endif
                    </div>

                    <!-- Turn on Debug -->
                    <div class="form-group form-md-line-input {{ $errors->has('debug') ? 'has-error' : '' }}">
                        <select class="form-control" id="debug" name="debug">
                            @if (config('app.debug') == 'true')
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        <label for="debug">قم بتشغيل Debug</label>
                        @if ($errors->has('debug'))
                        <span class="help-block">{{ $errors->first('debug') }}</span>
                        @endif
                    </div>

                    <!-- Auto Approve Ads -->
                    <div class="form-group form-md-line-input {{ $errors->has('auto_approve_ads') ? 'has-error' : '' }}">
                        <select class="form-control" id="auto_approve_ads" name="auto_approve_ads">
                            @if ($settings->auto_approve_ads)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        <label for="auto_approve_ads">الموافقة التلقائية على الإعلانات</label>
                        @if ($errors->has('auto_approve_ads'))
                        <span class="help-block">{{ $errors->first('auto_approve_ads') }}</span>
                        @endif
                    </div>

                    <!-- Auto Approve Comments -->
                    <div class="form-group form-md-line-input {{ $errors->has('auto_approve_comments') ? 'has-error' : '' }}">
                        <select class="form-control" id="auto_approve_comments" name="auto_approve_comments">
                            @if ($settings->auto_approve_comments)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        <label for="auto_approve_comments">قبول السيارات التعليقات</label>
                        @if ($errors->has('auto_approve_comments'))
                        <span class="help-block">{{ $errors->first('auto_approve_comments') }}</span>
                        @endif
                    </div>

                    <!-- Active Recaptcha -->
                    <div class="form-group form-md-line-input {{ $errors->has('recaptcha') ? 'has-error' : '' }}">
                        <select class="form-control" id="recaptcha" name="recaptcha">
                            @if ($settings->recaptcha)
                            <option value="1">نشيط</option>
                            <option value="0">غير نشط</option>
                            @else 
                            <option value="0">غير نشط</option>
                            <option value="1">نشيط</option>
                            @endif
                        </select>
                        <label for="recaptcha">Invisible Recaptcha</label>
                        @if ($errors->has('recaptcha'))
                        <span class="help-block">{{ $errors->first('recaptcha') }}</span>
                        @endif
                    </div>

                    <!-- Captcha Site Key -->
                    <div class="form-group form-md-line-input {{ $errors->has('captcha_sitekey') ? 'has-error' : '' }}">
                        <input class="form-control" id="captcha_sitekey" name="captcha_sitekey" placeholder="Captcha Site Key" value="{{ config('captcha.siteKey') }}" type="text">
                        <label for="captcha_sitekey">Recaptcha Site Key</label>
                        @if ($errors->has('captcha_sitekey'))
                        <span class="help-block">{{ $errors->first('captcha_sitekey') }}</span>
                        @endif
                    </div>

                    <!-- Captcha Secret Key -->
                    <div class="form-group form-md-line-input {{ $errors->has('captcha_secretkey') ? 'has-error' : '' }}">
                        <input class="form-control" id="captcha_secretkey" name="captcha_secretkey" placeholder="Captcha Secret Key" value="{{ config('captcha.secretKey') }}" type="text">
                        <label for="captcha_secretkey">Recaptcha Secret Key</label>
                        @if ($errors->has('captcha_secretkey'))
                        <span class="help-block">{{ $errors->first('captcha_secretkey') }}</span>
                        @endif
                    </div>

                    <!-- Max Login Attempts -->
                    <div class="form-group form-md-line-input {{ $errors->has('max_attempts') ? 'has-error' : '' }}">
                        <input class="form-control" id="max_attempts" name="max_attempts" placeholder="Max Login Attempts" value="{{ $settings->max_attempts }}" type="text">
                        <label for="max_attempts">Max Login Attempts</label>
                        @if ($errors->has('max_attempts'))
                        <span class="help-block">{{ $errors->first('max_attempts') }}</span>
                        @endif
                    </div>

                    <!-- Unlock Login After (seconds) -->
                    <div class="form-group form-md-line-input {{ $errors->has('unlock_time') ? 'has-error' : '' }}">
                        <input class="form-control" id="unlock_time" name="unlock_time" placeholder="Time to unlock login" value="{{ $settings->unlock_time }}" type="text">
                        <label for="unlock_time">Unlock Login After (seconds)</label>
                        @if ($errors->has('unlock_time'))
                        <span class="help-block">{{ $errors->first('unlock_time') }}</span>
                        @endif
                    </div>

                    <!-- Max Image Size (MB) -->
                    <div class="form-group form-md-line-input {{ $errors->has('max_image_size') ? 'has-error' : '' }}">
                        <input class="form-control" id="max_image_size" name="max_image_size" placeholder="Max Image Size (MegaBytes)" value="{{ $settings->max_image_size }}" type="text">
                        <label for="unlock_time">Max Image Size (MB)</label>
                        @if ($errors->has('max_image_size'))
                        <span class="help-block">{{ $errors->first('max_image_size') }}</span>
                        @endif
                    </div>

                    <button style="width: 100%" type="submit" class="btn default">تحديث الاعدادات</button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection