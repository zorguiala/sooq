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
                    <span class="caption-subject font-blue-madison bold uppercase">إنشاء مقال جديد</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="{{ Protocol::home() }}/dashboard/articles/create" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-body">

                        <!-- Title -->
                        <div class="form-group form-md-line-input {{ $errors->has('title') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="title">عنوان المقال</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="title" placeholder="Article Title" name="title" value="{{ old('title') }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Cover -->
                        <div class="form-group form-md-line-input {{ $errors->has('cover') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="cover">غلاف المقال</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="cover"  name="cover" value="{{ old('cover') }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('cover'))
                                <span class="help-block">{{ $errors->first('cover') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="content">محتوى المقالة</label>
                            <div class="col-md-10">
                                <textarea name="content">{{ old('content') }}</textarea>
                                <script>
                                    CKEDITOR.replace( 'content' );
                                </script>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">انشاء مقالة</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@endsection