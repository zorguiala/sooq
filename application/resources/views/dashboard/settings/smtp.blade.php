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
                    <span class="caption-subject font-blue bold uppercase">SMTP اعدادات</span>
                </div>
                <div class="actions" style="float: right;width: 75%;">
                    <div class="form-group">
                        <label style="padding-top: 5px;" class="col-md-4 control-label">خادم الاختبار</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="input">
                                    <input id="testEmailField" class="form-control" type="text" placeholder="Enter e-mail address"> </div>
                                <span class="input-group-btn">
                                    <button id="testServer" class="btn btn-success" type="button">
                                        <i class="fa fa-envelope"></i> إرسال رسالة اختبار</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet-body">

                <form action="{{ Protocol::home() }}/dashboard/settings/smtp" method="POST">
                    
                    {{ csrf_field() }}

                    <!-- Mail Driver -->
                    <div class="form-group {{ $errors->has('driver') ? 'has-error' : '' }}">
                        <label class="control-label">سائق البريد</label>
                        <select class="form-control" id="driver" name="driver">
                            @foreach ($drivers as $value => $driver)
                            <option value="{{ $value }}" {{ $value == config('mail.driver') ? 'selected' : '' }} >{{ $driver }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('driver'))
                        <span class="help-block">{{ $errors->first('driver') }}</span>
                        @endif
                    </div>

                    <!-- Mail Host Server -->
                    <div class="form-group form-md-line-input {{ $errors->has('host') ? 'has-error' : '' }}">
                        <input class="form-control" id="host" name="host" placeholder="Mail Host Server" value="{{ config('mail.host') }}" type="text">
                        <label for="host">Mail Host Server</label>
                        @if ($errors->has('host'))
                        <span class="help-block">{{ $errors->first('host') }}</span>
                        @endif
                    </div>

                    <!-- Mail Port -->
                    <div class="form-group form-md-line-input {{ $errors->has('port') ? 'has-error' : '' }}">
                        <input class="form-control" id="host" name="port" placeholder="Mail Port" value="{{ config('mail.port') }}" type="text">
                        <label for="port">Mail Port</label>
                        @if ($errors->has('port'))
                        <span class="help-block">{{ $errors->first('port') }}</span>
                        @endif
                    </div>

                    <!-- Mail Username -->
                    <div class="form-group form-md-line-input {{ $errors->has('username') ? 'has-error' : '' }}">
                        <input class="form-control" id="host" name="username" placeholder="Mail Username" value="{{ config('mail.username') }}" type="text">
                        <label for="username">اسم مستخدم البريد</label>
                        @if ($errors->has('username'))
                        <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                    <!-- Mail Password -->
                    <div class="form-group form-md-line-input {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input class="form-control" id="host" name="password" placeholder="***********" type="password">
                        <label for="password">كلمة السر</label>
                        @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <!-- Sender Email Address -->
                    <div class="form-group form-md-line-input {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input class="form-control" id="host" name="email" placeholder="Sender Email Address" value="{{ config('mail.from.address') }}" type="text">
                        <label for="email">عنوان البريد الإلكتروني للمرسل</label>
                        @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <!-- Sender Name -->
                    <div class="form-group form-md-line-input {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input class="form-control" id="host" name="name" placeholder="Sender Name" value="{{ config('mail.from.name') }}" type="text">
                        <label for="name">اسم المرسل</label>
                        @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <!-- Encryption Protocol -->
                    <div class="form-group {{ $errors->has('encryption') ? 'has-error' : '' }}">
                        <label class="control-label">بروتوكول التشفير</label>
                        <select class="form-control" id="encryption" name="encryption">
                            @if (config('mail.encryption') == 'tls')
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                            @else
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                            @endif
                        </select>
                        @if ($errors->has('encryption'))
                        <span class="help-block">{{ $errors->first('encryption') }}</span>
                        @endif
                    </div>

                    <button style="width: 100%" type="submit" class="btn default">تحديث الاعدادات</button>

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
    
    $('#testServer').on('click', function(e){

        e.preventDefault();

        var email     = document.getElementById('testEmailField').value,
            home      = document.getElementById('root').getAttribute('data-root'),
            newUrl    = home + '/dashboard/settings/smtp/test?email=' +email;

        window.open(newUrl, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');


    })

</script>

@endsection