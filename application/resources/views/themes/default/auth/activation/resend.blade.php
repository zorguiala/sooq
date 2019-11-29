@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<form action="{{ Protocol::home() }}/auth/activation/resend" method="POST">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">

			<!-- Sessions Message -->
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

			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-danger text-danger"><i class="icon-spinner11"></i></div>
					<h5 class="content-group">{{ Lang::get('auth/activation/resend_email.lang_resend_activation_key') }} <small class="display-block">{{ Lang::get('auth/activation/resend_email.lang_resend_activation_key_p') }}</small></h5>
				</div>

				{{ csrf_field() }}

				<div class="form-group has-feedback">
					<input class="form-control" placeholder="{{ Lang::get('auth/password/reset.lang_your_email') }}" type="email" name="email">
					<div class="form-control-feedback">
						<i class="icon-envelop text-muted"></i>
					</div>
				</div>

				@if (Helper::settings_security()->recaptcha)
					@captcha
				@endif

				<button type="submit" class="btn bg-default btn-block legitRipple">{{ Lang::get('auth/activation/resend_email.lang_resend_activation_key_btn') }}</button>
			</div>
		</div>
	</div>
</form>

@endsection