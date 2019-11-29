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
                <div class="caption font-green-haze">
                    <span class="caption-subject font-blue-madison bold uppercase"> تحرير القسم</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="{{ Protocol::home() }}/dashboard/categories/edit/{{ $category->id }}" method="POST" enctype="multipart/form-data">

                	{{ csrf_field() }}

                    <div class="form-body">

                    	<!-- Category Name -->
                        <div class="form-group form-md-line-input {{ $errors->has('category_name') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="category_name">اسم القسم</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name" value="{{ $category->category_name }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('category_name'))
                                <span class="help-block">{{ $errors->first('category_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Category Slug -->
                        <div class="form-group form-md-line-input {{ $errors->has('category_slug') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="category_slug">Category Slug</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="category_slug" placeholder="Category Slug" name="category_slug" value="{{ $category->category_slug }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('category_slug'))
                                <span class="help-block">{{ $errors->first('category_slug') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Category icon -->
                        <div class="form-group form-md-line-input {{ $errors->has('icon') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="icon">تحديث صورة القسم</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="icon"  name="icon">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('icon'))
                                <span class="help-block">{{ $errors->first('icon') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">تحرير القسم</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@endsection