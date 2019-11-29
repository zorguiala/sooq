@extends ('dashboard.layout.app')

@section ('content')

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
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <span class="caption-subject font-blue-madison bold uppercase"> منع IP الجديد</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="{{ Protocol::home() }}/dashboard/firewall/add" method="POST">
                	{{ csrf_field() }}
                    <div class="form-body">

                    	<!-- IP Address -->
                        <div class="form-group form-md-line-input {{ $errors->has('ip_address') ? 'has-error' :'' }}">
                            <label class="col-md-2 control-label" for="ip_address">عنوان IP</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="ip_address" placeholder="IP Address" name="ip_address" value="{{ old('ip_address') }}">
                                <div class="form-control-focus"> </div>
                                @if ($errors->has('ip_address'))
                                <span class="help-block">{{ $errors->first('ip_address') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">اضافة IP</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

@endsection