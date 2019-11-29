@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- account ads -->
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
	
	<!-- Account Ads -->
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
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_ends_at') }}</th>
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
									<div class=""><a target="_blank" href="{{ Protocol::home() }}/vi/{{ $ad->ad_id }}" class="text-default text-semibold text-dots">{{ $ad->title }}</a></div>
									<div class="text-muted text-size-small">
										@if ($ad->status)
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_active') }}"></span>
										@else 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_pending') }}"></span>
										@endif
										{{ Helper::date_ago($ad->created_at) }}
									</div>
								</div>
							</td>

							<!-- Ad Category -->
							<td class="text-center">
								<a class="text-muted" href="{{ Helper::get_category($ad->category, true) }}" target="_blank">{{ Helper::get_category($ad->category) }}</a>
							</td>

							<!-- Ad Vists -->
							<td class="text-center"><span class="text-success-600"><i class="icon-stats-growth2 position-left"></i> {{ number_format($ad->views) }}</span></td>

							<!-- Ad Price -->
							<td class="text-center"><h6 class="text-semibold">{{ Helper::getPriceFormat($ad->price, $ad->currency) }}</h6></td>

							<!-- Ad Status -->
							<td class="text-center">
								@if ($ad->is_archived)
								<span class="label bg-danger">{{ Lang::get('badges.lang_archived') }}</span>
								@elseif ($ad->is_featured)
								<span class="label bg-warning">{{ Lang::get('badges.lang_featured') }}</span>
								@else
								<span class="label bg-blue">{{ Lang::get('badges.lang_normal') }}</span>
								@endif
							</td>

							<!-- Ends At -->
							<td class="text-center text-muted">
								{{ Helper::dateToFormatted($ad->ends_at) }}
							</td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">

											<!-- Edit Ad -->
											<li><a href="{{ Protocol::home() }}/account/ads/edit/{{ $ad->ad_id }}"><i class="icon-pencil4"></i> {{ Lang::get('options.lang_edit_ad') }}</a></li>

											<!-- Delete Ad -->
											<li><a href="{{ Protocol::home() }}/account/ads/delete/{{ $ad->ad_id }}"><i class="icon-trash-alt"></i> {{ Lang::get('options.lang_move_to_trash') }}</a></li>

											<!-- Upgrade Ad -->
											<li><a href="{{ Protocol::home() }}/account/ads/upgrade/{{ $ad->ad_id }}"><i class="icon-chess-queen"></i> {{ Lang::get('options.lang_upgrade_ad') }}</a></li>

											@if (!$ad->is_archived)
											<!-- Archive Ad -->
											<li><a href="{{ Protocol::home() }}/account/ads/archive/{{ $ad->ad_id }}"><i class="icon-archive"></i> {{ Lang::get('options.lang_archive_ad') }}</a></li>
											@endif

											<!-- Stats Ad -->
											<li><a href="{{ Protocol::home() }}/account/ads/stats/{{ $ad->ad_id }}"><i class="icon-stats-bars2"></i> {{ Lang::get('options.lang_statistics') }}</a></li>
											
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif

					</tbody>
				</table>

				@if ($ads)
				<div class="text-center pb-15">
					{{ $ads->links() }}
				</div>
				@endif

			</div>
		</div>

	</div>

</div>

@endsection