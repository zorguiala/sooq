@extends ('dashboard.layout.app')

@section ('content')

<!-- Edit Comment -->
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

        <div class="portlet light">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue-madison bold uppercase">تعديل التعليق</span>
                </div>
            </div>

            <div class="portlet-body">

                <form method="POST" action="{{ Protocol::home() }}/dashboard/comments/edit/{{ $comment->id }}">

                    {{ csrf_field() }}

                    <!-- Comment Content -->
                    <div class="form-group {{ $errors->has('content') ? 'has-error' :'' }}">
                        <label class="control-label">محتوى التعليق</label>
                        <textarea class="form-control" rows="3" placeholder="Description" name="content">{{ $comment->content }}</textarea> 
                        @if ($errors->has('content'))
                        <span class="help-block">{{ $errors->first('content') }}</span>
                        @endif
                    </div>

                    <div class="margiv-top-10">
                        <button type="submit" class="btn green"> Save Changes </button>
                        <a href="{{ Protocol::home() }}/dashboard/comments" class="btn default"> إلغاء </a>
                    </div>
                    
                </form>

            </div>

        </div>

    </div>

</div>
@endsection