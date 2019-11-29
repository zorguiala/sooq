@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    <div class="col-md-12">

    	<!-- Session Messages -->
    	@if (Session::has('error'))
    	<div class="alert alert-danger">
           	{{ Session::get('error') }} 
        </div>
        @endif
        @if (Session::has('success'))
    	<div class="alert alert-success">
           	{{ Session::get('success') }} 
        </div>
        @endif

        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue-madison bold uppercase">إنشاء صفحة جديدة</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="{{ Protocol::home() }}/dashboard/pages/create" method="POST">
                	{{ csrf_field() }}
                    <div class="form-body">

                    	<!-- Page Name -->
                        <div class="form-group form-md-line-input {{ $errors->has('page_name') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="page_name">اسم الصفحة</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="page_name" placeholder="Page Name" name="page_name" value="{{ old('page_name') }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('page_name'))
                                <span class="help-block">{{ $errors->first('page_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Page Slug -->
                        <div class="form-group form-md-line-input {{ $errors->has('page_slug') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="page_slug">الصفحة</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="page_slug" placeholder="Page Slug" name="page_slug" value="{{ old('page_slug') }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('page_slug'))
                                <span class="help-block">{{ $errors->first('page_slug') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Page Collection -->
                        <div class="form-group form-md-line-input {{ $errors->has('page_col') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="page_col">ودجت الصفحة </label>
                            <div class="col-md-10">
                                <select class="form-control" id="page_col" name="page_col">
                                    @php
                                    $pages = Config::get('footer');
                                    unset($pages['copyright']);
                                    @endphp
                                    @foreach ($pages as $col => $title)
                                    <option value="{{ $col }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('page_col'))
                                <span class="help-block">{{ $errors->first('page_col') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="is_sub">محتوى الصفحة </label>
                            <div class="col-md-10">
                                <textarea name="page_content">{{ old('page_content') }}</textarea>
                                <script>
                                    CKEDITOR.replace( 'page_content' );
                                </script>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">انشاء صفحة</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@endsection