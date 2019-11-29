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
                    <span class="caption-subject font-blue-madison bold uppercase">قائمة الدول</span>
                </div>
                <div class="actions">
                    <div class="portlet-input input-inline">
                        <div class="input-icon right">
                            <i class="icon-magnifier"></i>
                            <form action="{{ Protocol::home() }}/dashboard/geo/countries" method="GET">
                                <input class="form-control input-circle" placeholder="Search for country..." type="text" name="search" value="{{ old('search') }}">
                            </form> 
                        </div>
                    </div>
                    <div class="btn-group btn-group-devided">
                        <a href="{{ Protocol::home() }}/dashboard/geo/countries/add" class="btn red btn-outline btn-circle btn-sm">بلد جديد</a>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-hyperlink"></i></th>
                            <th class="text-center">اسم نوع</th>
                            <th class="text-center">اسم الدولة</th>
                            <th class="text-center">كود الهاتف</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($countries)
                        @foreach ($countries as $country)

                        <tr>
                            
                            <!-- ID -->
                            <td class="text-center text-muted">
                                {{ $country->id }}
                            </td>

                            <!-- Sortname -->
                            <td class="text-center text-muted">
                                {{ $country->sortname }}
                            </td>

                            <!-- Name -->
                            <td class="text-center text-muted">
                                {{ $country->name }}
                            </td>

                            <!-- Phone Code -->
                            <td class="text-center text-muted">
                                {{ $country->phonecode }}
                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/geo/countries/edit/{{ $country->id }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير البلد</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/geo/countries/delete/{{ $country->id }}">
                                                <i class="glyphicon glyphicon-trash"></i> حذف البلد</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>

                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if (count($countries))
                <div class="text-center">
                    {{ $countries->links() }}
                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection
