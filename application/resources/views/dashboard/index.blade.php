@extends ('dashboard.layout.app')

@section ('content')

<!-- Quick stats -->
<div class="row">

    <div class="col-md-12">
        <!-- Session Messages -->
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }} 
        </div>
        @endif
    </div>

	<!-- Total Ads -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-bullhorn"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_ads }}</span>
                </div>
                <div class="desc"> كل الاعلانات </div>
            </div>
        </a>
    </div>

    <!-- Total Categories -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-list"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_cats }}</span>
                </div>
                <div class="desc"> كل الاقسام </div>
            </div>
        </a>
    </div>

    <!-- Total Stores -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-home"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_stores }}</span>
                </div>
                <div class="desc"> كل المتاجر </div>
            </div>
        </a>
    </div>

    <!-- Total Users -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_users }}</span>
                </div>
                <div class="desc"> كل الزوار </div>
            </div>
        </a>
    </div>

    <!-- Total Messages -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_messages }}</span>
                </div>
                <div class="desc"> كل الرسائل </div>
            </div>
        </a>
    </div>

    <!-- Total Comments -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_comments }}</span>
                </div>
                <div class="desc"> كل التعليقات </div>
            </div>
        </a>
    </div>

    <!-- Total Views -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-eye"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_views }}</span>
                </div>
                <div class="desc"> كل المشاهدات </div>
            </div>
        </a>
    </div>

    <!-- Total Pages -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-file"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_pages }}</span>
                </div>
                <div class="desc"> كل الصفحات </div>
            </div>
        </a>
    </div>

</div>

<!-- Ads Visits -->
<div class="row">
    <div class="col-lg-8">
    
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">مجموع الزيارات حسب اليوم</span>
                </div>
            </div>

            <div class="portlet-body" style="text-align: center;">
<iframe width="639.5" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQYsxVgd_XwdE01WSRdE-fpOsNo0eSO3X9NFKUu77GYoicwPEuM780zsVXxpJsEW-qUUtMrXXKKwa81/pubchart?oid=2115357709&amp;format=interactive" ></iframe>
            </div>
        </div>

    </div>    <div class="col-lg-4">
    
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">مجموع الزيارات حسب المتصفح</span>
                </div>
            </div>

            <div class="portlet-body" style="text-align: center;">
<iframe width="285" height="371.5" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQYsxVgd_XwdE01WSRdE-fpOsNo0eSO3X9NFKUu77GYoicwPEuM780zsVXxpJsEW-qUUtMrXXKKwa81/pubchart?oid=1042861325&amp;format=interactive"></iframe>
            </div>
        </div>

    </div>
    <div class="col-lg-6">
    
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">  زوار جدد</span>
                </div>
            </div>

            <div class="portlet-body" style="text-align: center;">
<iframe width="499" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQYsxVgd_XwdE01WSRdE-fpOsNo0eSO3X9NFKUu77GYoicwPEuM780zsVXxpJsEW-qUUtMrXXKKwa81/pubchart?oid=436486040&amp;format=interactive" ></iframe>
            </div>
        </div>

    </div>
    <div class="col-lg-6">
    
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">مجموع الزيارات حسب الأجهزة</span>
                </div>
            </div>

            <div class="portlet-body" style="text-align: center;">
            <iframe width="478.5" height="371" seamless frameborder="0" scrolling="no" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQYsxVgd_XwdE01WSRdE-fpOsNo0eSO3X9NFKUu77GYoicwPEuM780zsVXxpJsEW-qUUtMrXXKKwa81/pubchart?oid=1411753845&amp;format=interactive"></iframe>
            </div>
        </div>

    </div>

</div>

<!-- users and stores -->
<div class="row">
	
    <!-- users -->
	<div class="col-md-6">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">أحدث المستخدمين</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="general-item-list">
                    @if($latest_users)
                    @foreach($latest_users as $user)
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">
                                <img class="item-pic rounded" src="{{ Profile::user_picture($user->id) }}">
                                <a href="{{ Protocol::home() }}/dashboard/users/details/{{ $user->username }}" class="item-name primary-link">{{ $user->first_name }} {{ $user->last_name }}</a>
                                <span class="item-label">{{ Helper::date_ago($user->created_at) }}</span>
                            </div>
                            @if($user->status)
                            <span class="item-status">
                                <span class="badge badge-empty badge-success"></span> Active
                            </span>
                            @else
                            <span class="item-status">
                                <span class="badge badge-empty badge-danger"></span> Pending
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

	</div>

    <!-- stores -->
    <div class="col-md-6">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">أحدث المتاجر</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="general-item-list">
                    @if($latest_stores)
                    @foreach($latest_stores as $store)
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">
                                <img class="item-pic rounded" src="{{ $store->logo }}">
                                <a href="{{ Protocol::home() }}/dashboard/stores/details/{{ $store->username }}" class="item-name primary-link">{{ $store->username }}</a>
                                <span class="item-label">{{ Helper::date_ago($store->created_at) }}</span>
                            </div>
                            @if ($store->status)
                            <span class="item-status">
                                <span class="badge badge-empty badge-success"></span> فتح
                            </span>
                            @else
                            <span class="item-status">
                                <span class="badge badge-empty badge-danger"></span> غلق
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

    </div>

</div>
<?php
/*
function print_mem()
{
   
   $mem_usage = memory_get_usage();
   
   
   $mem_peak = memory_get_peak_usage();

   echo 'The script is now using: <strong>' . round($mem_usage / 1024) . 'KB</strong> of memory.<br>';
   echo 'Peak usage: <strong>' . round($mem_peak / 1024/1024) . 'MB</strong> of memory.<br><br>';
}
print_mem();
$memory_limit = ini_get('memory_limit');



echo '<val>' . $memory_limit . '</val>';

*/?>
@endsection