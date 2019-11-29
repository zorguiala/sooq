@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-black-madison bold uppercase">{{ $message->subject }}</span>
                </div>
                <div class="actions">

                    <!-- User Details -->
                    <a class="btn btn-circle btn-icon-only btn-default" href="{{ Protocol::home() }}/dashboard/users/details/{{ $message->msg_from }}">
                        <i class="icon-user"></i>
                    </a>

                    <!-- Delete Message -->
                    <a class="btn btn-circle btn-icon-only btn-default" href="{{ Protocol::home() }}/dashboard/messages/users/delete/{{ $message->id }}">
                        <i class="icon-trash"></i>
                    </a>
                    
                </div>
            </div>

            <div class="portlet-body">
                
                <div class="grey-gallery well">{!! nl2br($message->message) !!}</div>

            </div>

        </div>

    </div>

</div>

@endsection