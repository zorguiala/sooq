@extends ('dashboard.layout.app')

@section ('head')
{!! Charts::assets() !!}
@endsection

@section ('content')

<!-- Ad Stats -->
<div class="row">
	
	<!-- Ad Visits -->
	<div class="col-md-12">
		
		<div class="portlet light " style="float: left;width: 100%">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">إحصائيات الإعلان</span>
                </div>
            </div>

            <div class="portlet-body">

            	<!-- Ad Visits -->
            	<div style="border: 1px solid #dadada;margin-bottom: 20px;">
            		{!! $visits->render() !!}
            	</div>

            	<!-- Countries -->
            	<div style="border: 1px solid #dadada;margin-bottom: 20px;">
            		{!! $countries->render() !!}
            	</div>

            	<!-- browsers -->
            	<div class="col-md-6" style="border: 1px solid #dadada;margin-bottom: 20px;">
            		{!! $browsers->render() !!}
            	</div>

            	<!-- platforms -->
            	<div class="col-md-6" style="border: 1px solid #dadada;margin-bottom: 20px;">
            		{!! $platforms->render() !!}
            	</div>

            	<!-- Other stats -->
                <div class="table-scrollable">
                	<table class="table table-hover table-outline m-b-0 hidden-sm-down">
                        <thead class="thead-default">
                            <tr>
                                <th class="text-center">بلد</th>
                                <th>Region</th>
                                <th>City</th>
                                <th>Browser</th>
                                <th>Platform</th>
                                <th class="text-center">إنسان آلي</th>
                                <th class="text-center">جهاز</th>
                                <th>اسم الجهاز</th>
                                <th>الإحالات</th>
                                <th>الكلمة</th>
                                <th class="text-center">النشاط الاخير</th>
                            </tr>
                        </thead>
                        <tbody>

                        	@if($other_stats)
                        	@foreach ($other_stats as $stat)
                        	<tr>

                        		<!-- Country -->
                                <td class="text-center">
                                    <img src="{{ Protocol::home() }}/content/assets/front-end/images/flags/{{ $stat->country }}.png" alt="{{ Countries::country_name($stat->country) }}" data-container="body" data-placement="top" data-original-title="{{ Countries::country_name($stat->country) }}" class="tooltips" style="height:24px;">
                                </td>

                                <!-- Region -->
                                <td class="text-muted">
                                	@if ($stat->region)
                        			{{ $stat->region }}
                        			@else 
                        			N/A
                        			@endif
                        		</td>

                                <!-- City -->
                                <td class="text-muted">
                                    @if ($stat->city)
                                    {{ $stat->city }}
                                    @else 
                                    N/A
                                    @endif
                                </td>

                        		<!-- Browser -->
                                <td class="text-muted">
                        			{{ $stat->browserName }} {{ $stat->browserVersion }}
                        		</td>

                        		<!-- Platform -->
                                <td class="text-muted">
                        			{{ $stat->platformName }} {{ $stat->platformVersion }}
                        		</td>

                        		<!-- Roboto -->
                        		<td class="text-center">
                        			@if ($stat->isRobot)
                        			<span class="badge badge-info badge-roundless"> {{ $stat->robotName }} </span>
                        			@else
                        			<span class="text-muted">N/A</span>
                        			@endif
                        		</td>

                        		<!-- Device -->
                        		<td class="text-center">
                        			@if ($stat->isDesktop)
                        			<span class="badge badge-default badge-roundless"> سطح المكتب </span>
                        			@else
                        			<span class="badge badge-default badge-roundless"> هاتف </span>
                        			@endif
                        		</td>

                        		<!-- Device Name -->
                                <td class="text-muted">
                                	@if ($stat->deviceName)
                        			{{ $stat->deviceName }}
                        			@else 
                        			N/A
                        			@endif
                        		</td>

                        		<!-- Referrer -->
                                <td class="text-muted">
                                	@if($stat->referrer)
                        			{{ $stat->referrer }}
                        			@else 
                        			N/A
                        			@endif
                        		</td>

                        		<!-- Referrer Keyword -->
                                <td class="text-muted">
                                	@if($stat->referrer_keyword)
                        			{{ $stat->referrer_keyword }}
                        			@else 
                        			N/A
                        			@endif
                        		</td>

                        		<!-- Last Activity -->
                                <td class="text-muted">
                        			{{ Helper::date_ago($stat->created_at) }}
                        		</td>
                        		
                        	</tr>
                        	@endforeach
                        	@endif

                        </tbody>
                    </table>
                </div>

                @if ($other_stats)
                <div class="text-center">
                	{{ $other_stats->links() }}
                </div>
                @endif
				
			</div>

		</div>

	</div>

</div>

@endsection