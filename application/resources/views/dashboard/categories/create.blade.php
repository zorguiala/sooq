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
                    <span class="caption-subject font-blue bold uppercase"> انشاء قسم جديد</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="{{ Protocol::home() }}/dashboard/categories/create" method="POST" enctype="multipart/form-data">
                	{{ csrf_field() }}
                    <div class="form-body">

                    	<!-- Category Name -->
                        <div class="form-group form-md-line-input {{ $errors->has('category_name') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="category_name">اسم القسم</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name" value="{{ old('category_name') }}">
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
                                <input type="text" class="form-control" id="category_slug" placeholder="Category Slug" name="category_slug" value="{{ old('category_slug') }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('category_slug'))
                                <span class="help-block">{{ $errors->first('category_slug') }}</span>
                                @endif
                            </div>
                        </div>

                        @if (count(Helper::parent_categories()))
                        <!-- Is Sub category -->
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="is_sub">القسم الفرعي</label>
                            <div class="col-md-10">
                                <select class="form-control" id="is_sub" name="is_sub">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <!-- Parent Category-->
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="is_sub">القسم الرئيسي</label>
                            <div class="col-md-10">
                                <select class="form-control" id="parent_category" name="parent_category">
                                	@foreach (Helper::parent_categories() as $parent_category)
                                    <option value="{{ $parent_category->id }}">{{ $parent_category->category_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                        @endif

                        <!-- Category icon -->
                        <div class="form-group form-md-line-input {{ $errors->has('icon') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="icon">صورة القسم</label>
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
                        <button type="submit" class="btn default btn-block">إنشاء القسم</button>
                    </div>
                </form>
            </div>
        </div>

@endsection