@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
	
	<!-- Category Ads -->
	<div class="col-md-9">

		<!-- Filter -->
		<div class="row">
			<div class="col-md-12">
				<div class="navbar navbar-default navbar-xs navbar-component">
					<ul class="nav navbar-nav no-border visible-xs-block">
						<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
					</ul>

					<div class="navbar-collapse collapse" id="navbar-filter">
						<p class="navbar-text">{{ Lang::get('category.lang_filter') }}</p>
						<ul class="nav navbar-nav">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort-time-asc position-left"></i> {{ Lang::get('category.lang_by_date') }} <span class="caret"></span></a>
								<ul class="dropdown-menu" style="margin-top: -32px;">
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}">{{ Lang::get('category.lang_show_all') }}</a></li>
									<li class="divider"></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?date=today">{{ Lang::get('category.lang_today') }}</a></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?date=yesterday">{{ Lang::get('category.lang_yesterday') }}</a></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?date=week">{{ Lang::get('category.lang_week') }}</a></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?date=month">{{ Lang::get('category.lang_month') }}</a></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?date=year">{{ Lang::get('category.lang_year') }}</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort-amount-desc position-left"></i> {{ Lang::get('category.lang_by_status') }} <span class="caret"></span></a>
								<ul class="dropdown-menu" style="margin-top: -32px;">
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}">{{ Lang::get('category.lang_show_all') }}</a></li>
									<li class="divider"></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?status=featured">{{ Lang::get('category.lang_featured') }}</a></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?status=normal">{{ Lang::get('category.lang_not_featured') }}</a></li>
								</ul>
							</li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-sort position-left"></i> {{ Lang::get('category.lang_by_condition') }} <span class="caret"></span></a>
								<ul class="dropdown-menu" style="margin-top: -32px;">
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}">{{ Lang::get('category.lang_show_all') }}</a></li>
									<li class="divider"></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?condition=used">{{ Lang::get('category.lang_used') }}</a></li>
									<li><a href="{{ Protocol::home() }}/category/{{ $parent }}/{{ $sub }}?condition=new">{{ Lang::get('category.lang_new') }}</a></li>
								</ul>
							</li>
						</ul>

						<div class="navbar-right text-right">
							<a href="{{ Protocol::home() }}/random" class="text-muted text-uppercase" style="line-height: 47px;">{{ Lang::get('search.lang_random') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		

		<!-- Category Ads -->
		<div class="row">

            @if (count($ads))
            @foreach ($ads as $ad)

            <div class="col-md-4">

                <div class="card card-blog">
                    <ul class="tags">
                        @if ($ad->is_featured)
                        <li>{{ Lang::get('home.lang_featured') }}</li>
                        @endif

                        @if ($ad->is_oos)
                        <li class="oos">{{ Lang::get('update_three.lang_out_of_stock') }}</li>
                        @endif
                    </ul>
                    <div class="card-image">
                        <a href="{{ Protocol::home() }}/listing/{{ $ad->slug }}" {{ !is_null($ad->affiliate_link) ? 'target="_blank"' : '' }}>
                            <div class="img card-ad-cover lozad" data-background-image="{{ EverestCloud::getThumnail($ad->ad_id, $ad->images_host) }}" title="{{ $ad->title }}"></div>
                        </a>
                    </div>
                    <div class="card-block">
                        <h5 class="card-title">
                            <a href="{{ Protocol::home() }}/listing/{{ $ad->slug }}">{{ $ad->title }}</a>
                        </h5>
                        <div class="card-footer">
                            <div id="price">
                                @if (!is_null($ad->regular_price))
                                <span class="price price-old"> {{ Helper::getPriceFormat($ad->regular_price, $ad->currency) }}</span>
                                @endif
                                <span class="price price-new"> {{ Helper::getPriceFormat($ad->price, $ad->currency) }}</span>
                            </div>
                            <div class="author">
                                <div class="card__avatar"><a href="{{ Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#' }}" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="{{ Profile::picture($ad->user_id) }}" alt="{{ Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id) }}" class="lozad avatar" width="40" height="40">@if (Profile::hasStore($ad->user_id))<i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update_two.lang_verified_account') }}"></i>@endif</a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @endforeach
            <div class="col-md-12 text-center mb-20">
            	{{ $ads->links() }}
            </div>
            @else 
            <div class="col-md-12">
	            <div class="alert bg-info alert-styled-left">
					<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
					@lang ('return/info.lang_nothing_to_show')
			    </div>
		    </div>
            @endif

        </div>

	</div>

	<!-- Right Side -->
	<div class="col-md-3">
		
		@if (count($stores) > 0)
		
		<div class="panel panel-flat">

			<div class="panel-body">
				<ul class="media-list">
					@foreach ($stores as $store)
					<li class="media">
						<div class="media-left media-middle">
							<a href="{{ Protocol::home() }}/store/{{ $store->username }}">
								<img data-src="{{ $store->logo }}" class="img-circle img-md lozad" alt="{{ $store->title }}">
							</a>
						</div>

						<div class="media-body">
							<div class="media-heading text-semibold">{{ $store->title }}</div>
							<span class="text-muted">{{ $store->username }}</span>
						</div>

						<div class="media-right media-middle">
							<ul class="icons-list text-nowrap">
		                    	<li class="dropdown">
		                    		<a target="_blank" href="{{ Protocol::home() }}/store/{{ $store->username }}"><i class="icon-new-tab"></i></a>
		                    	</li>
	                    	</ul>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>

		@endif

		@if (Helper::ifCanSeeAds())
		<!-- Advertisement -->
		<div class="advertisment">
			{!! Helper::advertisements()->ad_sidebar !!}
		</div>
		@endif

		@if (Helper::ifCanSeeAds())
		<!-- Advertisement -->
		<div class="advertisment" style="margin-top: 20px">
			{!! Helper::advertisements()->ad_sidebar !!}
		</div>
		@endif

	</div>

</div>

@endsection