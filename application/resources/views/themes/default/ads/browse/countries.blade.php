@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
	<div class="col-md-12">
		
		<!-- Browse By Countries -->
		<div class="spec ">
            <h3>{{ Lang::get('update_two.lang_browse_by_countries') }}</h3>
            <div class="ser-t">
                <b></b>
                <span><i></i></span>
                <b class="line"></b>
            </div>
        </div>


        @if (count($countries))
        <!-- Browse By Country -->

        <div class="row cat_single_wrap">

            @foreach ($countries as $country_flag)
            <div class="col-md-2 text-center">

                <div class="cat_single">
                    <div class="cat_single_bg">
                        <div class="overlay_color panel" style="transform: skewX(-6deg);">
                        </div>
                    </div>
                    <div class="cat_single_content">
                        <a href="{{ Protocol::home() }}/browse/country/{{ $country_flag->sortname }}" style="color: rgb(255, 255, 255);">
                            <img data-src="{{ Protocol::home() }}/content/assets/front-end/images/flags/large/{{ $country_flag->sortname }}.png" class="lozad">
                            <span class="cat_title">{{ $country_flag->name }}</span>
                        </a>
                    </div>
                </div>

            </div>
            @endforeach

        </div>

        @endif

	</div>
</div>

@endsection