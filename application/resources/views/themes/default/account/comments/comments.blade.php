@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Account Comments -->
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

		<div class="panel panel-flat">
			
			<div class="table-responsive">
				<table class="table text-nowrap">
					<thead>
						<tr>
							<th>{{ Lang::get('table.lang_ad_details') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_pinned') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_status') }}</th>
							<th class="col-md-2 text-center">{{ Lang::get('table.lang_date') }}</th>
							<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
						</tr>
					</thead>

					<tbody>

						@if ($comments)
						@foreach ($comments as $comment)
						<tr>

							<!-- Ad ID -->
							<td><a target="_blank" href="{{ Protocol::home() }}/vi/{{ $comment->ad_id }}" class="text-default text-semibold">{{ $comment->ad_id }}</a></td>

							<!-- Message Pinned -->
							<td class="text-center">
								@if ($comment->is_pinned)
								<span class="label label-primary">{{ Lang::get('badges.lang_pinned') }}</span>
								@else
								<span class="label label-default">{{ Lang::get('badges.lang_not_pinned') }}</span>
								@endif
							</td>

							<!-- Message Status -->
							<td class="text-center">
								@if ($comment->status)
								<span class="label label-success">{{ Lang::get('badges.lang_published') }}</span>
								@else
								<span class="label label-danger">{{ Lang::get('badges.lang_pending') }}</span>
								@endif
							</td>

							<!-- Date -->
							<td class="text-center"><span class="text-muted">{{ Helper::date_ago($comment->created_at) }}</span></td>

							<!-- Options -->
							<td class="text-center">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="{{ Protocol::home() }}/account/comments/read/{{ $comment->id }}"><i class="icon-eye"></i> {{ Lang::get('options.lang_read_comment') }}</a></li>
											<li><a href="{{ Protocol::home() }}/account/comments/edit/{{ $comment->id }}"><i class="icon-pencil"></i> {{ Lang::get('options.lang_edit_comment') }}</a></li>
											<li class="divider"></li>
											<li><a href="{{ Protocol::home() }}/account/comments/delete/{{ $comment->id }}"><i class="icon-trash"></i> {{ Lang::get('options.lang_delete_comment') }}</a></li>
										</ul>
									</li>
								</ul>
							</td>
						</tr>
						@endforeach
						@endif

					</tbody>
				</table>

				@if ($comments)
				<div class="text-center mb-15 mt-15">
					{{ $comments->links() }}
				</div>
				@endif

			</div>
		</div>

	</div>


</div>

@endsection