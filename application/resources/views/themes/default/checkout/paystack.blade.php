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
    
    <form action="{{ Protocol::home() }}/checkout/paystack" method="POST" id="PayStackForm">

      {{ csrf_field() }}

      <div class="panel panel-body login-form">
        <div class="text-center">
          <div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
          <h5 class="content-group">{{ Lang::get('upgrade.lang_upgrade_your_account') }} <small class="display-block">{{ config('paystack.account_price') }} {{ config('paystack.currency') }} {{ Lang::get('update.lang_per_day') }}</small></h5>
        </div>

        <!-- Upgrade Days -->
        <div class="form-group has-feedback {{ $errors->has('days') ? 'has-error' : '' }}">
          <input type="number" class="form-control" placeholder="{{ Lang::get('update.lang_account_validity_days') }}" name="days" id="PayStackDays">
          <div class="form-control-feedback">
            <i class="icon-alarm text-muted"></i>
          </div>
          @if ($errors->has('days'))
          <span class="help-block">{{ $errors->first('days') }}</span>
          @endif
        </div>

        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        <input type="hidden" name="orderID" value="{{ uniqid() }}">
        <input type="hidden" name="amount" value="" id="PayStackAmount">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
        <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">

        <div class="form-group checkout-btn">
          <button type="submit" class="btn bg-default-400 btn-block">{{ Lang::get('upgrade.lang_continue') }}</button>
        </div>
        <span class="help-block text-center no-margin">{{ Lang::get('upgrade.lang_terms') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('upgrade.lang_terms_condition') }}</a></span>
      </div>

    </form>

  </div>
</div>

@endsection