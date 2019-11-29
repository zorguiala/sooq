@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('head')

{!! Charts::assets() !!}

@endsection

@section ('content')

<!-- Ad Stats -->
<div class="row">

	@include (Theme::get().'.account.include.sidebar')

	<!-- Ad stats -->
	<div class="col-md-9">

		<div class="panel">

			<div class="panel-body">

				<div class="row">
					
					<!-- Ad Visits -->
					<div class="col-md-12" style="border: 1px solid #ededed;padding: 10px;margin-bottom: 20px;">
						{!! $visits->render() !!}
					</div>

					<!-- Countries -->
					<div class="col-md-12" style="border: 1px solid #ededed;padding: 10px;margin-bottom: 20px;">
						{!! $countries->render() !!}
					</div>

					<!-- Top Browsers -->
					<div class="col-md-6" style="border: 1px solid #ededed;padding: 10px;margin-bottom: 20px;">
						{!! $browsers->render() !!}
					</div>

					<!-- Top Platforms -->
					<div class="col-md-6" style="border: 1px solid #ededed;padding: 10px;margin-bottom: 20px;">
						{!! $platforms->render() !!}
					</div>

				</div>	
				
				<!-- Other Stats -->
				<div class="row">
					<div class="table-responsive" style="margin: 0px -10px;border-bottom: 1px solid #ddd;">
						<table class="table text-nowrap">
							<thead style="border-top: 1px solid #bbb;background-color: #f6f6f6;">
								<tr>
									<th>{{ Lang::get('ads/stats.lang_country') }}</th>
									<th class="col-md-2">{{ Lang::get('ads/stats.lang_state') }}</th>
									<th class="col-md-2">{{ Lang::get('ads/stats.lang_city') }}</th>
									<th class="col-md-2">{{ Lang::get('ads/stats.lang_device') }}</th>
									<th class="col-md-2">{{ Lang::get('ads/stats.lang_referrer') }}</th>
									<th class="col-md-2">{{ Lang::get('ads/stats.lang_referrer_keyword') }}</th>
									<th class="col-md-2">{{ Lang::get('ads/stats.lang_last_visit') }}</th>
								</tr>
							</thead>
							<tbody>
								
								@if($other_stats)
								@foreach ($other_stats as $s)
								<tr>
									
									<!-- Country -->
									<td class="text-center">
										<img data-src="{{ Protocol::home() }}/content/assets/front-end/images/flags/{{ $s->country }}.png" class="lozad" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Countries::country_name($s->country) }}">
									</td>

									<!-- Region -->
									<td>
										@if ($s->region)
										<span class="text-muted">{{ $s->region }}</span>
										@else
										<span class="text-muted">Unknown Region</span>
										@endif
									</td>

									<!-- City -->
									<td>
										@if ($s->city)
										<span class="text-muted">{{ $s->city }}</span>
										@else
										<span class="text-muted">Unknown City</span>
										@endif
									</td>

									<!-- Device -->
									<td class="text-muted">
										@if ($s->isPhone)
										<span class="label label-danger heading-text">{{ Lang::get('badges.lang_phone') }}</span>
										@else
										<span class="label label-danger heading-text">{{ Lang::get('badges.lang_desktop') }}</span>
										@endif
									</td>

									<!-- Referrer -->
									<td>
										@if ($s->referrer)
										<a class="text-muted" href="{{ $s->referrer }}" target="_blank">{{ $s->referrer }}</a>
										@else
										N/A
										@endif
									</td>

									<!-- Referrer Keyword -->
									<td class="text-muted">
										@if ($s->referrer_keyword)
										{{ $s->referrer_keyword }}
										@else 
										N/A
										@endif
									</td>

									<!-- Last visit -->
									<td class="text-muted">{{ Helper::date_ago($s->updated_at) }}</td>

								</tr>
								@endforeach
								@endif

							</tbody>
						</table>
					</div>

					@if (count($other_stats))
					<div class="text-center mt-20">
						{{ $other_stats->links() }}
					</div>
					@endif

				</div>
				
			</div>
		</div>

	</div>

</div>

@endsection