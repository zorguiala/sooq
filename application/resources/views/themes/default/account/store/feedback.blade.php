@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Store Feedback -->
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
	
	<!-- Store Feedback -->
	<div class="col-md-9">
		
		<div class="panel panel-flat">

			<div class="table-responsive">
				<table class="table table-togglable table-hover">
					<thead>
						<tr>
							<th data-toggle="true">{{ Lang::get('table.lang_full_name') }}</th>
							<th data-hide="phone">{{ Lang::get('table.lang_email_address') }}</th>
							<th data-hide="phone,tablet">{{ Lang::get('table.lang_phone_number') }}</th>
							<th data-hide="phone,tablet">{{ Lang::get('table.lang_subject') }}</th>
							<th data-hide="phone,tablet">{{ Lang::get('table.lang_message') }}</th>
							<th data-hide="phone" class="text-center">{{ Lang::get('table.lang_status') }}</th>
							<th data-hide="phone" class="text-center">{{ Lang::get('table.lang_date') }}</th>
							<th class="text-center" style="width: 30px;"><i class="icon-menu"></i></th>
						</tr>
					</thead>
					<tbody>
						@if ($feedback)
						@foreach ($feedback as $feed)
						<tr>
							<!-- Full Name -->
							<td>{{ $feed->name }}</td>

							<!-- Email Address -->
							<td><a class="text-muted" href="mailto:{{ $feed->email }}">{{ $feed->email }}</a></td>

							<!-- Phone Number -->
							<td>{{ $feed->phone }}</td>

							<!-- Subject -->
							<td>{{ $feed->subject }}</td>

							<!-- Message -->
							<td>{{ $feed->message }}</td>

							<!-- status -->
							@if ($feed->is_read)
							<td class="text-center"><span class="label label-default">{{ Lang::get('badges.lang_read') }}</span></td>
							@else 
							<td class="text-center"><span class="label label-success">{{ Lang::get('badges.lang_unread') }}</span></td>
							@endif

							<!-- Date -->
							<td class="text-center">{{ Helper::date_ago($feed->created_at) }}</td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li>
										<a data-popup="tooltip" data-placement="top" data-container="body" title="{{ Lang::get('tooltips.lang_delete_feedback') }}" href="{{ Protocol::home() }}/account/store/feedback/delete/{{ $feed->id }}"><i class="icon-bin"></i></a>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>

				@if ($feedback)
				<div class="text-center mb-15 mt-15">
					{{ $feedback->links() }}
				</div>
				@endif


			</div>
		</div>

	</div>

</div>

@endsection