@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

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
		
		<form action="{{ Protocol::home() }}/contact" method="POST">
			{{ csrf_field() }}
			<div class="panel panel-body login-form">
				<div class="text-center">
					<div class="icon-object border-blue text-blue"><i class="icon-envelop5"></i></div>
					<h5 class="content-group">{{ Lang::get('contact.lang_get_in_touch') }} <small class="display-block">{{ Lang::get('contact.lang_contact_us_directly') }}</small></h5>
				</div>

				<div class="form-group  {{ $errors->has('full_name') ? 'has-error' : '' }}">
					<label>{{ Lang::get('contact.lang_full_name') }}</label>
					<input type="text" name="full_name" class="form-control" placeholder="{{ Lang::get('contact.lang_full_name_placeholder') }}" value="{{ old('email') }}" value="{{ old('full_name') }}">
					@if ($errors->has('full_name'))
					<span class="help-block">{{ $errors->first('full_name') }}</span>
					@endif
				</div>

				<!-- Email Address -->
				<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
					<label>{{ Lang::get('contact.lang_email_address') }}</label>
					<input type="email" name="email" class="form-control" placeholder="{{ Lang::get('contact.lang_email_address_placeholder') }}" value="{{ old('email') }}">
					@if ($errors->has('email'))
					<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>

				<!-- Phone Number -->
				<div class="form-group  {{ $errors->has('phone') ? 'has-error' : '' }}">
					<label>{{ Lang::get('contact.lang_phone') }}</label>
					<input type="text" name="phone" class="form-control" placeholder="{{ Lang::get('contact.lang_phone_placeholder') }}" value="{{ old('phone') }}">
					@if ($errors->has('phone'))
					<span class="help-block">{{ $errors->first('phone') }}</span>
					@endif
				</div>

				<!-- Subject -->
				<div class="form-group  {{ $errors->has('subject') ? 'has-error' : '' }}">
					<label>{{ Lang::get('contact.lang_subject') }}</label>
					<input type="text" name="subject" class="form-control" placeholder="{{ Lang::get('contact.lang_subject_placeholder') }}" value="{{ old('subject') }}">
					@if ($errors->has('subject'))
					<span class="help-block">{{ $errors->first('subject') }}</span>
					@endif
				</div>

				<!-- Your Message -->
				<div class="form-group  {{ $errors->has('message') ? 'has-error' : '' }}">
					<label>{{ Lang::get('contact.lang_your_message') }}</label>
					<textarea rows="5" cols="5" class="form-control" placeholder="{{ Lang::get('contact.lang_your_message_placeholder') }}" name="message">{{ old('message') }}</textarea>
					@if ($errors->has('message'))
					<span class="help-block">{{ $errors->first('message') }}</span>
					@endif
				</div>

				<div class="text-right">
					<button type="submit" class="btn btn-default">{{ Lang::get('contact.lang_send_message') }}</button>
				</div>
				
			</div>
		</form>

	</div>

</div>

@endsection