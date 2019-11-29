@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Upgrade Ad -->
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
	
	<!-- Upgrade Ad -->
	<div class="col-md-9" style="background-color: #FFF;padding-bottom: 15px;border-radius: 2px;box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.11);">
			
			<nav>
				<ol class="cd-multi-steps text-top">
					<li class="visited"><a href="{{ Protocol::home() }}/account/ads">{{ Lang::get('ads/upgrade.lang_choose_ad') }}</a></li>
					<li class="visited" ><a href="#">{{ Lang::get('ads/upgrade.lang_create_account') }}</a></li>
					<li><a href="#" class="last">{{ Lang::get('ads/upgrade.lang_checkout') }}</a></li>
				</ol>
			</nav>

			<form action="{{ Protocol::home() }}/account/ads/upgrade/{{ $ad->ad_id }}" method="POST">

			{{ csrf_field() }}

				<div style="background-color: #FEFEFE;width: 95%;margin: 0 auto;border-radius: 3px;padding: 15px 30px 5px 30px;margin-bottom: 30px;">

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

							@if ($settings->is_cashu)
							<option value="cashu">CashU</option>
							@endif

							@if ($settings->is_razorpay)
							<option value="razorpay">RazorPay</option>
							@endif

							@if ($settings->is_pagseguro)
							<option value="pagseguro">PagSeguro</option>
							@endif

						</select>
						@if ($errors->has('method'))
						<span class="help-block">{{ $errors->first('method') }}</span>
						@endif
					</div>

					<div class="form-group">
						<div class="row">

							<!-- Agree Terms -->
							<div class="col-md-12">
								<span class="help-block text-left no-margin">{{ Lang::get('create/ad.lang_i_have_confirm') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('create/ad.lang_terms_of_service') }}</a></span>
							</div>

						</div>
					</div>



					<button type="submit" style="width: 100%;margin: 0 auto !important;font-size: 16px;float: none;display: block;height: 50px;color: #fff;background: #07f;font-family: 'Open Sans', 'Droid Arabic Kufi', sans-serif;" class="btn btn-primary legitRipple">{{ Lang::get('upgrade.lang_continue') }}</button>

				</div>

			</form>


	</div>

</div>

@endsection