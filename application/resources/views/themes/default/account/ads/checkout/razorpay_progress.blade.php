@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<style type="text/css">
    
    .razorpay-payment-button{
        border: none;
        background-color: #30b1e2;
        color: white;
        text-transform: uppercase;
        padding: 10px 20px;
        width: 100%;
        border-radius: 2px;
        font-family: 'Fira Sans', sans-serif;
        font-size: 14px;
    }

</style>

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

            <form action="{{ Protocol::home() }}/account/ads/{{ $ad->ad_id }}/checkout/razorpay/progress" method="POST">

                {{ csrf_field() }}

                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{ config('razorpay.razor_key') }}"
                        data-amount="{{ $amount }}"
                        data-buttontext="Pay {{ $amount / 100 }} INR"
                        data-name="{{ config('app.name') }}"
                        data-description="Upgrade your account for {{ $days }} days"
                        data-image="{{ config('razorpay.logo') }}"
                        data-prefill.name=""
                        data-prefill.email=""
                        data-theme.color="#30b1e2">
                </script>

            </form>


    </div>

</div>

@endsection