@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- account messages -->
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
	
	<!-- Account messages -->
	<div class="col-md-9">

		<div class="panel">
			
			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>{{ Lang::get('table.lang_ad_details') }}</th>
							<th class="col-md-2">{{ Lang::get('table.lang_from') }}</th>
							<th class="col-md-2">{{ Lang::get('table.lang_subject') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_status') }}</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>

					<tbody>

						@if ($messages)
						@foreach ($messages as $message)
						<tr>

							<!-- Ad ID -->
							<td>
								<div class="media-left media-middle">
									<a href="{{ Protocol::home() }}/vi/{{ $message->ad_id }}"><img data-src="{{ Protocol::home() }}/application/public/uploads/images/{{ $message->ad_id }}/previews/preview_0.jpg" class="lozad img-circle img-xs" alt=""></a>
								</div>
								<div class="media-left">
									<div class=""><a href="{{ Protocol::home() }}/vi/{{ $message->ad_id }}" class="text-default text-semibold">{{ $message->ad_id }}</a></div>
									<div class="text-muted text-size-small">
										@if (Helper::ad_status($message->ad_id))
										<span class="status-mark border-success position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_active') }}"></span>
										@else 
										<span class="status-mark border-danger position-left" data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_pending') }}"></span>
										@endif
										{{ Helper::date_ago($message->created_at) }}
									</div>
								</div>
							</td>

							<!-- Message From -->
							<td><span class="text-muted">{{ Profile::full_name_by_username($message->msg_from) }}</span></td>
							
							<!-- Subject -->
							<td><span class="text-muted">{{ $message->subject }}</span></td>

							<!-- Message Status -->
							@if ($message->is_read)
							<td class="text-center"><span class="label label-default">{{ Lang::get('badges.lang_read') }}</span></td>
							@else 
							<td class="text-center"><span class="label label-primary">{{ Lang::get('badges.lang_unread') }}</span></td>
							@endif

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="{{ Protocol::home() }}/account/inbox/read/{{ $message->id }}"><i class="icon-eye"></i> {{ Lang::get('options.lang_read_message') }}</a></li>
											<li><a href="{{ Protocol::home() }}/account/inbox/reply?to={{ $message->msg_from }}&ad={{ $message->ad_id }}"><i class="icon-bubbles8"></i> {{ Lang::get('options.lang_reply_message') }}</a></li>
											<li class="divider"></li>
											<li><a href="{{ Protocol::home() }}/account/inbox/delete/{{ $message->id }}"><i class="icon-trash"></i> {{ Lang::get('options.lang_delete_message') }}</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif
						
					</tbody>
				</table>

				@if ($messages)
				<div class="text-center pb-15">
					{{ $messages->links() }}
				</div>
				@endif
			</div>
		</div>

	</div>

</div>

@endsection