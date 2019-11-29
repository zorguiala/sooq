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
                    <span class="caption-subject bold font-blue uppercase">إعدادات الصفحة الرئيسية</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/home" method="POST" enctype="multipart/form-data">
                
                	{{ csrf_field() }}

                    <!-- Upload Wallpaper -->
                    <div class="form-group {{ $errors->has('wallpaper') ? 'has-error' : '' }}">
                        <label class="control-label">تحميل خلفية</label>
                        <input type="file" name="wallpaper"/> 
                        @if ($errors->has('wallpaper'))
                        <span class="help-block">{{ $errors->first('wallpaper') }}</span>
                        @endif
                    </div>

                    <!-- Video Link -->
                    <div class="form-group {{ $errors->has('video') ? 'has-error' : '' }}">
                        <label class="control-label">رابط الفيديو</label>
                        <input type="text" class="form-control" name="video" value="{{ Config::get('home.video') }}"> 
                        @if ($errors->has('video'))
                        <span class="help-block">{{ $errors->first('video') }}</span>
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