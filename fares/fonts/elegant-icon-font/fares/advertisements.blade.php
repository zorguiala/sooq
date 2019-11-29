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
		
		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">تحديث الإعلانات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/advertisements" method="POST">

                	{{ csrf_field() }}

                	<!-- Ad Sidebar Code -->
                    <div class="form-group">
                        <label class="control-label">رمز الشريط الجانبي للإعلان</label>
                        <textarea row="3" class="form-control" name="ad_sidebar" placeholder="Ad Sidebar Code">{{ $advertisements->ad_sidebar }}</textarea>
                    </div>

                    <!-- Ad Middle Code -->
                    <div class="form-group">
                        <label class="control-label">الإعلان الأوسط</label>
                        <textarea row="3" class="form-control" name="ad_middle" placeholder="Ad Middle Code">{{ $advertisements->ad_middle }}</textarea>
                    </div>

                    <!-- Search Sidebar Code -->
                    <div class="form-group">
                        <label class="control-label">بحث الشريط الجانبي</label>
                        <textarea row="3" class="form-control" name="search_sidebar" placeholder="Ad Middle Code">{{ $advertisements->search_sidebar }}</textarea>
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn blue">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

@endsection