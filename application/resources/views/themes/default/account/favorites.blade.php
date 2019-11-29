@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- account favorites ads -->
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
	
	<!-- Account Favorites Ads -->
	<div class="col-md-9">
		
		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>{{ Lang::get('table.lang_ad_details') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_category') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_visits') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_price') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_status') }}</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>
					<tbody>

						@if ($ads)
						@foreach ($ads as $ad)
						<tr>

							<!-- Ad Details -->
							<td>
								<div class="media-left media-middle">
									<a target="_blank" href="{{ Protocol::home() }}/vi/{{ $ad->ad_id }}"><img data-src="{{ Protocol::home() }}/application/public/uploads/images/{{ $ad->ad_id }}/thumbnails/thumbnail_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a target="_blank" href="{{ Protocol::home() }}/vi/{{ $ad->ad_id }}" class="text-default text-semibold text-dots">{{ Helper::ad_details($ad->ad_id, 'title') }}</a></div>
									<div class="text-muted text-size-small">
										@if (Helper::ad_status($ad->ad_id))
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_active') }}"></span>
										@else 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_pending') }}"></span>
										@endif
										{{ Helper::date_ago($ad->created_at) }}
									</div>
								</div>
							</td>

							<!-- Ad Category -->
							<td class="text-center"><span class="text-muted">{{ Helper::ad_details($ad->ad_id, 'category') }}</span></td>

							<!-- Ad Vists -->
							<td class="text-center"><span class="text-success-600"><i class="icon-stats-growth2 position-left"></i> {{ Helper::ad_details($ad->ad_id, 'views') }}</span></td>

							<!-- Ad Price -->
							<td class="text-center"><h6 class="text-semibold">{{ Helper::ad_details($ad->ad_id, 'price') }}</h6></td>

							@if (Helper::ad_details($ad->ad_id, 'is_featured'))
							<td class="text-center"><span class="label bg-warning">{{ Lang::get('badges.lang_featured') }}</span></td>
							@elseif (Helper::ad_details($ad->ad_id, 'is_archived'))
							<td class="text-center"><span class="label bg-danger">{{ Lang::get('badges.lang_archived') }}</span></td>
							@else 
							<td class="text-center"><span class="label bg-info">{{ Lang::get('badges.lang_normal') }}</span></td>
							@endif

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_remove_from_list') }}" href="{{ Protocol::home() }}/account/favorite/ads/delete/{{ $ad->ad_id }}"><i class="icon-bin"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif

					</tbody>
				</table>

				@if ($ads)
				<div class="text-center mb-15 mt-15">
					{{ $ads->links() }}
				</div>
				@endif

			</div>
		</div>

	</div>

</div>

@endsection