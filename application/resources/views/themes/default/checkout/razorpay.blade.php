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
        
        <form action="{{ Protocol::home() }}/checkout/razorpay" method="POST">

            {{ csrf_field() }}

            <div class="panel panel-body login-form">
                <div class="text-center">
                    <div class="icon-object border-blue text-blue"><i class="icon-chess-queen"></i></div>
                    <h5 class="content-group">{{ Lang::get('upgrade.lang_upgrade_your_account') }} <small class="display-block">{{ config('razorpay.account_price') }} {{ config('razorpay.currency') }} {{ Lang::get('update.lang_per_day') }}</small></h5>
                </div>

                <div class="form-group has-feedback has-feedback-left {{ $errors->has('days') ? 'has-error' : '' }}">
                    <input type="number" class="form-control" placeholder="{{ Lang::get('update.lang_account_validity_days') }}" name="days">
                    <div class="form-control-feedback">
                        <i class="icon-alarm text-muted"></i>
                    </div>
                    @if ($errors->has('days'))
                    <span class="help-block">{{ $errors->first('days') }}</span>
                    @endif
                </div>

                <div class="form-group checkout-btn">
                    <button type="submit" class="btn bg-default-400 btn-block">{{ Lang::get('upgrade.lang_continue') }}</button>
                </div>
                <span class="help-block text-center no-margin">{{ Lang::get('upgrade.lang_terms') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('upgrade.lang_terms_condition') }}</a></span>
            </div>

        </form>

    </div>
</div>

@endsection