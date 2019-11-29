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
		
		<form action="{{ Protocol::home() }}/checkout/pagseguro" method="POST" id="formToSubmit">

			{{ csrf_field() }}

			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
					<h5 class="content-group">{{ Lang::get('upgrade.lang_upgrade_your_account') }} <small class="display-block">{{ str_replace('.', ',', config('pagseguro.account_price')) }} {{ config('pagseguro.currency') }} {{ Lang::get('update.lang_per_day') }}</small></h5>
				</div>

				<!-- Upgrade Days -->
				<div class="form-group has-feedback {{ $errors->has('days') ? 'has-error' : '' }}">
					<input type="number" class="form-control" placeholder="{{ Lang::get('update.lang_account_validity_days') }}" name="days" value="{{ old('days') }}">
					<div class="form-control-feedback">
						<i class="icon-alarm text-muted"></i>
					</div>
					@if ($errors->has('days'))
					<span class="help-block">{{ $errors->first('days') }}</span>
					@endif
				</div>

				<!-- Your Full Name -->
				<div class="form-group {{ $errors->has('senderName') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Seu nome completo" name="senderName" value="{{ old('senderName') }}">
					@if ($errors->has('senderName'))
					<span class="help-block">{{ $errors->first('senderName') }}</span>
					@endif
				</div>

				<!-- Your phone number -->
				<div class="form-group {{ $errors->has('senderPhone') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Seu número de telefone" name="senderPhone" value="{{ old('senderPhone') }}">
					@if ($errors->has('senderPhone'))
					<span class="help-block">{{ $errors->first('senderPhone') }}</span>
					@endif
				</div>

				<!-- Your shipping Address Street -->
				<div class="form-group {{ $errors->has('shippingAddressStreet') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Sua rua de endereço de envio" name="shippingAddressStreet" value="{{ old('shippingAddressStreet') }}">
					@if ($errors->has('shippingAddressStreet'))
					<span class="help-block">{{ $errors->first('shippingAddressStreet') }}</span>
					@endif
				</div>

				<!-- Your shipping Address Number -->
				<div class="form-group {{ $errors->has('shippingAddressNumber') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Seu número de endereço de entrega" name="shippingAddressNumber" value="{{ old('shippingAddressNumber') }}">
					@if ($errors->has('shippingAddressNumber'))
					<span class="help-block">{{ $errors->first('shippingAddressNumber') }}</span>
					@endif
				</div>

				<!-- Your shipping Address District -->
				<div class="form-group {{ $errors->has('shippingAddressDistrict') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Seu distrito de endereços de envio" name="shippingAddressDistrict" value="{{ old('shippingAddressDistrict') }}">
					@if ($errors->has('shippingAddressDistrict'))
					<span class="help-block">{{ $errors->first('shippingAddressDistrict') }}</span>
					@endif
				</div>

				<!-- Your shipping Address Postal Code -->
				<div class="form-group {{ $errors->has('shippingAddressPostalCode') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Seu endereço de entrega CEP" name="shippingAddressPostalCode" value="{{ old('shippingAddressPostalCode') }}">
					@if ($errors->has('shippingAddressPostalCode'))
					<span class="help-block">{{ $errors->first('shippingAddressPostalCode') }}</span>
					@endif
				</div>

				<input type="hidden" id="senderHash" value="" name="senderHash">

				<div class="form-group checkout-btn">
					<button type="submit" class="btn bg-default-400 btn-block" id="submitPaymentForm">{{ Lang::get('upgrade.lang_continue') }}</button>
				</div>
				<span class="help-block text-center no-margin">{{ Lang::get('upgrade.lang_terms') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('upgrade.lang_terms_condition') }}</a></span>
			</div>

	</div>
</div>

<script type="text/javascript" src="{{ PagSeguro::getUrl()['javascript'] }}"></script>
<script>

	$("#submitPaymentForm").click(function(e) {
	  	e.preventDefault();
	  	PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}');
    	$('#senderHash').val(PagSeguroDirectPayment.getSenderHash()); 
    	$('#formToSubmit').submit();

	});
   
</script>

@endsection