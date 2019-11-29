@extends ('dashboard.layout.app')

@section ('content')

<!-- Store Details -->
<div class="row">

    <div class="col-md-8">
        
        <div class="portlet light ">
            <!-- STAT -->
            <div class="row list-separated profile-stat">
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title"> {{ $ads_today }} </div>
                    <div class="uppercase profile-stat-text"> Today Ads </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title"> {{ $ads_month }} </div>
                    <div class="uppercase profile-stat-text"> Month </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title"> {{ $ads_year }} </div>
                    <div class="uppercase profile-stat-text"> Year </div>
                </div>
            </div>
            <!-- END STAT -->
            <div>
                <h4 class="profile-desc-title">About {{ $store->title }}</h4>
                <p class="profile-desc-text"> {!! nl2br($store->long_desc) !!} </p>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-globe"></i>
                    <a href="{{ $store->website }}" target="_blank">{{ $store->website }}</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-twitter"></i>
                    <a href="{{ $store->tw_page }}" target="_blank">Twitter صفحة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-facebook"></i>
                    <a href="{{ $store->fb_page }}" target="_blank">Facebook صفحة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-google-plus"></i>
                    <a href="{{ $store->go_page }}" target="_blank">Google صفحة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-youtube"></i>
                    <a href="{{ $store->yt_page }}" target="_blank">Youtube قناة</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-map-pin"></i>
                    <a href="#">{{ $store->address }}</a>
                </div>
            </div>
        </div>

    </div>
	
	<div class="col-md-4">

		<div class="profile-sidebar" style="width: 100%;">

            <div class="portlet light profile-sidebar-portlet ">

                <div class="profile-userpic">
                    <img src="{{ $store->logo }}" class="img-responsive" alt=""> </div>

                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $store->title }} </div>
                    <div class="profile-usertitle-job"> {{ $store->username }} </div>
                </div>

                <div class="profile-userbuttons" style="padding-bottom: 20px;">
                    <a target="_blank" href="{{ Protocol::home() }}/store/{{ $store->username }}" class="btn btn-circle red btn-sm">مشاهدة المتجر</a>
                </div>

            </div>
        </div>

	</div>

</div>

@endsection