@extends ('dashboard.layout.app')

@section ('content')

<!-- Stores -->
<div class="row">
	
	<div class="col-md-12">

		<!-- Session Messages -->
    	@if (Session::has('error'))
    	<div class="alert alert-danger">
           	{{ Session::get('error') }} 
        </div>
        @endif
        @if (Session::has('success'))
    	<div class="alert alert-success">
           	{{ Session::get('success') }} 
        </div>
        @endif
		
		<div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">إعدادات المخازن</span>
                </div>
            </div>

			<div class="portlet-body">
				<table class="table table-hover table-outline m-b-0 hidden-sm-down">
		            <thead class="thead-default">
		                <tr>
		                    <th class="text-center"><i class="icon-people"></i></th>
		                    <th>Store</th>
		                    <th class="text-center">بلد</th>
		                    <th class="text-center">مدينة</th>
		                    <th class="text-center">عنوان</th>
		                    <th class="text-center">قسم</th>
		                    <th class="text-center">خيارات</th>
		                </tr>
		            </thead>
		            <tbody>

		            	@if ($stores)
		            	@foreach ($stores as $store)

		                <tr>

		                	<!-- Store Cover && Status -->
		                    <td class="text-center">
		                        <div class="avatar">
		                            <img src="{{ $store->logo }}" class="img-avatar" alt="{{ $store->title }}">
		                            @if ($store->status)
                                    <span class="avatar-status tag-success tooltips" data-container="body" data-placement="top" data-original-title="Active Store"></span>
                                    @else
                                    <span class="avatar-status tag-danger tooltips" data-container="body" data-placement="top" data-original-title="Pending Active"></span>
                                    @endif
		                        </div>
		                    </td>

		                    <!-- Store Info -->
		                    <td>
		                        <div><a href="{{ Protocol::home() }}/store/{{ $store->username }}" target="_blank">{{ $store->title }}</a></div>
		                        <div class="small text-muted">
		                            <a class="text-muted" target="_blank" href="{{ Protocol::home() }}/dashboard/users/details/{{ Helper::username_by_id($store->owner_id) }}">{{ Profile::full_name($store->owner_id) }}</a> | {{ Helper::date_ago($store->created_at) }}
		                        </div>
		                    </td>

		                    <!-- Store Country -->
		                    <td class="text-center">
                                <img src="{{ Protocol::home() }}/content/assets/front-end/images/flags/{{ $store->country }}.png" alt="{{ Countries::country_name($store->country) }}" title="{{ Countries::country_name($store->country) }}" style="height:24px;">
                            </td>

                            <!-- City -->
                            <td class="text-center text-muted">
                            	{{ Countries::city_name($store->city) }}
                            </td>

                            <!-- Address -->
                            <td class="text-center text-muted">
                            	@if ($store->address)
                            	{{ $store->address }}
                            	@else 
                            	N/A
                            	@endif
                            </td>

                            <!-- Store Category -->
                            <td class="text-center">
                                <a target="_blank" href="{{ Helper::get_category($store->category, true) }}">
                                    {{ Helper::get_category($store->category) }}
                                </a>
                            </td>
		                    
		                    <!-- Options -->
                            <td class="text-center">
                                <div class="btn-group">
                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/stores/details/{{ $store->username }}">
                                                <i class="glyphicon glyphicon-list-alt"></i> تفاصيل المتجر</a>
                                        </li>
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/stores/edit/{{ $store->username }}">
                                                <i class="glyphicon glyphicon-pencil"></i> تحرير المتجر</a>
                                        </li>
                                        @if ($store->status)
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/stores/inactive/{{ $store->username }}">
                                                <i class="glyphicon glyphicon-remove"></i> متجر غير نشط</a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ Protocol::home() }}/dashboard/stores/active/{{ $store->username }}">
                                                <i class="glyphicon glyphicon-ok"></i> متجر نشط</a>
                                        </li>
                                        @endif
                                        <li class="divider"> </li>
                                        <li>
                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/stores/delete/{{ $store->username }}">
                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف المتجر</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

		                </tr>

		                @endforeach
		                @endif

		            </tbody>
		        </table>

                @if ($stores)
                <div class="text-center">
                    {{ $stores->links() }}
                </div>
                @endif
                    
		    </div>
		</div>

	</div>

</div>

@endsection