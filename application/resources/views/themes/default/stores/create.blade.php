@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Create New Store -->
<div class="row">

	<div class="col-md-8">

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

		<!-- Page Body -->
		<div class="panel panel-flat">

			<form action="{{ Protocol::home() }}/create/store" method="POST" enctype="multipart/form-data">

				<div class="panel-body page_content">

						{{ csrf_field() }}
						
						<!-- Store Username -->
						<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
							<label>{{ Lang::get('create/store.lang_store_username') }}</label>
							<input type="text" value="{{ old('username') }}" class="form-control input-xlg" name="username" placeholder="{{ Lang::get('create/store.lang_store_username_placeholder') }}">
							@if ($errors->has('username'))
							<span class="help-block">{{ $errors->first('username') }}</span>
							@endif
						</div>

						<!-- Store Title -->
						<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
							<label>{{ Lang::get('create/store.lang_store_title') }}</label>
							<input type="text" value="{{ old('title') }}" class="form-control input-xlg" name="title" placeholder="{{ Lang::get('create/store.lang_store_title_placeholder') }}">
							@if ($errors->has('title'))
							<span class="help-block">{{ $errors->first('title') }}</span>
							@endif
						</div>

						<!-- Short Description -->
						<div class="form-group {{ $errors->has('short_desc') ? 'has-error' : '' }}">
							<label>{{ Lang::get('create/store.lang_store_short_description') }}</label>
							<input type="text" value="{{ old('short_desc') }}" class="form-control input-xlg" name="short_desc" placeholder="{{ Lang::get('create/store.lang_store_short_description_placeholder') }}">
							@if ($errors->has('short_desc'))
							<span class="help-block">{{ $errors->first('short_desc') }}</span>
							@endif
						</div>

						<!-- Long Description -->
						<div class="form-group {{ $errors->has('long_desc') ? 'has-error' : '' }}">
							<label>{{ Lang::get('create/store.lang_store_long_description') }}</label>
							<textarea name="long_desc" rows="10" class="form-control" placeholder="{{ Lang::get('create/store.lang_store_long_description_placeholder') }}"></textarea>
							@if ($errors->has('long_desc'))
							<span class="help-block">{{ $errors->first('long_desc') }}</span>
							@endif
						</div>

						<!-- Select Category -->
						<div class="form-group select-size-lg {{ $errors->has('category') ? 'has-error' : '' }}">
							<label>{{ Lang::get('create/store.lang_store_category') }}</label>
							<select required="" class="select-search" data-placeholder="{{ Lang::get('create/ad.lang_select_category') }}" name="category">
                                <option></option>
                                @if(count(Helper::parent_categories()))
                                @foreach (Helper::parent_categories() as $parent)
                            	<option class="select2-results__group" value="{{ $parent->id }}" {{ old('category') == $parent->id ? 'selected' : '' }}>-- {{ $parent->category_name }} --</option>
                                @if (count(Helper::sub_categories($parent->id)))
                                @foreach (Helper::sub_categories($parent->id) as $sub)
                                <option {{ old('category') == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                        	</select>
						</div>

						<!-- Store Logo -->
						<div class="form-group upload-store-logo-rtl {{ $errors->has('logo') ? 'has-error' : '' }}">
							<label class="display-block">{{ Lang::get('create/store.lang_store_logo') }}</label>
	                        <input type="file" class="file-styled" name="logo">
	                        <span class="help-block">{{ Lang::get('create/store.lang_accepted_formats') }}</span>
	                        @if ($errors->has('logo'))
							<span class="help-block">{{ $errors->first('logo') }}</span>
							@endif
						</div>

				</div>

				<div class="panel-footer">
					<div class="heading-elements">
						<div class="pull-left mt-5 {{ $errors->has('terms') ? 'has-error' : '' }}" style="margin-left: 20px;">
							<label class="checkbox-inline text-grey-400">
								<input type="checkbox" class="styled" name="terms">
								{{ Lang::get('create/ad.lang_i_have_confirm') }} <a href="{{ config('pages.terms') }}" target="_blank">{{ Lang::get('create/ad.lang_terms_of_service') }}</a>
							</label>
							@if ($errors->has('terms'))
							<span class="help-block">{{ $errors->first('terms') }}</span>
							@endif
						</div>
						
						@if (Helper::settings_security()->recaptcha)
							@captcha
						@endif

						<button type="submit" class="btn btn-primary heading-btn pull-right">{{ Lang::get('create/store.lang_create_store') }}</button>
					</div>
				</div>

			</form>

		</div>

	</div>

	<div class="col-md-4">
		
		<div class="panel">
			<div class="panel-body text-center">
				<div class="icon-object border-blue text-blue"><i class="icon-reading"></i></div>
				<h5 class="text-semibold">{{ Lang::get('create/ad.lang_terms_of_service') }}</h5>
				<p class="mb-15">{{ Lang::get('create/store.lang_terms_of_service_p') }}</p>
				<a href="{{ config('pages.terms') }}" target="_blank" class="btn btn-primary">{{ Lang::get('create/ad.lang_terms_of_service') }}</a>
			</div>
		</div>

		<!-- Contact us if you have any questions -->
		<div class="panel panel-body media-rtl">
			<div class="media no-margin stack-media-on-mobile">
				<div class="media-left media-middle">
					<i class="icon-lifebuoy icon-3x text-muted no-edge-top"></i>
				</div>

				<div class="media-body">
					<h6 class="media-heading text-semibold">{{ Lang::get('create/ad.lang_got_question') }}</h6>
					<span class="text-muted">{{ Lang::get('contact.lang_contact_us_directly') }}</span>
				</div>

				<div class="media-right media-middle">
					<a href="{{ Protocol::home() }}/contact" class="btn btn-primary">{{ Lang::get('create/ad.lang_contact') }}</a>
				</div>
			</div>
		</div>

	</div>

</div>

@endsection