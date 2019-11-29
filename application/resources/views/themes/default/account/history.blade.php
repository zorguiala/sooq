@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Failed Login History -->
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
	
	<!-- Failed Login History -->
	<div class="col-md-9">
		
		<div class="panel">

			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>{{ Lang::get('table.lang_email_address') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_country') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_city') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_date') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_status') }}</th>
						</tr>
					</thead>
					<tbody>

						@if ($failed_login)
						@foreach ($failed_login as $login)
						<tr>

							<!-- Email Address -->
							<td class="text-muted">
								{{ $login->email }}
							</td>

							<!-- Country -->
							<td class="text-center"><span class="text-muted">{{ $login->country }}</span></td>

							<!-- City -->
							<td class="text-center"><span class="text-muted">{{ is_null($login->city) ? $login->city : 'N/A' }}</span></td>

							<!-- Date -->
							<td class="text-center text-muted">
								{{ Helper::date_ago($login->created_at) }}
							</td>

							<!-- Status -->
							<td class="text-center"><span class="label bg-danger">{{ Lang::get('badges.lang_failed') }}</span></td>

						</tr>
						@endforeach
						@endif

					</tbody>
				</table>
	
				@if ($failed_login)
				<div class="text-center mt-20 mb-20">
					{{ $failed_login->links() }}
				</div>
				@endif

			</div>

			@if (!$failed_login)
			<div class="alert alert-info alert-styled-left alert-bordered">
				<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
				@lang ('return/info.lang_nothing_to_show')
		    </div>
			@endif
		</div>

	</div>

</div>

@endsection