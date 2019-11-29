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
                    <span class="caption-subject bold font-blue uppercase">تحرير المقالة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/articles/edit/{{ $article->id }}" method="POST" enctype="multipart/form-data">
                
                	{{ csrf_field() }}

                	<!-- Article Title -->
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label class="control-label">Article Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $article->title }}"> 
                        @if ($errors->has('title'))
                        <span class="help-block">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <!-- Upload Cover -->
                    <div class="form-group {{ $errors->has('cover') ? 'has-error' : '' }}">
                        <label class="control-label">تحرير الغلاف</label>
                        <input type="file" name="cover"/> 
                        @if ($errors->has('cover'))
                        <span class="help-block">{{ $errors->first('cover') }}</span>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="form-group form-md-line-input">
                        <label class="control-label">محتوى المقالة</label>
                        <textarea name="content">{{ $article->content }}</textarea>
                        <script>
                            CKEDITOR.replace( 'content' );
                        </script>
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