@extends ('dashboard.layout.app')

@section ('content')

<!-- Currencies -->
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
                    <span class="caption-subject font-blue bold uppercase">اعدادات العملات</span>
                </div>
                <div class="actions">
                	<a href="{{ Protocol::home() }}/dashboard/currencies/create" class="btn dark btn-outline sbold uppercase">إنشاء عملة</a>
                </div>
            </div>

			<div class="portlet-body">

				<div class="">
					<table class="table table-hover table-outline m-b-0 hidden-sm-down">
			            <thead class="thead-default">
			                <tr>
			                    <th class="text-center"><i class="icon-link"></i></th>
			                    <th>Country</th>
			                    <th>Currency Code</th>
			                    <th>Currency Locale</th>
			                    <th class="text-center">Options</th>
			                </tr>
			            </thead>
			            <tbody>

							@if (count($currencies))
							@foreach ($currencies as $currency)
			                <tr>

			                	<!-- Currency ID -->
			                    <td class="text-center text-muted">
			                        {{ $currency->id }}
			                    </td>

								<!-- Currency Country -->
			                    <td class="text-muted">
			                    	<strong>{{Countries::country_by_id($currency->country_id)}}</strong>
			                    </td>

			                    <!-- Currency Code -->
			                    <td class="text-muted">
			                    	{{ $currency->code }}
			                    </td>

			                    <!-- Currency locale -->
			                    <td class="text-muted">
			                    	{{ $currency->locale }}
			                    </td>

			                    <!-- Options -->
	                            <td class="text-center">
	                                <div class="btn-group">
	                                    <i style="color: #405a72;font-size: 18px;cursor: pointer;" class="icon-settings dropdown-toggle" data-toggle="dropdown"></i>

	                                    <ul class="dropdown-menu pull-right" role="menu">
	                                        <li>
	                                            <a href="{{ Protocol::home() }}/dashboard/currencies/edit/{{ $currency->code }}">
	                                                <i class="glyphicon glyphicon-pencil"></i> تحرير العملة</a>
	                                        </li>
	                                        <li class="divider"> </li>
	                                        <li>
	                                            <a style="color: #dd2c2c;text-transform: uppercase;" href="{{ Protocol::home() }}/dashboard/currencies/delete/{{ $currency->code }}">
	                                                <i style="color: #dd2c2c;" class="glyphicon glyphicon-trash"></i> حذف العملة</a>
	                                        </li>
	                                    </ul>
	                                </div>
	                            </td>
			                </tr>
			                @endforeach
			                @endif

			            </tbody>
			        </table>

					@if (count($currencies) > 0)
					<div class="text-center">
						{{ $currencies->links() }}
					</div>
					@endif

		        </div>

		    </div>
		</div>

	</div>

</div>

@endsection