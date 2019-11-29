@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-black-madison bold uppercase">قراءة تعليق</span>
                </div>
                <div class="actions">

                    <!-- Delete Comment -->
                    <a class="btn btn-circle btn-icon-only btn-default" href="{{ Protocol::home() }}/dashboard/comments/delete/{{ $comment->id }}">
                        <i class="icon-trash"></i>
                    </a>
                    
                </div>
            </div>

            <div class="portlet-body">
                
                <div class="grey-gallery well">{!! nl2br($comment->content) !!}</div>

            </div>

        </div>

    </div>

</div>

@endsection