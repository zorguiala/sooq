@extends ('dashboard.layout.app')

@section ('content')

<!-- Comments -->
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
                    <span class="caption-subject font-blue-madison bold uppercase">تعليقات المستخدم</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <div class="table-scrollable">
                    <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center"><i class="icon-people"></i></th>
                                <th>مستخدم</th>
                                <th class="text-center">AD ID</th>
                                <th class="text-center">Pinned</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">أنشئت في</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if($comments)
                            @foreach ($comments as $comment)
                            <tr>
                                
                                <!-- User Avatar -->
                                <td class="text-center">
                                    <div class="avatar">
                                        <img src="{{ Profile::picture($comment->user_id) }}" class="img-avatar" alt="{{ Helper::username_by_id($comment->user_id) }}">
                                    </div>
                                </td>

                                <!-- User Info -->
                                <td>
                                    @if (Profile::hasStore($comment->user_id))
                                    <a href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($comment->user_id) }}">{{ Profile::hasStore($comment->user_id)->title }}</a>
                                    <div class="small text-muted">
                                        <span>{{ Profile::hasStore($comment->user_id)->username }}</span> | {{ Helper::date_ago($comment->created_at) }}
                                    </div>
                                    @else 
                                    <a href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($comment->user_id) }}">{{ Profile::full_name($comment->user_id) }}</a>
                                    <div class="small text-muted">
                                        <span>{{ Helper::username_by_id($comment->user_id) }}</span> | {{ Helper::date_ago($comment->created_at) }}
                                    </div>
                                    @endif
                                </td>

                                <!-- Ad ID -->
                                <td class="text-center">
                                    <a href="{{ Protocol::home() }}/vi/{{ $comment->ad_id }}" target="_blank" class="text-muted">{{ $comment->ad_id }}</a>
                                </td>

                                <!-- Is Pinned CM -->
                                <td class="text-center">
                                    @if ($comment->is_pinned)
                                    <span class="badge badge-info badge-roundless"> Pinned </span>
                                    @else 
                                    <span class="badge badge-default badge-roundless"> Not Pinned </span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    @if ($comment->status)
                                    <span class="badge badge-success badge-roundless"> نشرت </span>
                                    @else 
                                    <span class="badge badge-danger badge-roundless"> قيد الانتظار </span>
                                    @endif
                                </td>

                                <!-- Created At -->
                                <td class="text-center text-muted">
                                    {{ Helper::date_ago($comment->created_at) }}
                                </td>

                                <!-- Options -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="{{ Protocol::home() }}/dashboard/comments/read/{{ $comment->id }}">
                                                    <i class="glyphicon glyphicon-eye-open"></i> قراءة تعليق</a>
                                            </li>
                                            <li>
                                                <a href="{{ Protocol::home() }}/dashboard/comments/edit/{{ $comment->id }}">
                                                    <i class="glyphicon glyphicon-pencil"></i> تعديل التعليق</a>
                                            </li>
                                            <li>
                                                @if ($comment->status)
                                                <a href="{{ Protocol::home() }}/dashboard/comments/inactive/{{ $comment->id }}">
                                                    <i class="glyphicon glyphicon-remove"></i> تعليق غير نشط</a>
                                                @else 
                                                <a href="{{ Protocol::home() }}/dashboard/comments/active/{{ $comment->id }}">
                                                    <i class="glyphicon glyphicon-ok"></i> التعليق النشط</a>
                                                @endif
                                            </li>
                                            <li>
                                                @if ($comment->is_pinned)
                                                <a href="{{ Protocol::home() }}/dashboard/comments/unpin/{{ $comment->id }}">
                                                    <i class="glyphicon glyphicon-flash"></i> إزالة تعليق</a>
                                                @else 
                                                <a href="{{ Protocol::home() }}/dashboard/comments/pin/{{ $comment->id }}">
                                                    <i class="glyphicon glyphicon-pushpin"></i> تعليق</a>
                                                @endif
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/comments/delete/{{ $comment->id }}">
                                                    <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف تعليق</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>

                @if ($comments)
                <div class="text-center">
                    {{ $comments->links() }}
                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection