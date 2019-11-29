@extends ('dashboard.layout.app')

@section ('content')

<!-- Offers -->
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
                    <span class="caption-subject font-blue-madison bold uppercase">Offers Settings</span>
                </div>
            </div>

            <div class="portlet-body">
    
                <div class="table-scrollable">
                    <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center"><i class="icon-link"></i></th>
                                <th class="text-center">عرض بواسطة</th>
                                <th class="text-center">عرض ل</th>
                                <th class="text-center">السعر</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">أنشئت في</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if($offers)
                            @foreach ($offers as $offer)
                            <tr>

                                <!-- Ad ID -->
                                <td class="text-center">
                                    <a href="{{ Protocol::home() }}/vi/{{ $offer->ad_id }}" target="_blank" class="text-muted">{{ $offer->ad_id }}</a>
                                </td>

                                <!-- Offer By -->
                                <td class="text-center">
                                    <a class="text-muted" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($offer->offer_by) }}">{{ Helper::username_by_id($offer->offer_by) }}</a>
                                </td>

                                <!-- Offer To -->
                                <td class="text-center">
                                    <a class="text-muted" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($offer->offer_to) }}">{{ Helper::username_by_id($offer->offer_to) }}</a>
                                </td>

                                <!-- Price -->
                                <td class="text-center text-muted">
                                    {{ Helper::getPriceFormat($offer->price, Helper::ad_details($offer->ad_id, 'currency')) }}
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    @if (is_null($offer->is_accepted))
                                    <span class="badge badge-default badge-roundless"> قيد الانتظار </span>
                                    @elseif ($offer->is_accepted)
                                    <span class="badge badge-success badge-roundless"> وافقت </span>
                                    @else 
                                    <span class="badge badge-danger badge-roundless"> رفض </span>
                                    @endif
                                </td>

                                <!-- Created At -->
                                <td class="text-center text-muted">
                                    {{ Helper::date_ago($offer->created_at) }}
                                </td>

                                <!-- Options -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/offers/delete/{{ $offer->id }}">
                                                    <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف العرض</a>
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

                @if ($offers)
                <div class="text-center">
                    {{ $offers->links() }}
                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection