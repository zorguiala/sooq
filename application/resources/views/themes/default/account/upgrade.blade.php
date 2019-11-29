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
		
		<form action="{{ Protocol::home() }}/upgrade" method="POST">

			{{ csrf_field() }}

			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
					<h5 class="content-group">{{ Lang::get('upgrade.lang_upgrade_your_account') }} <small class="display-block">{{ Lang::get('upgrade.lang_select_payment_method') }}</small></h5>
				</div>

				<!-- Payment Method -->
				<div class="form-group has-feedback has-feedback-left {{ $errors->has('method') ? 'has-error' : '' }}">
					<select data-placeholder="{{ Lang::get('upgrade.lang_select_payment_method') }}" class="select" name="method">
						<option></option>
						@if ($settings->is_paypal)
						<option value="paypal">PayPal</option>
						@endif

						@if ($settings->is_2checkout)
						<option value="2checkout">2Checkout</option>
						@endif

						@if ($settings->is_stripe)
						<option value="stripe">Stripe</option>
						@endif

						@if ($settings->is_mollie)
						<option value="mollie">Mollie</option>
						@endif

						@if ($settings->is_paystack)
						<option value="paystack">PayStack</option>
						@endif

						@if ($settings->is_paysafecard)
						<option value="paysafecard">PaySafeCard</option>
						@endif

						@if ($settings->is_razorpay)
						<option value="razorpay">RazorPay</option>
						@endif

						@if ($settings->is_barion)
						<option value="barion">Barion</option>
						@endif

						@if ($settings->is_cashu)
						<option value="cashu">CashU</option>
						@endif

						@if ($settings->is_pagseguro)
						<option value="pagseguro">PagSeguro</option>
						@endif

						@if ($settings->is_paytm)
						<option value="paytm">Paytm</option>
						@endif

						@if ($settings->is_interkassa)
						<option value="interkassa">InterKassa</option>
						@endif

					</select>
					@if ($errors->has('method'))
					<span class="help-block">{{ $errors->first('method') }}</span>
					@endif
				</div>

				<div class="form-group checkout-btn">
					<button type="submit" class="btn bg-default-400 btn-block">{{ Lang::get('upgrade.lang_continue') }}</button>
				</div>
				<span class="help-block text-center no-margin">{{ Lang::get('upgrade.lang_terms') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('upgrade.lang_terms_condition') }}</a></span>
			</div>

	</div>
</div>

@endsection