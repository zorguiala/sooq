@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<!-- Edit comment -->
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

		<div class="panel panel-flat">

			<form class="form-horizontal" action="{{ Protocol::home() }}/account/comments/edit/{{ $comment->id }}" method="POST">

				{{ csrf_field() }}

				<div class="panel panel-flat">

					<div class="panel-body">

						<!-- Comment Content -->
						<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
							<label style="width: 100%; margin-bottom: 10px;">{{ Lang::get('account/comments/edit.lang_edit_comment') }}</label>
							<div class="col-lg-12">
								<textarea rows="5" cols="5" class="form-control" placeholder="Enter your comment here" name="content">{{ $comment->content }}</textarea>
								@if ($errors->has('content'))
								<span class="help-block">{{ $errors->first('content') }}</span>
								@endif
							</div>
						</div>

						<button type="submit" class="btn btn-primary heading-btn pull-right">{{ Lang::get('account/comments/edit.lang_update_comment') }}</button>

					</div>

				</div>

		</div>

	</div>

</div>

@endsection