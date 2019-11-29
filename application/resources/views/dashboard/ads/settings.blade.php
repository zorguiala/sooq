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
                    <span class="caption-subject font-blue bold uppercase">إعدادات الإعلانات</span>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-hover table-outline m-b-0 hidden-sm-down">
                    <thead class="thead-default">
                        <tr>
                            <th class="text-center"><i class="icon-link"></i></th>
                            <th>Title</th>
                            <th class="text-center">قسم</th>
                            <th class="text-center">السعر</th>
                            <th class="text-center">متميز</th>
                            <th class="text-center">ارشيف</th>
                            <th class="text-center">ينتهي عند</th>
                            <th class="text-center">خيارات</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($ads)
                        @foreach ($ads as $ad)
                        <tr>
                            
                            <!-- Ad Image -->
                            <td class="text-center">
                                <div class="avatar">
                                    <img src="{{ Protocol::home() }}/application/public/uploads/images/{{ $ad->ad_id }}/thumbnails/thumbnail_0.jpg" class="img-avatar" alt="{{ $ad->title }}">
                                    @if ($ad->status)
                                    <span class="avatar-status tag-success tooltips" data-container="body" data-placement="top" data-original-title="Active Ad"></span>
                                    @else
                                    <span class="avatar-status tag-danger tooltips" data-container="body" data-placement="top" data-original-title="Pending Active"></span>
                                    @endif
                                </div>
                            </td>

                            <!-- Ad Info -->
                            <td>
                                <a target="_blank" href="{{ Protocol::home() }}/listing/{{ $ad->slug }}" class="text-dots tooltips" data-container="body" data-placement="top" data-original-title="{{ $ad->title }}">{{ $ad->title }}</a>
                                <div class="small text-muted">
                                    <a class="text-muted text-uppercase" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($ad->user_id) }}">{{ Helper::username_by_id($ad->user_id) }}</a> | {{ Helper::date_ago($ad->created_at) }}
                                </div>
                            </td>

                            <!-- Ad Category -->
                            <td class="text-center">
                                <a target="_blank" href="{{ Helper::get_category($ad->category, true) }}">
                                    {{ Helper::get_category($ad->category) }}
                                </a>
                            </td>

                            <!-- Ad Price -->
                            <td class="text-center text-muted">
                                {{ Helper::getPriceFormat($ad->price, $ad->currency) }}
                            </td>

                            <!-- Is a featured Ad -->
                            <td class="text-center">
                                @if ($ad->is_featured)
                                <span class="badge badge-warning badge-roundless"> متميز </span>
                                @else 
                                <span class="badge badge-default badge-roundless"> غير متميز </span>
                                @endif
                            </td>

                            <!-- Is a Archived Ad -->
                            <td class="text-center">
                                @if ($ad->is_archived)
                                <span class="badge badge-danger badge-roundless"> أرشفة </span>
                                @else 
                                <span class="badge badge-info badge-roundless"> لم يأرشفة </span>
                                @endif
                            </td>

                            <!-- Ad Ends at -->
                            <td class="text-center text-muted">
                                {{ Helper::date_string($ad->ends_at) }}
                            </td>

                            <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/edit/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/stats/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-stats"></i> إحصائيات الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/comments/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-comment"></i> تعليقات الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/messages/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-envelope"></i> رسائل الإعلان</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/offers/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-usd"></i> عروض الإعلان</a>
                                        </li>
                                        @if ($ad->status)
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/inactive/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-remove"></i> عروض الإعلان</a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/ads/active/{{ $ad->ad_id }}">
                                                <i class="glyphicon glyphicon-ok"></i> نشر الاعلان</a>
                                        </li>
                                        @endif
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/ads/delete/{{ $ad->ad_id }}">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف الإعلان</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>

                @if (count($ads) > 0)
                <div class="text-center">
                    {{ $ads->links() }}
                </div>
                @endif

            </div>
        </div>

    </div>

</div>

@endsection