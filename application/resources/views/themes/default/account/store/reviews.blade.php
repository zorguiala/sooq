@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Store Reviews -->
<div class="row">
		
	<!-- Session Messages -->
	<div class="col-md-12">
		@if (Session::has('success'))
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			{{ Session::get('success') }}
	    </div>
	    @endif
	    @if (Session::has('error'))
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			{{ Session::get('error') }}
	    </div>
	    @endif
	</div>

	@include (Theme::get().'.account.include.sidebar')

	<div class="col-md-9">

		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>{{ Lang::get('table.lang_ad_details') }}</th>
							<th class="col-md-2">{{ Lang::get('update_three.lang_review_by') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('update_three.lang_rating') }}</th>
							<th class="col-md-2">{{ Lang::get('update_three.lang_comment') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('update_three.lang_status') }}</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if ($r)
						@foreach ($r as $review)
						<tr>

							<!-- Ad Details -->
							<td>
								<div class="media-left media-middle">
									<a href="{{ Protocol::home() }}/vi/{{ $review->ad_id }}"><img data-src="{{ Protocol::home() }}/application/public/uploads/images/{{ $review->ad_id }}/previews/preview_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a href="{{ Protocol::home() }}/vi/{{ $review->ad_id }}" class="text-default text-semibold">{{ $review->ad_id }}</a></div>
									<div class="text-muted text-size-small">
										{{ Helper::date_ago($review->created_at) }}
									</div>
								</div>
							</td>

							<!-- Review By -->
							<td class="text-muted">
								{{ Profile::full_name($review->user_id) }}
							</td>

							<!-- Rating -->
							<td class="text-center">
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
							</td>

							<!-- Comment -->
							<td class="text-muted">
								{{ $review->comment }}
							</td>

							<!-- Status -->
							<td class="text-center">
								@if ($review->is_approved)
								<span class="label label-success">{{ Lang::get('update_three.lang_active') }}</span>
								@else
								<span class="label label-danger">{{ Lang::get('update_three.lang_pending') }}</span>
								@endif
							</td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									@if ($review->is_approved)
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update_three.lang_hide_review') }}" href="{{ Protocol::home() }}/account/store/reviews/hide/{{ $review->id }}"><i class="icon-cross2"></i></a>
									</li>
									@else
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('update_three.lang_show_review') }}" href="{{ Protocol::home() }}/account/store/reviews/publish/{{ $review->id }}"><i class="icon-checkmark3"></i></a>
									</li>
									@endif
								</ul>
							</td>

						</tr>
						@endforeach
						@endif
					</tbody>
				</table>

				@if ($r)
				<div class="text-center pb-15 pt-15">
					{{ $r->links() }}
				</div>
				@endif

			</div>

		</div>

	</div>

</div>

@endsection