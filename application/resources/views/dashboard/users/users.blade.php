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
                    <span class="caption-subject font-blue-madison bold uppercase">قائمة المستخدمين</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-people"></i></th>
                            <th>المستعمل</th>
                            <th class="text-center">بلد</th>
                            <th>عنوان بريد الكتروني</th>
                            <th class="text-center">جنس</th>
                            <th class="text-center">الحساب</th>
                            <th class="text-center">مستوى</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($users)
                        @foreach ($users as $user)
                        <tr>

                            <!-- User Avatar -->
                            <td class="text-center">
                                <div class="avatar">
                                    <img src="{{ Profile::picture($user->id) }}" class="img-avatar" alt="{{ $user->username }}">
                                    @if ($user->status)
                                    <span class="avatar-status tag-success tooltips" data-container="body" data-placement="top" data-original-title="Active User"></span>
                                    @else
                                    <span class="avatar-status tag-danger tooltips" data-container="body" data-placement="top" data-original-title="Pending Active"></span>
                                    @endif
                                </div>
                            </td>

                            <!-- User Info -->
                            <td>
                                <a href="{{ Protocol::home() }}/dashboard/users/details/{{ $user->username }}">{{ $user->first_name }}  {{ $user->last_name }}</a>
                                <div class="small text-muted">
                                    <span>{{ $user->username }}</span> | {{ Helper::date_ago($user->created_at) }}
                                </div>
                            </td>

                            <!-- User Country -->
                            <td class="text-center">
                                <img src="{{ Protocol::home() }}/content/assets/front-end/images/flags/{{ $user->country_code }}.png" alt="{{ Countries::country_name($user->country_code) }}" title="{{ Countries::country_name($user->country_code) }}" style="height:24px;">
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->email }}</span>
                            </td>
                            <td class="text-center">
                                @if ($user->gender)
                                <span class="text-black">ولد</span>
                                @else 
                                <span class="text-black">بنت</span>
                                @endif
                            </td>

                            <!-- Account Type -->
                            <td class="text-center">
                                @if ($user->account_type)
                                <span class="badge badge-success badge-roundless"> المحترفين </span>
                                @else 
                                <span class="badge badge-default badge-roundless"> اساسي </span>
                                @endif
                            </td>

                            <!-- User Level -->
                            <td class="text-center">
                                @if ($user->is_admin)
                                <span class="badge badge-danger badge-roundless"> Administrator </span>
                                @elseif (!$user->is_admin AND $user->is_moderator)
                                <span class="badge badge-warning badge-roundless"> Moderator </span>
                                @else
                                <span class="badge badge-default badge-roundless"> Member </span>
                                @endif
                            </td>   
        
                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        @if (!Profile::hasStore($user->id))
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/{{ $user->username }}/create/store">
                                                <i class="glyphicon glyphicon-shopping-cart"></i> إنشاء المتجر</a>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/details/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-user"></i> بيانات المستخدم</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/ads/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-list-alt"></i> إعلانات هذا المستخدم</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/comments/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-comment"></i> تعليقات المستخدم</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/edit/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير العضو</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/warning/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-flag"></i> إرسال تحذير</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/users/warnings/delete/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-warning-sign"></i> حذف التحذيرات</a>
                                        </li>
                                        <li>
                                            @if ($user->status)
                                            <a href="{{ Protocol::home() }}/dashboard/users/inactive/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-remove"></i> مستخدم غير نشط</a>
                                            @else 
                                            <a href="{{ Protocol::home() }}/dashboard/users/active/{{ $user->username }}">
                                                <i class="glyphicon glyphicon-ok"></i> مستخدم نشط</a>
                                            @endif
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/users/delete/{{ $user->username }}">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> مسح المستخدم</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if ($users)
                <div class="text-center">
                    {{ $users->links() }}
                </div>
                @endif
                
            </div>
        </div>

    </div>

</div>

@endsection