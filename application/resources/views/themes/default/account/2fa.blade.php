@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Two Factor Authentication -->
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
	
	<!-- Two Factor Authentication -->
	<div class="col-md-9">

		<div class="panel">

			<div class="panel-body">
				<form action="{{ Protocol::home() }}/account/secure/2fa" method="POST">

					{{ csrf_field() }}

					<h5 style="font-family: Fira sans;text-transform: uppercase;font-size: 14px;letter-spacing: 1px;color: #838383;">Two-factor authentication</h5>
					<p class="mt-20" style="font-size: 12px;color: #b9b9b9;font-family: Roboto;">Protect your Discord account with an extra layer of security. Once configured you'll be required
					to enter both your password and an authentication code from your mobile phone in order to sign in</p>

					<button type="button" style="margin-top: 25px;background-color: #ea5959;border: 0px;border-radius: 2px;padding: 5px 10px;font-family: Fira sans;color: white;">Enable Two-Factor Auth</button>

				</form>
			</div>
		</div>

	</div>



</div>

@endsection