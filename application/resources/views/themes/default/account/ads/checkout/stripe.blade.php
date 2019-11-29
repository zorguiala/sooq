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

			<form action="{{ Protocol::home() }}/account/ads/{{ $ad->ad_id }}/checkout/stripe" method="POST">

				{{ csrf_field() }}

				<div style="background-color: #FEFEFE;width: 95%;margin: 0 auto;border-radius: 3px;padding: 15px 30px 5px 30px;margin-bottom: 30px;">

					<div class="form-group {{ $errors->has('days') ? 'has-error' : '' }}">
						<input type="number" class="form-control" placeholder="{{ Lang::get('update.lang_ad_validity_days') }}" name="days">
						<div class="form-control-feedback">
							<i class="icon-alarm text-muted"></i>
						</div>
						@if ($errors->has('days'))
						<span class="help-block">{{ $errors->first('days') }}</span>
						@endif
						<span class="help-block">{{ config('services.stripe.ad_price') }}  {{ config('services.stripe.currency') }} {{ Lang::get('update.lang_per_day') }}</span>
					</div>
						
					<div class="form-group has-feedback has-feedback-left {{ $errors->has('number') ? 'has-error' : '' }}">
						<input type="text" class="form-control" placeholder="{{ Lang::get('upgrade.lang_credit_card_number') }}" name="number">
						<div class="form-control-feedback">
							<i class="icon-menu text-muted"></i>
						</div>
						@if ($errors->has('number'))
						<span class="help-block">{{ $errors->first('number') }}</span>
						@endif
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group has-feedback has-feedback-left {{ $errors->has('expiryYear') ? 'has-error' : '' }}">
									<select class="select" name="expiryYear">
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
										<option value="2023">2023</option>
										<option value="2024">2024</option>
										<option value="2025">2025</option>
										<option value="2026">2026</option>
										<option value="2027">2027</option>
										<option value="2028">2028</option>
										<option value="2029">2029</option>
										<option value="2030">2030</option>
									</select>
									@if ($errors->has('expiryYear'))
									<span class="help-block">{{ $errors->first('expiryYear') }}</span>
									@endif
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group has-feedback has-feedback-left {{ $errors->has('expiryMonth') ? 'has-error' : '' }}">
									<select class="select" name="expiryMonth">
										<option value='1'>{{ Lang::get('upgrade.lang_janaury') }}</option>
									    <option value='2'>{{ Lang::get('upgrade.lang_february') }}</option>
									    <option value='3'>{{ Lang::get('upgrade.lang_march') }}</option>
									    <option value='4'>{{ Lang::get('upgrade.lang_april') }}</option>
									    <option value='5'>{{ Lang::get('upgrade.lang_may') }}</option>
									    <option value='6'>{{ Lang::get('upgrade.lang_june') }}</option>
									    <option value='7'>{{ Lang::get('upgrade.lang_july') }}</option>
									    <option value='8'>{{ Lang::get('upgrade.lang_august') }}</option>
									    <option value='9'>{{ Lang::get('upgrade.lang_september') }}</option>
									    <option value='10'>{{ Lang::get('upgrade.lang_october') }}</option>
									    <option value='11'>{{ Lang::get('upgrade.lang_november') }}</option>
									    <option value='12'>{{ Lang::get('upgrade.lang_december') }}</option>
									</select>
									@if ($errors->has('expiryMonth'))
									<span class="help-block">{{ $errors->first('expiryMonth') }}</span>
									@endif
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group {{ $errors->has('cvv') ? 'has-error' : '' }}">
									<input type="text" class="form-control" placeholder="CVV" name="cvv">
									@if ($errors->has('cvv'))
									<span class="help-block">{{ $errors->first('cvv') }}</span>
									@endif
								</div>
							</div>

						</div>
					</div>

					<button type="submit" style="width: 100%;margin: 0 auto !important;font-size: 16px;float: none;display: block;height: 50px;color: #fff;background: #07f;font-family: 'Open Sans', 'Droid Arabic Kufi', sans-serif;" class="btn btn-primary legitRipple">{{ Lang::get('ads/upgrade.lang_complete_checkout') }}</button>

				</div>

			</form>


	</div>

</div>

@endsection