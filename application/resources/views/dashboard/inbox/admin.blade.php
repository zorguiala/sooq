@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">
        
        <!-- Sessions Messages -->
        @if (Session::has('success'))
        <div class="custom-alerts alert alert-success fade in">
            {{ Session::get('success') }}
        </div>
        @endif

        @if (Session::has('error'))
        <div class="custom-alerts alert alert-danger fade in">
            {{ Session::get('error') }}
        </div>
        @endif

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">رسائل المسؤول</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center">الاسم كامل</th>
                            <th class="text-center">عنوان بريد الكتروني</th>
                            <th class="text-center">رقم الهاتف</th>
                            <th>موضوع</th>
                            <th class="text-center">تاريخ</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($messages)
                        @foreach ($messages as $message)
                        <tr>
                        
                            <!-- Sender Name -->
                            <td class="text-center text-muted">
                                {{ $message->full_name }}
                            </td>

                            <!-- Sender Email -->
                            <td class="text-center text-muted">
                                {{ $message->email }}
                            </td>

                            <!-- Sender Phone -->
                            <td class="text-center text-muted">
                                {{ $message->phone }}
                            </td>

                            <!-- Message Subject -->
                            <td class="text-semibold">
                                {{ $message->subject }}
                            </td>

                            <!-- Message Date -->
                            <td class="text-center text-muted">
                                {{ Helper::date_ago($message->created_at) }}
                            </td>

                            <!-- Message Status -->
                            <td class="text-center">
                                @if ($message->is_read)
                                <span class="badge badge-success badge-roundless"> مقروء </span>
                                @else 
                                <span class="badge badge-default badge-roundless"> غير مقروء </span>
                                @endif
                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/messages/admin/read/{{ $message->id }}">
                                                <i class="glyphicon glyphicon-eye-open"></i> قراءة الرسالة</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/messages/admin/delete/{{ $message->id }}">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف رسالة</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if ($messages)
                <div class="text-center">
                    {{ $messages->links() }}
                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection