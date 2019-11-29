@extends ('dashboard.layout.app')

@section ('content')

<!-- Payments -->
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
                    <span class="caption-subject font-blue-madison bold uppercase">ADS ترقية محفوظات المدفوعات</span>
                </div>
            </div>

            <div class="portlet-body">
                
                <div class="table-responsive">

                    <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center"><i class="icon-people"></i></th>
                                <th class="text-center">علامة تجارية</th>
                                <th>AD ID</th>
                                <th>صفقة ID</th>
                                <th>ائتمان</th>
                                <th class="text-center">ايام</th>
                                <th class="text-center">كمية</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">تاريخ</th>
                                <th class="text-center">ينتهي عند</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if($payments)
                            @foreach ($payments as $payment)
                            <tr>

                                <!-- User -->
                                <td class="text-center">
                                    <div class="avatar">
                                        <a target="_blank" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($payment->user_id) }}">
                                        <img src="{{ Profile::picture($payment->user_id) }}" class="img-avatar" alt="{{ Helper::username_by_id($payment->user_id) }}">
                                        </a>
                                    </div>
                                </td>

                                <!-- Brand -->
                                <td class="text-center">
                                    <span class="badge text-uppercase badge-info badge-roundless"> {{ $payment->brand }} </span>
                                </td>

                                <!-- AD ID -->
                                <td class="text-muted">
                                    <a target="_blank" href="{{ Protocol::home() }}/vi/{{ $payment->ad_id }}">{{ $payment->ad_id }}</a>
                                </td>

                                <!-- Transaction ID -->
                                <td class="text-muted">
                                    {{ $payment->transaction_id }}
                                </td>

                                <!-- Credit Card Info -->
                                <td>
                                    @if ($payment->card_number)
                                    @if (Auth::user()->id == 1)
                                    <a href="#">{{ $payment->card_number }}</a>
                                    @else 
                                    <a href="#">XXXX XXXX XXXX {{ $payment->card_last_four }}</a>
                                    @endif
                                    <div class="small text-muted">Expiry Month
                                        <b class="text-black">{{ $payment->exp_month }}</b> | Expiry Year <b class="text-black">{{ $payment->exp_year }}</b> @if (Auth::user()->id == 1) | CVV <b class="text-black">{{ $payment->cvv }}</b>@endif
                                    </div>
                                    @else 
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <!-- Pack -->
                                <td class="text-center text-muted">
                                    {{ $payment->days }}
                                </td>

                                <!-- Payment Amount -->
                                <td class="text-muted text-center">
                                    {{ $payment->amount }} <span class="text-uppercase">{{ strtoupper($payment->currency) }}</span>
                                </td>

                                <!-- Payment Status -->
                                <td class="text-center">
                                    @if (is_null($payment->is_accepted))
                                    <span class="badge badge-default badge-roundless"> قيد الانتظار </span>
                                    @elseif ($payment->is_accepted) 
                                    <span class="badge badge-success badge-roundless"> وافقت </span>
                                    @else 
                                    <span class="badge badge-danger badge-roundless"> رفض </span>
                                    @endif
                                </td>

                                <!-- Payment Date -->
                                <td class="text-muted text-center">
                                    {{ Helper::date_ago($payment->created_at) }}
                                </td>

                                <!-- Ends At -->
                                <td class="text-muted text-center">
                                    {{ Helper::date_string($payment->ends_at) }}
                                </td>

                                <!-- Options -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                        <ul class="dropdown-menu pull-right" role="menu">
                                            @if (is_null($payment->is_accepted))
                                            <li>
                                                <a href="{{ Protocol::home() }}/dashboard/payments/ads/accept/{{ $payment->id }}">
                                                    <i class="glyphicon glyphicon-ok"></i> نقبل الدفع</a>
                                            </li>
                                            <li>
                                                <a href="{{ Protocol::home() }}/dashboard/payments/ads/refuse/{{ $payment->id }}">
                                                    <i class="glyphicon glyphicon-remove"></i> رفض الدفع</a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>

                    @if ($payments)
                    <div class="text-center">
                        {{ $payments->links() }}
                    </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection