@extends ('dashboard.layout.app')

@section ('content')

<!-- Notifications -->
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
                    <span class="caption-subject font-blue bold uppercase">إعلانات تقارير الإخطارات</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-link"></i></th>
                            <th class="text-center">تم عمل تقرير بواسطة</th>
                            <th class="text-center">حالة الإعلان</th>
                            <th class="text-center">حالة الاشعارات</th>
                            <th class="text-center">تاريخ</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if($notifications)
                        @foreach ($notifications as $n)
                        <tr>
                            
                            <!-- AD ID -->
                            <td class="text-center">
                                <a class="text-muted" target="_blank" href="{{ Protocol::home() }}/vi/{{ $n->ad_id }}">{{ $n->ad_id }}</a>
                            </td>

                            <!-- Posted By -->
                            <td class="text-center">
                                <a href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($n->user_id) }}" target="_blank" class="text-muted">{{ Profile::full_name($n->user_id) }}</a>
                            </td>

                            <!-- Ad Status -->
                            <td class="text-center">
                                @if (Helper::ad_status($n->ad_id))
                                <span class="badge badge-success badge-roundless"> نشرت </span>
                                @else 
                                <span class="badge badge-danger badge-roundless"> قيد الانتظار </span>
                                @endif
                            </td>

                            <!-- Notification Status -->
                            <td class="text-center">
                                @if ($n->is_read)
                                <span class="badge badge-default badge-roundless"> مقروء </span>
                                @else 
                                <span class="badge badge-info badge-roundless"> غير مقروء </span>
                                @endif
                            </td>

                            <!-- Created At -->
                            <td class="text-center text-muted">
                                {{ Helper::date_ago($n->created_at) }}
                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/edit/{{ $n->ad_id }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير الإعلان</a>
                                        </li>
                                        <li>
                                            @if (Helper::ad_status($n->ad_id))
                                            <a href="{{ Protocol::home() }}/dashboard/ads/inactive/{{ $n->ad_id }}">
                                                <i class="glyphicon glyphicon-remove"></i> الإعلان غير النشط</a>
                                            @else 
                                            <a href="{{ Protocol::home() }}/dashboard/ads/active/{{ $n->ad_id }}">
                                                <i class="glyphicon glyphicon-ok"></i> إعلان نشط</a>
                                            @endif
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/notifications/ads/delete/{{ $n->id }}">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف الإشعار</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if ($notifications)
                <div class="text-center">
                    {{ $notifications->links() }}
                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection