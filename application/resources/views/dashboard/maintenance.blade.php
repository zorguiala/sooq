@extends ('dashboard.layout.app')

@section ('content')

<!-- Maintenance Mode -->
<div class="row">

	<div class="col-md-12">
		
		<!-- Session Messages -->
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }} 
        </div>
        @endif

        <!-- Session Messages -->
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }} 
        </div>
        @endif

		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">وضع الصيانة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/maintenance" method="POST">

                	{{ csrf_field() }}


					<p class="text-muted">
						While in maintenance mode, users can't access your website. Useful if you need to make changes on your website. Use the following button to toggle maintenance mode ON/OFF.<br><br>
						Maintenance mode is: <b>{{ $maintenance->is_maintenance ? 'ON' : 'OFF' }}</b> 
                        @if($maintenance->is_maintenance)
                        <br><br>
                        Disable maintenance(Reserve Link): <b><a href="{{ Protocol::home() }}/maintenance?token={{ config('maintenance.token') }}" target="_blank">{{ Protocol::home() }}/maintenance?token={{ config('maintenance.token') }}</a></b><br>
                        <span class="help-block text-danger">You need to save this link, In case you can't access dashboard to disable maintenance.</span>
                        @endif
					</p>

                    @if(!$maintenance->is_maintenance)
                    <input type="hidden" name="maintenance" value="1">
                    @else
                    <input type="hidden" name="maintenance" value="0">
                    @endif

					<hr>

					<!-- Enable/Disable -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn blue">{{ $maintenance->is_maintenance ? 'Disable Maintenance Mode' : 'Enable Maintenance Mode' }} </button>
                    </div>

                </form>
            </div>
        </div>

	</div>

</div>

@endsection