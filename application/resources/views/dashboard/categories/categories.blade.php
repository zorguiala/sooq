@extends ('dashboard.layout.app')

@section ('content')

<!-- Categories -->
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
                    <span class="caption-subject font-blue bold uppercase">إعدادات الأقسام</span>
                </div>
                <div class="actions">
                	<a href="{{ Protocol::home() }}/dashboard/categories/create" class="btn dark btn-outline sbold uppercase">إنشاء قسم</a>
                </div>
            </div>

			<div class="portlet-body">

				<div class="table">
					<table class="table table-hover table-outline m-b-0 hidden-sm-down">
			            <thead class="thead-default">
			                <tr>
			                    <th class="text-center"><i class="icon-link"></i></th>
			                    <th>قسم</th>
			                    <th>Parent</th>
			                    <th class="text-center">نوع القسم</th>
			                    <th class="text-center">أنشئت في</th>
			                    <th class="text-center">مجموع الإعلانات</th>
			                    <th class="text-center">خيارات</th>
			                </tr>
			            </thead>
			            <tbody>

							@if (count($categories))
							@foreach ($categories as $category)
			                <tr>

			                	<!-- Category ID -->
			                    <td class="text-center text-muted">
			                        {{ $category->id }}
			                    </td>

			                    <td class="text-muted">
			                    	<strong>{{Helper::get_category($category->id)}}</strong>
			                    </td>
			                    <td class="text-muted">
			                    	@if ($category->is_sub)
			                    	<strong>{{ Helper::get_category($category->parent_category) }}</strong>
			                    	@else 
			                    	N/A
			                    	@endif
			                    </td>

								<!-- Category type -->
								<td class="text-center">
									@if ($category->is_sub)
									<span class="badge badge-success badge-roundless"> القسم الفرعي </span>
									@else 
									<span class="badge badge-danger badge-roundless"> القسم الرئيسي </span>
									@endif
								</td>

			                    <td class="text-center text-muted">
			                        {{ Helper::date_ago($category->created_at) }}
			                    </td>
			                    <td class="text-center text-muted">
			                        {{ Helper::count_ads_by_category($category->id) }}
			                    </td>
			                    <!-- Options -->
	                            <td class="text-center">
	                                <div class="btn-group">
	                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li>
	                                            <a href="{{ Protocol::home() }}/dashboard/categories/edit/{{ $category->id }}">
	                                                <i class="glyphicon glyphicon-pencil"></i> تحرير القسم</a>
	                                        </li>
	                                        <li class="divider"> </li>
	                                        <li>
	                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/categories/delete/{{ $category->id }}">
	                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف القسم</a>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </td>
			                </tr>
			                @endforeach
			                @endif

			            </tbody>
			        </table>

					@if (count($categories) > 0)
					<div class="text-center">
						{{ $categories->links() }}
					</div>
					@endif

		        </div>

		    </div>
		</div>

	</div>

</div>

@endsection