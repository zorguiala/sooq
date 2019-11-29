@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
	<div class="col-md-9">

		<!-- Post -->
		<div class="panel">
			<div class="panel-body">
				<div class="content-group-lg">
					<div class="content-group text-center">
						<a href="#" class="display-inline-block">
							<img data-src="{{ Protocol::home() }}/application/public/uploads/articles/{{ $article->cover }}" class="lozad img-responsive" alt="">
						</a>
					</div>

					<h3 class="text-semibold mb-5">
						<a href="#" class="text-default">{{ $article->title }}</a>
					</h3>

					<ul class="list-inline list-inline-separate text-muted content-group">
						<li>By <a href="#" class="text-muted">{{ Profile::full_name_by_username($article->username) }}</a></li>
						<li>{{ Helper::date_string($article->created_at) }}</li>
					</ul>

					<div class="content-group">
						{!! $article->content !!}
					</div>
				</div>
				
			</div>
		</div>
		<!-- /post -->

	</div>


	<div class="col-md-3">
		
		<div class="sidebar sidebar-default sidebar-separate">
			<div class="sidebar-content">


				<!-- Share -->
				<div class="sidebar-category">
					<div class="category-title">
						<span>Share</span>
					</div>

					<div class="category-content no-padding-bottom text-center">
						<ul class="list-inline no-margin">
							<li>
								<a href="https://www.facebook.com/sharer.php?u={{ Protocol::home() }}/blog/{{ $article->slug }}" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-facebook"></i>
								</a>
							</li>
							<li>
								<a href="https://twitter.com/share?url={{ Protocol::home() }}/blog/{{ $article->slug }}&text={{ $article->title }}" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-twitter"></i>
								</a>
							</li>
							<li>
								<a href="https://plus.google.com/share?url={{ Protocol::home() }}/blog/{{ $article->slug }}" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-google-plus"></i>
								</a>
							</li>
							<li>
								<a href="https://www.stumbleupon.com/submit?url={{ Protocol::home() }}/blog/{{ $article->slug }}&title={{ $article->title }}" target="_blank" class="btn bg-green btn-icon content-group">
									<i class="icon-stumbleupon"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /share -->

			</div>
		</div>

		<!-- Advertisements -->
		@if (Helper::ifCanSeeAds())
		<div class="advertisment">
			{!! Helper::advertisements()->ad_sidebar !!}
		</div>
		@endif

	</div>
</div>

@endsection