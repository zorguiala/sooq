@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Read Message -->
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
						<div class="btn-group navbar-btn">

							<!-- Reply -->
							<a href="{{ Protocol::home() }}/account/inbox/reply?to={{ $message->msg_from }}&ad={{ $message->ad_id }}" class="btn btn-default legitRipple"><i class="icon-reply"></i> <span class="hidden-xs position-right">{{ Lang::get('account/messages/read.lang_reply') }}</span></a>

							<!-- Delete -->
							<a href="{{ Protocol::home() }}/account/inbox/delete/{{ $message->id }}" class="btn btn-default legitRipple"><i class="icon-bin"></i> <span class="hidden-xs position-right">{{ Lang::get('account/messages/read.lang_delete') }}</span></a>

						</div>

						<div class="pull-right-lg">
							<p class="navbar-text">{{ Helper::date_ago($message->created_at) }}</p>
						</div>
					</div>
				</div>
			</div>
			<!-- /mail toolbar -->


			<!-- Mail details -->
			<div class="media stack-media-on-mobile mail-details-read">
				@if (Profile::hasStore(Helper::id_by_username($message->msg_from)))
				<a href="{{ Protocol::home() }}/store/{{ Profile::hasStore(Helper::id_by_username($message->msg_from))->username }}" class="media-left" target="_blank">
					<img class="lozad img-rounded" data-src="{{ Profile::picture(Helper::id_by_username($message->msg_from)) }}">
				</a>
				@else 
				<a href="#" class="media-left">
					<img class="lozad img-rounded" data-src="{{ Profile::picture(Helper::id_by_username($message->msg_from)) }}">
				</a>
				@endif

				<div class="media-body">
					<h6 class="media-heading">{{ $message->subject }}</h6>
					<div class="letter-icon-title text-muted">
						<ul class="list-inline list-inline-separate heading-text">
							@if (Profile::hasStore(Helper::id_by_username($message->msg_from)))
							<li><a class="text-muted" href="{{ Protocol::home() }}/store/{{ Profile::hasStore(Helper::id_by_username($message->msg_from))->username }}" target="_blank">{{ Profile::hasStore(Helper::id_by_username($message->msg_from))->title }}</a></li>
							@else
							<li>{{ Profile::full_name(Helper::id_by_username($message->msg_from)) }}</li> 
							@endif

							@if ($message->show_email)
							<li>{{ $message->email }}</li>
							@endif

							@if ($message->show_phone)
							<li>{{ $message->phone }}</li>
							@endif
						</ul>
					</div>
				</div>

			</div>
			<!-- /mail details -->


			<!-- Mail container -->
			<div class="mail-container-read">
				{!! nl2br($message->message) !!}
			</div>
			<!-- /mail container -->

		</div>

	</div>

</div>

@endsection