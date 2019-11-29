@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
	
	<div class="col-md-8">
		
		<div class="panel">

			<div class="panel-body">
				
				<ul class="media-list chat-list content-group">
					<li class="media date-step">
						<span>"{{ $ad->title }}" {{ Lang::get('update_three.lang_all_reviews') }}</span>
					</li>

					@if ($reviews)
					@foreach ($reviews as $review)
					<li class="media">
						<div class="media-left">
							<a>
								<img data-src="{{ Profile::user_picture($review->user_id) }}" class="lozad img-circle img-md" alt="{{ Profile::full_name($review->user_id) }}">
							</a>
						</div>

						<div class="media-body">
							<div class="media-content mb-10">{{ $review->comment }}</div>
							<span class="media-annotation mt-20 mr-10">{{ Profile::full_name($review->user_id) }}</span>
							<span class="media-annotation mt-20 dotted mr-10">
								@switch ($review->rating)
									@case(1)
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										@break

									@case(2)
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										@break

									@case(3)
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										@break

									@case(4)
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-grey-300"></i>
										@break

									@case(5)
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										<i class="icon-star-full2 text-size-base text-warning-300"></i>
										@break

									@default
									'N/A'

								@endswitch
							</span>
							<span class="media-annotation mt-20 dotted mr-10">{{ Helper::date_ago($review->created_at) }}</span>
						</div>
					</li>
					@endforeach
					@endif

				</ul>

			</div>
		</div>

	</div>

	<div class="col-md-4">
			
		<div class="content-group">
			<div class="panel-body bg-blue border-radius-top text-center lozad" data-background-image="{{ Helper::store_cover($store->username) }}" style=" background-size: contain;">
				<div class="content-group-sm">
					<h5 class="text-semibold no-margin-bottom">
						{{ $store->title }}
					</h5>

					<span class="display-block">{{ $store->username }}</span>
				</div>

				<a href="{{ Protocol::home() }}/store/{{ $store->username }}" class="display-inline-block content-group-sm">
					<img data-src="{{ $store->logo }}" class="lozad img-circle img-responsive" alt="" style="width: 120px; height: 120px;">
				</a>

				<ul class="list-inline no-margin-bottom">

					@php
					$style = 'background-color: white;
						    color: #5f5d5d;
						    border-radius: 100%;
						    height: 35px;
						    width: 35px;
						    vertical-align: middle;
						    padding-top: 7px;
						    padding-right: 11px;
						    padding-left: 10px;';
					@endphp

					@if (!is_null($store->fb_page))
					<li><a style="{{ $style }}" target="_blank" href="{{ $store->fb_page }}" class="btn bg-transparent btn-rounded btn-icon legitRipple"><i class="icon-facebook"></i></a></li>
					@endif

					@if (!is_null($store->tw_page))
					<li><a style="{{ $style }}" target="_blank" href="{{ $store->tw_page }}" class="btn bg-transparent btn-rounded btn-icon legitRipple"><i class="icon-twitter"></i></a></li>
					@endif

					@if (!is_null($store->go_page))
					<li><a style="{{ $style }}" target="_blank" href="{{ $store->go_page }}" class="btn bg-transparent btn-rounded btn-icon legitRipple"><i class="icon-google-plus"></i></a></li>
					@endif

				</ul>
			</div>
		</div>

	</div>

</div>

@endsection