@extends (Theme::get().'.layout.app')

@section ('seo')

{!! SEO::generate() !!}

@endsection

@section ('content')

<div class="row">
	
	<!-- Page Content -->
	<div class="col-lg-10 col-lg-offset-1">

		<!-- Page Header -->
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4>{{ $page->page_name }}</h4>
				<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

				<div class="heading-elements">
					<div class="heading-btn-group pages-btns">
						<a href="{{ config('pages.terms') }}" class="btn btn-link btn-float text-size-small has-text legitRipple"><i style="color: #333 !important;" class="icon-help text-primary"></i> <span>{{ Lang::get('create/ad.lang_terms_of_service') }}</span></a>
						<a href="{{ Protocol::home() }}/contact" class="btn btn-link btn-float text-size-small has-text legitRipple"><i style="color: #333 !important;" class="icon-envelop5 text-primary"></i> <span>{{ Lang::get('footer.lang_contact') }}</span></a>
					</div>
				</div>
			</div>

			<div class="breadcrumb-line"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
				<ul class="breadcrumb">
					<li><a href="{{ Protocol::home() }}">{{ Lang::get('header.lang_home') }}</a></li>
					<li class="active">{{ $page->page_name }}</li>
				</ul>

			</div>
		</div>

		<!-- Page Body -->
		<div class="panel panel-flat">
			
			<div class="panel-body page_content">
				{!! $page->page_content !!}
			</div>

		</div>

	</div>

</div>

@endsection