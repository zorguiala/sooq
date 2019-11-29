@extends ('dashboard.layout.app')

@section ('content')

<!-- Articles -->
<div class="row">
	
	<div class="col-md-12">

		<!-- Sessions Messages -->
        @if (Session::has('success'))
        <div class="custom-alerts alert alert-success fade in">
            {{ Session::get('success') }}
        </div>
        @endif

        @if (Session::has('error'))
        <div class="custom-alerts alert alert-danger fade in">
            {{ Session::get('error') }}
        </div>
        @endif
		
		<div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">اعدادات المقالات</span>
                </div>
                <div class="actions">
                	<a href="{{ Protocol::home() }}/dashboard/articles/create" class="btn dark btn-outline sbold uppercase">إنشاء مقاله</a>
                </div>
            </div>

			<div class="portlet-body">

				<div class="">
					<table class="table table-hover table-outline m-b-0 hidden-sm-down">
			            <thead class="thead-default">
			                <tr>
			                    <th class="text-center"><i class="icon-link"></i></th>
			                    <th>عنوان</th>
			                    <th class="text-center">غلاف</th>
			                    <th class="text-center">أنشئت في</th>
			                    <th class="text-center">تم التحديث في</th>
			                    <th class="text-center">خيارات</th>
			                </tr>
			            </thead>
			            <tbody>

							@if (count($articles))
							@foreach ($articles as $article)
			                <tr>

			                	<!-- Articles ID -->
			                    <td class="text-center text-muted">
			                        {{ $article->id }}
			                    </td>

			                    <!-- Title -->
			                    <td class="text-muted">
			                    	<a href="{{ Protocol::home() }}/blog/{{ $article->slug }}" class="text-muted" target="_blank">{{ $article->title }}</a>
			                    </td>

			                    <!-- Cover -->
			                    <td class="text-center">
			                    	<a class="text-muted" href="{{ Protocol::home() }}/application/public/uploads/articles/{{ $article->cover }}">عرض الغلاف
</a>
			                    </td>

			                    <!-- Created at -->
			                    <td class="text-muted text-center"> 
			                    	{{ Helper::date_ago($article->created_at) }}
			                    </td>

			                    <!-- Updated at -->
			                    <td class="text-muted text-center"> 
			                    	{{ Helper::date_ago($article->updated_at) }}
			                    </td>

			                    <!-- Options -->
	                            <td class="text-center">
	                                <div class="btn-group">
	                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li>
	                                            <a href="{{ Protocol::home() }}/dashboard/articles/edit/{{ $article->id }}">
	                                                <i class="glyphicon glyphicon-pencil"></i> تحرير المقالة</a>
	                                        </li>
	                                        <li>
	                                            <a href="{{ Protocol::home() }}/dashboard/articles/delete/{{ $article->id }}">
	                                                <i class="glyphicon glyphicon-trash"></i> حذف المقالة</a>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </td>
			                </tr>
			                @endforeach
			                @endif

			            </tbody>
			        </table>

					@if (count($articles) > 0)
					<div class="text-center">
						{{ $articles->links() }}
					</div>
					@endif

		        </div>

		    </div>
		</div>

	</div>

</div>

@endsection