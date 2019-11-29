@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
    <div class="col-md-12">
        
        <!-- Country Ads -->
        <div class="spec ">
            <h3>{{ $country->name }}</h3>
            <div class="ser-t">
                <b></b>
                <span><i></i></span>
                <b class="line"></b>
            </div>
        </div>

        @if (count($ads))
        @foreach ($ads as $ad)

        <div class="col-md-3">

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
                            <div class="lozad img card-ad-cover" data-background-image="{{ EverestCloud::getThumnail($ad->ad_id, $ad->images_host) }}" title="{{ $ad->title }}"></div>
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
                                <div class="card__avatar"><a href="{{ Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#' }}" class="avatar__wrapper--verified avatar__wrapper avatar__wrapper--40"><img data-src="{{ Profile::picture($ad->user_id) }}" alt="{{ Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id) }}" class="avatar lozad" width="40" height="40">@if (Profile::hasStore($ad->user_id))<i class="icon-checkmark3" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update_two.lang_verified_account') }}"></i>@endif</a></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        @endforeach

        <!-- Pagination -->
        <div class="col-md-12 text-center mb-20">
            {{ $ads->links() }}
        </div>

        @else

        <!-- No Ads Right now -->
        <div class="alert bg-info alert-styled-left">
        @lang ('return/info.lang_nothing_to_show')
        </div>

        @endif

    </div>
</div>

@endsection