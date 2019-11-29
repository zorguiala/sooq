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
                    <span class="caption-subject font-blue bold uppercase">فشل  تسجيل الدخول</span>
                </div>
                <div class="actions">
                    <a href="{{ Protocol::home() }}/dashboard/login/history/clear" class="btn dark btn-outline sbold uppercase">Clear</a>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-menu"></i></th>
                            <th class="text-center">عنوان بريد الكتروني</th>
                            <th class="text-center">بلد</th>
                            <th class="text-center">مدينة</th>
                            <th class="text-center">تاريخ</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($failed_login)
                        @foreach ($failed_login as $f)
                        <tr>

                            <!-- IP Address -->
                            <td class="text-center text-muted">
                                {{ $f->ip_address }}
                            </td>

                            <!-- Email Address -->
                            <td class="text-center text-muted">
                                {{ $f->email }}
                            </td>

                            <!-- Country -->
                            <td class="text-center text-muted">
                                @if (!is_null($f->country))
                                {{ $f->country }}
                                @else 
                                N/A
                                @endif
                            </td>

                            <!-- City -->
                            <td class="text-center text-muted">
                                @if ($f->city)
                                {{ $f->city }}
                                @else 
                                N/A
                                @endif
                            </td>

                            <!-- Date -->
                            <td class="text-center text-muted">
                                {{ Helper::date_ago($f->created_at) }}
                            </td> 
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if ($failed_login)
                <div class="text-center">
                    {{ $failed_login->links() }}
                </div>
                @endif

            </div>
        </div>

    </div>

</div>

@endsection