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
                    <span class="caption-subject font-blue bold uppercase">إخطارات المدفوعات</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-people"></i></th>
                            <th class="text-center">طريقة</th>
                            <th class="text-center">نوع</th>
                            <th class="text-center">كمية</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">تاريخ</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if($notifications)
                        @foreach ($notifications as $n)
                        <tr>
                            
                            <!-- User -->
                            <td class="text-center">
                                <a class="text-muted" target="_blank" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($n->user_id) }}">{{ Helper::username_by_id($n->user_id) }}</a>
                            </td>

                            <!-- Method -->
                            <td class="text-center">
                                <span class="badge badge-success badge-roundless"> {{ $n->payment_method }} </span>
                            </td>

                            <!-- Type -->
                            <td class="text-center">
                                @if ($n->payment_type == 'account')
                                <span class="badge badge-warning badge-roundless"> ترقية الحساب </span>
                                @else 
                                <span class="badge badge-danger badge-roundless"> ترقية الإعلان </span>
                                @endif
                            </td>

                            <!-- Amount -->
                            <td class="text-center text-muted">
                                {{ $n->payment_amount }} {{ strtoupper($n->payment_currency) }}
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
                                    <a href="{{ Protocol::home() }}/dashboard/notifications/payments/delete/{{ $n->id }}"><i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-trash"></i></a>
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