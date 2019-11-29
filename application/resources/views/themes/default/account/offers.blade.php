@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- account offers -->
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

	<!-- Account Offers -->
	<div class="col-md-9">

		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>{{ Lang::get('table.lang_ad_details') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_offer_by') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_offer_price') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_status') }}</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>
						@if ($offers)
						@foreach ($offers as $offer)
						<tr>

							<!-- Ad Details -->
							<td>
								<div class="media-left media-middle">
									<a href="{{ Protocol::home() }}/vi/{{ $offer->ad_id }}"><img data-src="{{ Protocol::home() }}/application/public/uploads/images/{{ $offer->ad_id }}/previews/preview_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a href="{{ Protocol::home() }}/vi/{{ $offer->ad_id }}" class="text-default text-semibold">{{ $offer->ad_id }}</a></div>
									<div class="text-muted text-size-small">
										@if (Helper::ad_status($offer->ad_id))
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_active') }}"></span>
										@else 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_pending') }}"></span>
										@endif
										{{ Helper::date_ago($offer->created_at) }}
									</div>
								</div>
							</td>

							<!-- Offer By -->
							<td class="text-center"><span class="text-muted">{{ Profile::full_name($offer->offer_by) }}</span></td>

							<!-- Offer Price -->
							<td class="text-center"><h6 class="text-semibold">{{ Helper::ad_details($offer->ad_id, 'price') }}</h6></td>

							<!-- Offer status -->
							@if (is_null($offer->is_accepted))
							<td class="text-center"><span class="label bg-grey-300">{{ Lang::get('badges.lang_pending') }}</span></td>
							@elseif ($offer->is_accepted)
							<td class="text-center"><span class="label bg-success">{{ Lang::get('badges.lang_accepted') }}</span></td>
							@else 
							<td class="text-center"><span class="label bg-danger">{{ Lang::get('badges.lang_refused') }}</span></td>
							@endif

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											@if (is_null($offer->is_accepted))
											<li><a href="{{ Protocol::home() }}/account/offers/accept/{{ $offer->id }}"><i class="icon-checkmark3"></i> {{ Lang::get('options.lang_accept_offer') }}</a></li>
											<li><a href="{{ Protocol::home() }}/account/offers/refuse/{{ $offer->id }}"><i class="icon-blocked"></i> {{ Lang::get('options.lang_refuse_offer') }}</a></li>
											<li class="divider"></li>
											@endif
											<li><a href="{{ Protocol::home() }}/account/offers/delete/{{ $offer->id }}"><i class="icon-trash"></i> {{ Lang::get('options.lang_delete_offer') }}</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>

				@if ($offers)
				<div class="text-center pb-15 pt-15">
					{{ $offers->links() }}
				</div>
				@endif

			</div>

		</div>

	</div>

</div>

@endsection