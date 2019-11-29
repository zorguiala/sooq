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
                    <span class="caption-subject bold font-blue uppercase">الاعدادات العامة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/general" method="POST" enctype="multipart/form-data">
                
                	{{ csrf_field() }}

                	<!-- Site Title -->
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label">عنوان الموقع</label>
                        <input type="text" class="form-control" name="title" value="{{ $settings->title }}"> 
                        @if ($errors->has('title'))
                        <span class="help-block">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label class="control-label">Short Description</label>
                        <input type="text" class="form-control" name="description" value="{{ $settings->description }}"> 
                        @if ($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <!-- Upload Logo -->
                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                        <label class="control-label">رفع الشعار</label>
                        <input type="file" name="logo"/> 
                        @if ($errors->has('logo'))
                        <span class="help-block">{{ $errors->first('logo') }}</span>
                        @endif
                    </div>

                    <!-- Upload Favicon -->
                    <div class="form-group {{ $errors->has('favicon') ? 'has-error' : '' }}">
                        <label class="control-label">تحميل  Favicon</label>
                        <input type="file" name="favicon"/> 
                        @if ($errors->has('favicon'))
                        <span class="help-block">{{ $errors->first('favicon') }}</span>
                        @endif
                    </div>

                    <!-- Default Language -->
                    <div class="form-group {{ $errors->has('language') ? 'has-error' : '' }}">
                        <label class="control-label">اللغة الافتراضية</label>
                        <select class="form-control" name="language">
                            @foreach (Countries::languages() as $key => $name)
                            <option {{ $settings->language == $key ? 'selected' : '' }} value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('language'))
                        <span class="help-block">{{ $errors->first('language') }}</span>
                        @endif
                    </div>

                    <!-- Site Direction -->
                    <div class="form-group {{ $errors->has('direction') ? 'has-error' : '' }}">
                        <label class="control-label">اتجاه الموقع</label>
                        <select class="form-control" name="direction">
                            @if (config('app.rtl'))
                            <option value="1">RTL</option>
                            <option value="0">LTR</option>
                            @else 
                            <option value="0">LTR</option>
                            <option value="1">RTL</option>
                            @endif
                        </select>
                        @if ($errors->has('direction'))
                        <span class="help-block">{{ $errors->first('direction') }}</span>
                        @endif
                    </div>

                    <!-- Default Host -->
                    <div class="form-group {{ $errors->has('cloud') ? 'has-error' : '' }}">
                        <label class="control-label">Default Host</label>
                        <select class="form-control" name="cloud">
                            @foreach ($clouds as $cloud)
                            <option {{ $settings->default_host == $cloud ? 'selected' : '' }} value="{{ $cloud }}">{{ $cloud }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('cloud'))
                        <span class="help-block">{{ $errors->first('cloud') }}</span>
                        @endif
                    </div>

                    <!-- Facebook Page -->
                    <div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
                        <label class="control-label">Facebook صفحة</label>
                        <input type="text" class="form-control" name="facebook" value="{{ config('social.facebook') }}"> 
                        @if ($errors->has('facebook'))
                        <span class="help-block">{{ $errors->first('facebook') }}</span>
                        @endif
                    </div>

                    <!-- Twitter Page -->
                    <div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
                        <label class="control-label">Twitter صفحة</label>
                        <input type="text" class="form-control" name="twitter" value="{{ config('social.twitter') }}"> 
                        @if ($errors->has('twitter'))
                        <span class="help-block">{{ $errors->first('twitter') }}</span>
                        @endif
                    </div>

                    <!-- Google Page -->
                    <div class="form-group {{ $errors->has('google') ? 'has-error' : '' }}">
                        <label class="control-label">Google صفحة</label>
                        <input type="text" class="form-control" name="google" value="{{ config('social.google') }}"> 
                        @if ($errors->has('google'))
                        <span class="help-block">{{ $errors->first('google') }}</span>
                        @endif
                    </div>

                    <!-- Android Application -->
                    <div class="form-group {{ $errors->has('android') ? 'has-error' : '' }}">
                        <label class="control-label">Android تطبيق</label>
                        <input type="text" class="form-control" name="android" value="{{ config('social.android') }}"> 
                        @if ($errors->has('android'))
                        <span class="help-block">{{ $errors->first('android') }}</span>
                        @endif
                    </div>

                    <!-- iPhone Application -->
                    <div class="form-group {{ $errors->has('iphone') ? 'has-error' : '' }}">
                        <label class="control-label">iPhone تطبيق</label>
                        <input type="text" class="form-control" name="iphone" value="{{ config('social.iphone') }}"> 
                        @if ($errors->has('iphone'))
                        <span class="help-block">{{ $errors->first('iphone') }}</span>
                        @endif
                    </div>

                    <!-- Windows Phone Application -->
                    <div class="form-group {{ $errors->has('windows') ? 'has-error' : '' }}">
                        <label class="control-label">Windows Phone تطبيق</label>
                        <input type="text" class="form-control" name="windows" value="{{ config('social.windows') }}"> 
                        @if ($errors->has('windows'))
                        <span class="help-block">{{ $errors->first('windows') }}</span>
                        @endif
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%;">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

@endsection