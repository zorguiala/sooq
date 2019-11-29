@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">

	<!-- Blog -->
    <div class="spec ">
        <h3>{{ Lang::get('update_two.lang_blog') }}</h3>
        <div class="ser-t">
            <b></b>
            <span><i></i></span>
            <b class="line"></b>
        </div>
    </div>

	<!-- Articles -->
	@if (count($articles))
	@foreach ($articles as $article)

	<div class="col-md-4">

		<figure class="snip1529">
  			<div class="blog-img lozad" data-background-image="{{ Protocol::home() }}/application/public/uploads/articles/{{ $article->cover }}">
  			</div>
  			<figcaption class="blog-title">
    			<h3>{{ $article->title }}</h3>
  			</figcaption>
  			<div class="hover"><i class="icon-plus3"></i></div>
  			<a href="{{ Protocol::home() }}/blog/{{ $article->slug }}"></a>
		</figure>

	</div>

	@endforeach
	@else
	@endif

</div>

@endsection