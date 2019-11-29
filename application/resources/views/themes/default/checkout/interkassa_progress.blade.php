@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
	<div class="col-md-6" style="margin: 0 auto !important;float: none;">

		<!-- Session Messages -->
		@if (Session::has('error'))
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			{{ Session::get('error') }}
	    </div>
	    @endif

	    @if (Session::has('success'))
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			{{ Session::get('success') }}
	    </div>
	    @endif
		
		<form action="{{ $payment->getFormAction() }}" method="POST">

			{{ csrf_field() }}

			<input type="hidden" name="ik_suc_m" value="POST">

			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
					<h5 class="content-group">{{ Lang::get('upgrade.lang_upgrade_your_account') }} <small class="display-block">{{ config('interkassa.account_price') }} {{ config('interkassa.currency') }} {{ Lang::get('update.lang_per_day') }}</small></h5>
				</div>


				@foreach ($payment->getFormValues() as $field => $value)

				<div class="form-group {{ $errors->has($field) ? 'has-error' : '' }}">
					<input type="hidden" class="form-control" name="{{ $field }}" value="{{ $value }}">
					@if ($errors->has($field))
					<span class="help-block">{{ $errors->first($field) }}</span>
					@endif
				</div>

				@endforeach

				<input type="hidden" name="ik_suc_u" value="{{ Protocol::home() }}/checkout/interkassa/callback">
				<input type="hidden" name="ik_fal_u" value="{{ Protocol::home() }}/checkout/interkassa/callback">
				<input type="hidden" name="ik_pnd_u" value="{{ Protocol::home() }}/checkout/interkassa/callback">

				<div class="form-group checkout-btn">
					<button type="submit" class="btn bg-default-400 btn-block">{{ Lang::get('upgrade.lang_continue') }}</button>
				</div>
				<span class="help-block text-center no-margin">{{ Lang::get('upgrade.lang_terms') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('upgrade.lang_terms_condition') }}</a></span>
			</div>

	</div>
</div>

@endsection