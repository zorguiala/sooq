@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Reply Message -->
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
	
	<div class="col-md-9">

		<div class="panel panel-white">
			
			<form action="{{ Protocol::home() }}/account/inbox/reply?to={{ $msg_from }}&ad={{ $ad_id }}" method="POST">
	
				{{ csrf_field() }}

				<!-- Mail toolbar -->
				<div class="panel-toolbar panel-toolbar-inbox">
					<div class="navbar navbar-default">
						<ul class="nav navbar-nav visible-xs-block no-border">
							<li>
								<a class="text-center collapsed legitRipple" data-toggle="collapse" data-target="#inbox-toolbar-toggle-single">
									<i class="icon-circle-down2"></i>
								</a>
							</li>
						</ul>

						<div class="navbar-collapse collapse" id="inbox-toolbar-toggle-single" style="height: auto;">

							<div class="btn-group navbar-btn" style="width: 50%">
								<div class="row">
									<div class="col-md-6">
										<select data-placeholder="{{ Lang::get('account/messages/reply.lang_show_or_hide_phone') }}" class="select" name="show_phone">
											<option></option>
											<option value="1">{{ Lang::get('account/messages/reply.lang_show_phone') }}</option>
											<option value="0">{{ Lang::get('account/messages/reply.lang_hide_phone') }}</option>
										</select>
									</div>
									<div class="col-md-6">
										<select data-placeholder="{{ Lang::get('account/messages/reply.lang_show_or_hide_email') }}" class="select" name="show_email">
											<option></option>
											<option value="1">{{ Lang::get('account/messages/reply.lang_show_email') }}</option>
											<option value="0">{{ Lang::get('account/messages/reply.lang_hide_email') }}</option>
										</select>
									</div>
								</div>
							</div>

							<div class="pull-right-lg">
								<div class="btn-group navbar-btn">
									<button type="submit" class="btn bg-blue legitRipple"><i class="icon-checkmark3 position-left"></i> {{ Lang::get('account/messages/reply.lang_send_message') }}</button>
								</div>
							</div>

						</div>
					</div>
				</div>
				<!-- /mail toolbar -->


				<!-- Mail details -->
				<div class="table-responsive mail-details-write">
					<table class="table">
						<tbody>
							<tr>
								<td style="width: 150px">{{ Lang::get('account/messages/reply.lang_to') }}</td>
								<td class="no-padding"><input class="form-control text-muted text-grey-300" placeholder="Message to" type="text" name="msg_to" value="{{ $msg_from }}" readonly=""></td>
							</tr>
							<tr>
								<td>{{ Lang::get('account/messages/reply.lang_subject') }}</td>
								<td class="no-padding"><input class="form-control text-muted text-grey-300" placeholder="{{ Lang::get('account/messages/reply.lang_subject_placeholder') }}" value="Re: {{ $message->subject }}" type="text" name="subject"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /mail details -->


				<!-- Mail container -->
				<div class="mail-container-write">
	
					<textarea class="form-control pl-20 pr-20 pt-20" placeholder="{{ Lang::get('account/messages/reply.lang_your_message_here') }}" name="message" rows="4" style="height: 400px;"></textarea>

				</div>
				<!-- /mail container -->

			</form>

		</div>

	</div>

</div>

@endsection