@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Ads Upgrade Payments History -->
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
	
	<!-- Ads Payments -->
	<div class="col-md-9">
		
		<div class="panel panel-flat">

			@if (count($payments))
			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th class="text-center">{{ Lang::get('table.lang_brand') }}</th>
							<th>{{ Lang::get('table.lang_ad_details') }}</th>
							<th>{{ Lang::get('table.lang_transaction_id') }}</th>
							<th>{{ Lang::get('table.lang_credit_card') }}</th>
							<th class="text-center">{{ Lang::get('table.lang_amount') }}</th>
							<th class="text-center">{{ Lang::get('table.lang_status') }}</th>
							<th class="text-center">{{ Lang::get('table.lang_date') }}</th>
							<th class="text-center">{{ Lang::get('table.lang_ends_at') }}</th>
						</tr>
					</thead>
					<tbody>

						@if ($payments)
						@foreach ($payments as $payment)
						<tr>
							
							<!-- Brand -->
							<td class="text-center">
								<span class="label label-primary">{{ $payment->brand }}</span>
							</td>

							<!-- Brand -->
							<td>
								<a class="text-grey-800" target="_blank" href="{{ Protocol::home() }}/vi/{{ $payment->ad_id }}">{{ $payment->ad_id }}</a>
							</td>

							<!-- Transaction ID -->
							<td class="text-muted">
								{{ $payment->transaction_id }}
							</td>

							<!-- Credit Card -->
							<td class="text-muted">
								@if ($payment->card_number)
								XXXX XXXX XXXX {{ $payment->card_last_four }}
								@else 
								N/A
								@endif
							</td>

							<!-- Amount -->
							<td class="text-center text-muted">
								{{ $payment->amount }} {{ strtoupper($payment->currency) }}
							</td>

							<!-- status -->
							<td class="text-center">
								@if (is_null($payment->is_accepted))
								<span class="label label-default">{{ Lang::get('badges.lang_pending') }}</span>
								@elseif ($payment->is_accepted)
								<span class="label label-success">{{ Lang::get('badges.lang_accepted') }}</span>
								@else 
								<span class="label label-danger">{{ Lang::get('badges.lang_refused') }}</span>
								@endif
							</td>

							<!-- Payment Date -->
							<td class="text-center text-muted">
								{{ Helper::date_ago($payment->created_at) }}
							</td>

							<!-- Ends Date -->
							<td class="text-center text-muted">
								{{ Helper::date_string($payment->ends_at) }}
							</td>

						</tr>
						@endforeach
						@endif

					</tbody>
				</table>

				<div class="pr-20 pl-20 text-center">
					
					<div class="mt-20">
						{{ $payments->links() }}
					</div>

					<div class="mt-10  mb-20">
						<a href="{{ Protocol::home() }}/account/payments" class="label label-flat border-grey text-grey-600">{{ Lang::get('badges.lang_account_upgrade_history') }}</a>
					</div>
				</div>

			</div>
			@else
			<div class="panel-body">
				<div class="alert bg-info alert-styled-left" style="margin-top: 40px;">
					<button type="button" class="close" data-dismiss="alert">
					@lang ('return/info.lang_nothing_to_show')
			    </div>
			</div>
			@endif
		</div>

	</div>

</div>

@endsection