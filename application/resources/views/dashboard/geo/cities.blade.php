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
                    <span class="caption-subject font-blue bold uppercase">قائمة المدن</span>
                </div>
                <div class="actions">
                    <div class="portlet-input input-inline">
                        <div class="input-icon right">
                            <i class="icon-magnifier"></i>
                            <form action="{{ Protocol::home() }}/dashboard/geo/cities" method="GET">
                                <input class="form-control input-circle" placeholder="Search for city..." type="text" name="search" value="{{ old('search') }}">
                            </form> 
                        </div>
                    </div>
                    <div class="btn-group btn-group-devided">
                        <a href="{{ Protocol::home() }}/dashboard/geo/cities/add" class="btn red btn-outline btn-circle btn-sm">اسم المدينة</a>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-hyperlink"></i></th>
                            <th class="text-center">اسم المدينة</th>
                            <th class="text-center">دولة</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($cities)
                        @foreach ($cities as $city)

                        <tr>
                            
                            <!-- ID -->
                            <td class="text-center text-muted">
                                {{ $city->id }}
                            </td>

                            <!-- Name -->
                            <td class="text-center text-muted">
                                {{ $city->name }}
                            </td>

                            <!-- State -->
                            <td class="text-center text-muted">
                                {{ Countries::state_name($city->state_id) }}
                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/geo/cities/edit/{{ $city->id }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير المدينة</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/geo/cities/delete/{{ $city->id }}">
                                                <i class="glyphicon glyphicon-trash"></i> حذف المدينة</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>

                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if (count($cities))
                <div class="text-center">
                    {{ $cities->links() }}
                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection
