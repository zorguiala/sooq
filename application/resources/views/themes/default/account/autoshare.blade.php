@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- AutoShare Settings -->
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
	
	<!-- Auto Share Settings -->
	<div class="col-md-9">

		<div class="panel">

			<div class="panel-body">
				<form action="{{ Protocol::home() }}/account/autoshare" method="POST">

					{{ csrf_field() }}


					<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-bottom bottom-divided nav-justified nav-tabs-icon">

							<!--Facebook Autoshare-->
							<li class="active"><a href="#facebookAutoshare" data-toggle="tab"><i class="icon-facebook"></i> Facebook</a></li>

							<!--Twitter Autoshare-->
							<li><a href="#twitterAutoshare" data-toggle="tab"><i class="icon-twitter"></i> Twitter</a></li>

							<!--Telegram Autoshare-->
							<li><a href="#telegramAutoshare" data-toggle="tab"><i class="fa fa-telegram"></i> Telegram</a></li>
						</ul>

						<div class="tab-content mt-20">

							<!--Facebook-->
							<div class="tab-pane active" id="facebookAutoshare">
								
								<!--Active/Deactive-->
								<div class="form-group {{ $errors->has('fb_active') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/autoshare.lang_facebook') }}</label>
									<select class="select-icons" name="fb_active">
										@if ($autoshare->fb_active)
										<option data-icon="facebook2" value="1">Active</option>
										<option data-icon="facebook2" value="0">Inactive</option>
										@else 
										<option data-icon="facebook2" value="0">Inactive</option>
										<option data-icon="facebook2" value="1">Active</option>
										@endif
									</select>
									@if ($errors->has('fb_active'))
									<span class="help-block">{{ $errors->first('fb_active') }}</span>
									@endif
								</div>

								<!--Facebook APP ID-->
								<div class="form-group {{ $errors->has('fb_app_id') ? 'has-error' : '' }}">
									<label>Facebook App ID</label>
									<input value="{{ $autoshare->fb_app_id }}" class="form-control" type="text" placeholder="Facebook App ID" name="fb_app_id">
									@if ($errors->has('fb_app_id'))
									<span class="help-block">{{ $errors->first('fb_app_id') }}</span>
									@endif
								</div>

								<!--Facebook APP Secret-->
								<div class="form-group {{ $errors->has('fb_app_secret') ? 'has-error' : '' }}">
									<label>Facebook App Secret</label>
									<input value="{{ $autoshare->fb_app_secret }}" class="form-control" type="text" placeholder="Facebook App Secret" name="fb_app_secret">
									@if ($errors->has('fb_app_secret'))
									<span class="help-block">{{ $errors->first('fb_app_secret') }}</span>
									@endif
								</div>

								<!--Facebook Token Access-->
								<div class="form-group {{ $errors->has('fb_access_token') ? 'has-error' : '' }}">
									<label>Facebook Token Access</label>
									<input value="{{ $autoshare->fb_access_token }}" class="form-control" type="text" placeholder="Facebook Token Access" name="fb_access_token">
									@if ($errors->has('fb_access_token'))
									<span class="help-block">{{ $errors->first('fb_access_token') }}</span>
									@endif
								</div>

							</div>

							<!--Twitter-->
							<div class="tab-pane" id="twitterAutoshare">
								
								<!-- Auto share to Twitter -->
								<div class="form-group {{ $errors->has('tw_active') ? 'has-error' : '' }}">
									<label>{{ Lang::get('account/autoshare.lang_twitter') }}</label>
									<select class="select-icons" name="tw_active">
										@if ($autoshare->tw_active)
										<option data-icon="twitter" value="1">Active</option>
										<option data-icon="twitter" value="0">Inactive</option>
										@else 
										<option data-icon="twitter" value="0">Inactive</option>
										<option data-icon="twitter" value="1">Active</option>
										@endif
									</select>
									@if ($errors->has('tw_active'))
									<span class="help-block">{{ $errors->first('tw_active') }}</span>
									@endif
								</div>

								<!-- Twitter Consumer Key -->
								<div class="form-group {{ $errors->has('tw_consumer_key') ? 'has-error' : '' }}">
									<label>Twitter Consumer Key</label>
									<input value="{{ $autoshare->tw_consumer_key }}" class="form-control" type="text" placeholder="Twitter Consumer Key" name="tw_consumer_key">
									@if ($errors->has('tw_consumer_key'))
									<span class="help-block">{{ $errors->first('tw_consumer_key') }}</span>
									@endif
								</div>

								<!-- Twitter Consumer Secret -->
								<div class="form-group {{ $errors->has('tw_consumer_secret') ? 'has-error' : '' }}">
									<label>Twitter Consumer Secret</label>
									<input value="{{ $autoshare->tw_consumer_secret }}" class="form-control" type="text" placeholder="Twitter Consumer Secret" name="tw_consumer_secret">
									@if ($errors->has('tw_consumer_secret'))
									<span class="help-block">{{ $errors->first('tw_consumer_secret') }}</span>
									@endif
								</div>

								<!-- Twitter Access Token Key -->
								<div class="form-group {{ $errors->has('tw_access_token') ? 'has-error' : '' }}">
									<label>Twitter Access Token Key</label>
									<input value="{{ $autoshare->tw_access_token }}" class="form-control" type="text" placeholder="Your Twitter Access Token Key" name="tw_access_token">
									@if ($errors->has('tw_access_token'))
									<span class="help-block">{{ $errors->first('tw_access_token') }}</span>
									@endif
								</div>

								<!-- Twitter Access Token Secret -->
								<div class="form-group {{ $errors->has('tw_access_token_secret') ? 'has-error' : '' }}">
									<label>Twitter Access Token Secret</label>
									<input value="{{ $autoshare->tw_access_token_secret }}" class="form-control" type="text" placeholder="Your Twitter Access Token Secret" name="tw_access_token_secret">
									@if ($errors->has('tw_access_token_secret'))
									<span class="help-block">{{ $errors->first('tw_access_token_secret') }}</span>
									@endif
								</div>

							</div>

							<!--Telegram-->
							<div class="tab-pane" id="telegramAutoshare">
								
								<!-- Auto share to Telegram -->
								<div class="form-group {{ $errors->has('tg_active') ? 'has-error' : '' }}">
									<label>Telegram auto publish</label>
									<select class="select-icons" name="tg_active">
										@if ($autoshare->tg_active)
										<option data-icon="paperplane" value="1">Active</option>
										<option data-icon="paperplane" value="0">Inactive</option>
										@else 
										<option data-icon="paperplane" value="0">Inactive</option>
										<option data-icon="paperplane" value="1">Active</option>
										@endif
									</select>
									@if ($errors->has('tg_active'))
									<span class="help-block">{{ $errors->first('tg_active') }}</span>
									@endif
								</div>

								<!-- Telegram API Token -->
								<div class="form-group {{ $errors->has('tg_api_token') ? 'has-error' : '' }}">
									<label>Telegram API Token</label>
									<input value="{{ $autoshare->tg_api_token }}" class="form-control" type="text" placeholder="Your Telegram API Token" name="tg_api_token">
									@if ($errors->has('tg_api_token'))
									<span class="help-block">{{ $errors->first('tg_api_token') }}</span>
									@endif
								</div>

								<!-- Telegram Bot Username -->
								<div class="form-group {{ $errors->has('tg_bot_username') ? 'has-error' : '' }}">
									<label>Telegram Bot Username</label>
									<input value="{{ $autoshare->tg_bot_username }}" class="form-control" type="text" placeholder="Your Telegram Bot Username" name="tg_bot_username">
									@if ($errors->has('tg_bot_username'))
									<span class="help-block">{{ $errors->first('tg_bot_username') }}</span>
									@endif
								</div>

								<!-- Telegram Channel Username -->
								<div class="form-group {{ $errors->has('tg_channel_username') ? 'has-error' : '' }}">
									<label>Telegram Channel Username (started with @)</label>
									<input value="{{ $autoshare->tg_channel_username }}" class="form-control" type="text" placeholder="Your Telegram Channel Username" name="tg_channel_username">
									@if ($errors->has('tg_channel_username'))
									<span class="help-block">{{ $errors->first('tg_channel_username') }}</span>
									@endif
								</div>

								<!-- Telegram Channel Signature -->
								<div class="form-group {{ $errors->has('tg_channel_signature') ? 'has-error' : '' }}">
									<label>Telegram Channel Signature</label>
									<input value="{{ $autoshare->tg_channel_signature }}" class="form-control" type="text" placeholder="Your Telegram Channel Signature" name="tg_channel_signature">
									@if ($errors->has('tg_channel_signature'))
									<span class="help-block">{{ $errors->first('tg_channel_signature') }}</span>
									@endif
								</div>

							</div>

						</div>
					</div>

					<button type="submit" style="width: 100%" class="btn btn-primary">{{ Lang::get('account/store/settings.lang_save_changes') }}</button>

				</form>
			</div>

		</div>

	</div>

</div>

@endsection