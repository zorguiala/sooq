@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue bold uppercase">Ad Offers</span>
                </div>
            </div>

            <div class="portlet-body">

                <div class="table-scrollable">
                    <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center">عرض من</th>
                                <th class="text-center">عرض الى</th>
                                <th class="text-center">سعر العرض</th>
                                <th class="text-center">تاريخ</th>
                                <th class="text-center">حالة</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($offers)
                            @foreach ($offers as $offer)
                            <tr>

                                <!-- Offer By -->
                                <td class="text-center">
                                    <a class="text-muted" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($offer->offer_by) }}">{{ Helper::username_by_id($offer->offer_by) }}</a>
                                </td>

                                <!-- Offer To -->
                                <td class="text-center">
                                    <a class="text-muted" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($offer->offer_to) }}">{{ Helper::username_by_id($offer->offer_to) }}</a>
                                </td>

                                <!-- Offer Price -->
                                <td class="text-muted text-center">
                                    <span>{{ Helper::getPriceFormat($offer->price, Helper::ad_details($offer->ad_id, 'currency')) }}</span>
                                </td>

                                <!-- Offer Date -->
                                <td class="text-muted text-center">
                                    <span>{{ Helper::date_ago($offer->created_at) }}</span>
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

                    @if ($offers)
                    <div class="text-center">
                        {{ $offers->links() }}
                    </div>
                    @endif

                </div>
                
            </div>

        </div>

    </div>
</div>

@endsection