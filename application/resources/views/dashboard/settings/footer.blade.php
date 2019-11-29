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
                    <span class="caption-subject bold font-blue uppercase">Footer اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/footer" method="POST" enctype="multipart/form-data">
                
                	{{ csrf_field() }}

                	<!-- MailChimp API Key -->
                    <div class="form-group {{ $errors->has('mailchip_api_key') ? 'has-error' : '' }}">
                        <label class="control-label">MailChimp API Key</label>
                        <input type="text" class="form-control" name="mailchip_api_key" value="{{ config('newsletter.apiKey') }}"> 
                        @if ($errors->has('mailchip_api_key'))
                        <span class="help-block">{{ $errors->first('mailchip_api_key') }}</span>
                        @endif
                    </div>

                    <!-- MailChimp List ID -->
                    <div class="form-group {{ $errors->has('mailchip_list_id') ? 'has-error' : '' }}">
                        <label class="control-label">MailChimp List ID</label>
                        <input type="text" class="form-control" name="mailchip_list_id" value="{{ config('newsletter.lists.subscribers.id') }}"> 
                        @if ($errors->has('mailchip_list_id'))
                        <span class="help-block">{{ $errors->first('mailchip_list_id') }}</span>
                        @endif
                    </div>

                    <!-- Upload Footer Logo -->
                    <div class="form-group {{ $errors->has('footer_logo') ? 'has-error' : '' }}">
                        <label class="control-label">رفع شعار الفوتر</label>
                        <input type="file" name="footer_logo" accept="image/*" /> 
                        @if ($errors->has('footer_logo'))
                        <span class="help-block">{{ $errors->first('footer_logo') }}</span>
                        @endif
                    </div>

                    <!-- Footer Copyright -->
                    <div class="form-group {{ $errors->has('footer_copyright') ? 'has-error' : '' }}">
                        <label class="control-label">Footer حقوق النشر</label>
                        <input type="text" class="form-control" name="footer_copyright" value="{{ config('footer.copyright') }}"> 
                        @if ($errors->has('footer_copyright'))
                        <span class="help-block">{{ $errors->first('footer_copyright') }}</span>
                        @endif
                    </div>

                    <!-- Footer Column One -->
                    <div class="form-group {{ $errors->has('footer_column_one') ? 'has-error' : '' }}">
                        <label class="control-label">Footer العمود الأول</label>
                        <input type="text" class="form-control" name="footer_column_one" value="{{ config('footer.column_one') }}"> 
                        @if ($errors->has('footer_column_one'))
                        <span class="help-block">{{ $errors->first('footer_column_one') }}</span>
                        @endif
                    </div>

                    <!-- Footer Column Two -->
                    <div class="form-group {{ $errors->has('footer_column_two') ? 'has-error' : '' }}">
                        <label class="control-label">Footer العمود الثاني</label>
                        <input type="text" class="form-control" name="footer_column_two" value="{{ config('footer.column_two') }}"> 
                        @if ($errors->has('footer_column_two'))
                        <span class="help-block">{{ $errors->first('footer_column_two') }}</span>
                        @endif
                    </div>

                    <!-- Footer Column Three -->
                    <div class="form-group {{ $errors->has('footer_column_three') ? 'has-error' : '' }}">
                        <label class="control-label">Footer العمود الثالث</label>
                        <input type="text" class="form-control" name="footer_column_three" value="{{ config('footer.column_three') }}"> 
                        @if ($errors->has('footer_column_three'))
                        <span class="help-block">{{ $errors->first('footer_column_three') }}</span>
                        @endif
                    </div>

                    <!-- Footer Column Four -->
                    <div class="form-group {{ $errors->has('footer_column_four') ? 'has-error' : '' }}">
                        <label class="control-label">Footer العمود الرابع</label>
                        <input type="text" class="form-control" name="footer_column_four" value="{{ config('footer.column_four') }}"> 
                        @if ($errors->has('footer_column_four'))
                        <span class="help-block">{{ $errors->first('footer_column_four') }}</span>
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