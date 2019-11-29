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
                    <span class="caption-subject font-blue-madison bold uppercase">القائمة المحظورة</span>
                </div>
                <div class="actions">
                    <a href="{{ Protocol::home() }}/dashboard/firewall/add" class="btn dark btn-outline sbold uppercase">Add IP</a>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-ban"></i></th>
                            <th class="text-center">بلد</th>
                            <th class="text-center">مدينة</th>
                            <th class="text-center">تاريخ الحظر</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($firewall)
                        @foreach ($firewall as $f)
                        <tr>

                            <!-- IP Address -->
                            <td class="text-center text-muted">
                                {{ $f->ip_address }}
                            </td>

                            <!-- Country -->
                            <td class="text-center text-muted">
                                <img src="{{ Protocol::home() }}/content/assets/front-end/images/flags/{{ Tracker::ip($f->ip_address)->country_code() }}.png" style="height:24px;" class="tooltips" data-style="blue" data-container="body" data-original-title="{{ Tracker::ip($f->ip_address)->country_code() }}">
                            </td>

                            <!-- City -->
                            <td class="text-center text-muted">
                                {{ Tracker::ip($f->ip_address)->city() }}
                            </td>

                            <!-- Date -->
                            <td class="text-center text-muted">
                                {{ Helper::date_ago($f->created_at) }}
                            </td>  
        
                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ Protocol::home() }}/dashboard/firewall/delete/{{ $f->ip_address }}">
                                        <i style="color: #e73a3a;font-size: 15px;cursor: pointer;top: 3px;" class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if ($firewall)
                <div class="text-center">
                    {{ $firewall->links() }}
                </div>
                @endif

            </div>
        </div>

    </div>

</div>

@endsection