@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<form action="{{ Protocol::home() }}/auth/password/reset" method="POST">

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
					<h5 class="content-group">{{ Lang::get('auth/password/reset.lang_password_recovery') }} <small class="display-block">{{ Lang::get('auth/password/reset.lang_we_will_send_you_instructions') }}</small></h5>
				</div>

				<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
					<input class="form-control" placeholder="{{ Lang::get('auth/password/reset.lang_your_email') }}" type="email" name="email">
					<div class="form-control-feedback">
						<i class="icon-reset text-muted"></i>
					</div>
					@if ($errors->has('email'))
					<span class="help-block">
						{{ $errors->first('email') }}
					</span>
					@endif
				</div>

				{{ csrf_field() }}

				@if (Helper::settings_security()->recaptcha)
					@captcha
				@endif

				<button type="submit" class="btn bg-default btn-block legitRipple">{{ Lang::get('auth/password/reset.lang_reset_password') }}</button>
			</div>
		</div>
	</div>
</form>

@endsection