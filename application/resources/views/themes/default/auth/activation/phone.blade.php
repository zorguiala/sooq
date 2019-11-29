@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<form action="{{ Protocol::home() }}/auth/activation/phone" method="POST">
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
					<div class="icon-object border-danger text-danger"><i class="icon-phone2"></i></div>
					<h5 class="content-group">{{ Lang::get('auth/activation/phone_active.lang_verify_your_phone') }} <small class="display-block">{{ Lang::get('auth/activation/phone_active.lang_put_activation_code') }}</small></h5>
				</div>

				{{ csrf_field() }}

				<div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
					<input class="form-control" placeholder="{{ Lang::get('auth/activation/phone_active.lang_your_phone_number') }}" type="text" name="phone" value="{{ Session::get('phone_number') }}">
					<div class="form-control-feedback">
						<i class="icon-mobile2 text-muted"></i>
					</div>
					@if ($errors->has('phone'))
					<span class="help-block">
						{{ $errors->first('phone') }}
					</span>
					@endif
				</div>

				<div class="form-group has-feedback {{ $errors->has('sms_code') ? 'has-error' : '' }}">
					<input class="form-control" placeholder="{{ Lang::get('auth/activation/phone_active.lang_activation_code') }}" type="text" name="sms_code">
					<div class="form-control-feedback">
						<i class="icon-key text-muted"></i>
					</div>
					@if ($errors->has('sms_code'))
					<span class="help-block">
						{{ $errors->first('sms_code') }}
					</span>
					@endif
				</div>

				@if (Helper::settings_security()->recaptcha)
					@captcha
				@endif

				<button type="submit" class="btn bg-default btn-block legitRipple">{{ Lang::get('auth/activation/phone_active.lang_verify') }}</button>
			</div>
		</div>
	</div>
</form>

@endsection