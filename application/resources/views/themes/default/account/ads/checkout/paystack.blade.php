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

			<form action="{{ Protocol::home() }}/account/ads/{{ $ad->ad_id }}/checkout/paystack" method="POST" id="PayStackFormAd">

		      	{{ csrf_field() }}

				<div style="background-color: #FEFEFE;width: 95%;margin: 0 auto;border-radius: 3px;padding: 15px 30px 5px 30px;margin-bottom: 30px;">

			        <!-- Upgrade Days -->
			        <div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
			          	<input type="number" class="form-control" placeholder="{{ Lang::get('update.lang_ad_validity_days') }}" name="days" id="PayStackDaysAd">
			          	@if ($errors->has('days'))
			          	<span class="help-block">{{ $errors->first('days') }}</span>
			          	@endif
			          	<span class="help-block">{{ config('paystack.ad_price') }}  {{ config('paystack.currency') }} {{ Lang::get('update.lang_per_day') }}</span>
			        </div>

			        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
			        <input type="hidden" name="orderID" value="{{ uniqid() }}">
			        <input type="hidden" name="amount" value="" id="PayStackAmountAd">
			        <input type="hidden" name="quantity" value="1">
			        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
			        <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">

			        <button type="submit" style="width: 100%;margin: 0 auto !important;font-size: 16px;float: none;display: block;height: 50px;color: #fff;background: #07f;font-family: 'Open Sans', 'Droid Arabic Kufi', sans-serif;" class="btn btn-primary legitRipple">{{ Lang::get('ads/upgrade.lang_complete_checkout') }}</button>

			    </div>

		    </form>


	</div>

</div>

@endsection