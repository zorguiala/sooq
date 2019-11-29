@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('head')

	<!-- Login using phone number -->
	<script src="https://identifyme.net/authRequest/lib.js" type="text/javascript"></script>

@endsection

@section ('content')

<!-- login -->
<form action="{{ Protocol::home() }}/auth/login" method="POST">

	{{ csrf_field() }}

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
					<div class="icon-object border-blue text-blue"><i class="icon-key"></i></div>
					<h5 class="content-group">{{ Lang::get('auth/login.lang_login_to_your_account') }} <small class="display-block">{{ Lang::get('auth/login.lang_your_credentials') }}</small></h5>
				</div>

				<div class="form-group has-feedback has-feedback-left {{ $errors->has('email') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="{{ Lang::get('auth/login.lang_email_address') }}" name="email" value="{{ old('email') }}">
					<div class="form-control-feedback">
						<i class="icon-envelop text-muted"></i>
					</div>
					@if ($errors->has('email'))
					<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>

				<div class="form-group has-feedback has-feedback-left {{ $errors->has('password') ? 'has-error' : '' }}">
					<input type="password" class="form-control" placeholder="{{ Lang::get('auth/login.lang_password') }}" name="password">
					<div class="form-control-feedback">
						<i class="icon-lock2 text-muted"></i>
					</div>
					@if ($errors->has('password'))
					<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>

				<div class="form-group login-options">
					<div class="row">
						<div class="col-sm-4">
							<label class="checkbox-inline text-grey-400">
								<input type="checkbox" class="styled" name="remember" checked="">
								{{ Lang::get('auth/login.lang_remember_me') }}
							</label>
						</div>

						<div class="col-sm-8 text-right">
							<ul class="list-inline list-inline-separate heading-text">
								@if (Helper::settings_auth()->activation_type == 'sms')
								<li><a href="{{ Protocol::home() }}/auth/activation/phone/resend">{{ Lang::get('auth/login.lang_resend_activation_code') }}</a></li>
								@elseif (Helper::settings_auth()->activation_type == 'email')
								<li><a href="{{ Protocol::home() }}/auth/activation/resend">{{ Lang::get('auth/login.lang_resend_activation_link') }}</a></li>
								@else 
								@endif
								<li><a href="{{ Protocol::home() }}/auth/password/reset">{{ Lang::get('auth/login.lang_forgot_password') }}</a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="recaptcha">
				
					@if (Helper::settings_security()->recaptcha)
						@captcha
					@endif
					
				</div>

				<script type="text/javascript">
					$(".styled, .multiselect-container input").uniform({
				        radioClass: 'choice',
        				wrapperClass: 'border-grey-400 text-grey-400'
				    });
				</script>

				<div class="form-group">
					<button type="submit" class="btn bg-blue btn-block">{{ Lang::get('auth/login.lang_login') }}</button>
				</div>

				<div class="content-divider text-muted form-group"><span>{{ Lang::get('auth/login.lang_or_sign_in_with') }}</span></div>
				<ul class="list-inline form-group list-inline-condensed text-center list-inline-social">

					<!-- Facebook -->
					<li><a href="{{ Protocol::home() }}/auth/facebook" class="btn border-indigo text-indigo btn-flat btn-icon btn-rounded"><i class="icon-facebook"></i></a></li>

					<!-- Twitter 
					<li><a href="{{ Protocol::home() }}/auth/twitter" class="btn border-info text-info btn-flat btn-icon btn-rounded"><i class="icon-twitter"></i></a></li>-->

					<!-- Google -->
					<li><a href="{{ Protocol::home() }}/auth/google" class="btn border-danger-400 text-danger-400 btn-flat btn-icon btn-rounded"><i class="icon-google-plus"></i></a></li>

					<!-- Instagram -->
					<li><a href="{{ Protocol::home() }}/auth/instagram" class="btn border-brown text-brown btn-flat btn-icon btn-rounded"><i class="icon-instagram"></i></a></li>

					<!-- VK 
					<li><a href="{{ Protocol::home() }}/auth/vk" style="border-color: #507299;color: #507299;" class="btn btn-flat btn-icon btn-rounded"><i style="font-size: 15px;vertical-align: middle;line-height: 19px;min-width: 1em;height: 20px;width: 16px;display: block;" class="fa fa-vk"></i></a></li>-->

					<!-- Pinterest -->
					<li><a href="{{ Protocol::home() }}/auth/pinterest" class="btn border-danger-700 text-danger-700 btn-flat btn-icon btn-rounded"><i class="icon-pinterest2"></i></a></li>

					<!-- LinkedIn 
					<li><a href="{{ Protocol::home() }}/auth/linkedin" class="btn border-indigo-600 text-indigo-600 btn-flat btn-icon btn-rounded"><i class="icon-linkedin2"></i></a></li>-->

					<!-- Phone 
					<li><button type="button" class="btn border-slate-600 text-slate-600 btn-flat btn-icon btn-rounded"><i class="icon-phone2" id="login" onClick="login();"></i></button></li>-->

				</ul>

				<div class="content-divider text-muted form-group"><span>{{ Lang::get('auth/login.lang_dont_have_account') }}</span></div>
				<a href="{{ Protocol::home() }}/auth/register" class="btn btn-default btn-block content-group">{{ Lang::get('auth/login.lang_sigh_up') }}</a>
			</div>
		</div>
	</div>
</form>
<!-- /login -->

<script>

	function login(){
		identifymeInit({
			clientId: "{{ config('identifyme.clientId') }}",
			callback: "{{ config('identifyme.callback') }}"
			//countryCode: "",
			//phone: "",
		});
	}

	function myLoginReportHandler(encryptedReport){

		var url = "{{ config('identifyme.callback') }}";
		opener.location.href = url + '?' + window.location.hash.substr(1);
		close();
	}

	(function() {
		checkReportOnLoad({
			callback: myLoginReportHandler
		});
	})();
</script>

@endsection