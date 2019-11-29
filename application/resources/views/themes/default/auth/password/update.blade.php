@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<form action="{{ Protocol::home() }}/auth/password/update?token={{ $token }}&email={{ $email }}" method="POST">

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
					<div class="icon-object border-danger text-danger"><i class="icon-loop3"></i></div>
					<h5 class="content-group">{{ Lang::get('auth/password/update.lang_update_your_password') }} <small class="display-block">{{ Lang::get('auth/password/update.lang_update_your_password_p') }}</small></h5>
				</div>

				<!-- New Password -->
				<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
					<input class="form-control" placeholder="{{ Lang::get('auth/password/update.lang_new_password') }}" type="password" name="password">
					<div class="form-control-feedback">
						<i class="icon-key text-muted"></i>
					</div>
					@if ($errors->has('password'))
					<span class="help-block">
						{{ $errors->first('password') }}
					</span>
					@endif
				</div>

				<!-- Confirm Password -->
				<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
					<input class="form-control" placeholder="{{ Lang::get('auth/password/update.lang_confirm_password') }}" type="password" name="password_confirmation">
					<div class="form-control-feedback">
						<i class="icon-key text-muted"></i>
					</div>
					@if ($errors->has('password_confirmation'))
					<span class="help-block">
						{{ $errors->first('password_confirmation') }}
					</span>
					@endif
				</div>

				{{ csrf_field() }}

				@if (Helper::settings_security()->recaptcha)
					@captcha
				@endif

				<button type="submit" class="btn bg-default btn-block legitRipple">{{ Lang::get('auth/password/update.lang_update_password') }}</button>
			</div>
		</div>
	</div>
</form>

@endsection