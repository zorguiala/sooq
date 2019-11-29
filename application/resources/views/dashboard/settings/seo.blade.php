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
                    <span class="caption-subject bold font-blue uppercase">SEO اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/seo" method="POST">

                	{{ csrf_field() }}

                	<!-- Meta Description -->
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label class="control-label">SEO وصف</label>
                        <textarea row="3" class="form-control" name="description" placeholder="SEO Description">{{ $settings->description }}</textarea>
                        @if ($errors->has('description'))
                        <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <!-- SEO Keywords -->
                    <div class="form-group {{ $errors->has('keywords') ? 'has-error' : '' }}">
                        <label class="control-label">SEO كلمات</label>
                        <input type="text" class="form-control" name="keywords" value="{{ $settings->keywords }}" placeholder="SEO Keywords"> 
                        @if ($errors->has('keywords'))
                        <span class="help-block">{{ $errors->first('keywords') }}</span>
                        @endif
                    </div>

                    <!-- Google Analytics Traking Code -->
                    <div class="form-group {{ $errors->has('google_analytics') ? 'has-error' : '' }}">
                        <label class="control-label">مدونة تتبع Google Analytics</label>
                        <textarea row="3" class="form-control" name="google_analytics" placeholder="Google Analytics Traking Code">{{ $settings->google_analytics }}</textarea>
                        @if ($errors->has('google_analytics'))
                        <span class="help-block">{{ $errors->first('google_analytics') }}</span>
                        @endif
                    </div>

                    <!-- Header Code -->
                    <div class="form-group {{ $errors->has('header_code') ? 'has-error' : '' }}">
                        <label class="control-label">Header Code</label>
                        <textarea row="3" class="form-control" name="header_code" placeholder="Header Code">{{ $settings->header_code }}</textarea>
                        @if ($errors->has('header_code'))
                        <span class="help-block">{{ $errors->first('header_code') }}</span>
                        @endif
                    </div>

                    <!-- Sitemap -->
                    <div class="form-group {{ $errors->has('is_sitemap') ? 'has-error' : '' }}">
                        <label class="control-label">خريطة الموقع</label>
                        <select class="form-control" name="is_sitemap">
                            @if ($settings->is_sitemap)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_sitemap'))
                        <span class="help-block">{{ $errors->first('is_sitemap') }}</span>
                        @endif
                        <span class="help-block"><a target="_blank" class="text-muted uppercase" href="{{ Protocol::home() }}/sitemap">Sitemap</a></span>
                        <span class="help-block"><a target="_blank" class="text-muted uppercase" href="{{ Protocol::home() }}/sitemap/ads">ADS Sitemap</a></span>
                        <span class="help-block"><a target="_blank" class="text-muted uppercase" href="{{ Protocol::home() }}/sitemap/categories">Categories Sitemap</a></span>
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