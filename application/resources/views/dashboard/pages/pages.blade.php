@extends ('dashboard.layout.app')

@section ('content')

<!-- Pages -->
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
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">إعدادات الصفحات</span>
                </div>
                <div class="actions">
                	<a href="{{ Protocol::home() }}/dashboard/pages/create" class="btn dark btn-outline sbold uppercase">انشاء صفحة</a>
                </div>
            </div>

			<div class="portlet-body">
				<table class="table table-hover table-outline m-b-0 hidden-sm-down">
		            <thead class="thead-default">
		                <tr>
		               		<th class="text-center"><i class="icon-link"></i></th>
		                    <th class="text-center">اسم الصفحة</th>
		                    <th class="text-center">الصفحة</th>
		                    <th class="text-center"> Footer ودجت </th>
		                    <th class="text-center">أنشئت في</th>
		                    <th class="text-center">خيارات</th>
		                </tr>
		            </thead>
		            <tbody>

						@if ($pages)
						@foreach ($pages as $page)
		                <tr>

		                	<!-- Pages ID -->
		                	<td class="text-center text-muted">
		                		{{ $page->id }}
		                	</td>

		                	<!-- Page Name -->
		                    <td class="text-center">
		                        <a class="text-muted" href="{{ Protocol::home() }}/page/{{ $page->page_slug }}" target="_blank">{{ $page->page_name }}</a>
		                    </td>

		                    <!-- Page Slug -->
		                    <td class="text-center text-muted">
		                        {{ $page->page_slug }}
		                    </td>

		                    <!-- Page Widget -->
		                    <td class="text-center text-muted">
		                        {{ Config::get('pages.'.$page->page_col) }}
		                    </td>

		                    <!-- Date -->
		                    <td class="text-center text-muted">
		                        {{ Helper::date_ago($page->created_at) }}
		                    </td>

		                    <!-- Options -->
		                    <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/pages/edit/{{ $page->page_slug }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير الصفحة</a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/pages/delete/{{ $page->page_slug }}">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف الصفحة</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

		                </tr>
		                @endforeach
		                @endif

		            </tbody>
		        </table>

		        @if ($pages)
                <div class="text-center">
                    {{ $pages->links() }}
                </div>
                @endif
                
		    </div>
		</div>

	</div>

</div>

@endsection