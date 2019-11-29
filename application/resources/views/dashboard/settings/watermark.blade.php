@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
	
	<div class="col-md-12">

        <!-- Session Messages -->
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }} 
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }} 
        </div>
        @endif
		
		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">Watermark Settings</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ Protocol::home() }}/dashboard/settings/watermark" method="POST" enctype="multipart/form-data">
                	{{ csrf_field() }}

                	<!-- Watermark Position -->
                    <div class="form-group">
                        <label class="control-label">Watermark Position</label>
                        <select class="form-control {{ $errors->has('position') ? 'has-error' : '' }}" name="position">
                            @if ($watermark->position == "top_right")
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="bottom_left">أسفل اليسار</option>
                            <option value="center">وسط</option>
                            @elseif ($watermark->position == "top_left")
                            <option value="top_left">أعلى اليسار</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="bottom_left">أسفل اليسار</option>
                            <option value="center">وسط</option>
                            @elseif ($watermark->position == "bottom_right")
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_left">أسفل اليمين</option>
                            <option value="center">وسط</option>
                            @elseif ($watermark->position == "bottom_left")
                            <option value="bottom_left">أسفل اليمين</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="center">وسط</option>
                            @else 
                            <option value="center">وسط</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="bottom_left">أسفل اليمين</option>
                            @endif
                        </select>
                        @if ($errors->has('position'))
                        <span class="help-block">
                            {{ $errors->first('position') }}
                        </span>
                        @endif
                    </div>

                    <!-- Watermark Opacity -->
                    <div class="form-group {{ $errors->has('opacity') ? 'has-error' : '' }}">
                        <label class="control-label">Watermark Opacity</label>
                        <select class="form-control" name="opacity">
                            @if ($watermark->opacity == 25)
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <option value="100">100%</option>
                            @elseif ($watermark->opacity == 50)
                            <option value="50">50%</option>
                            <option value="25">25%</option>
                            <option value="75">75%</option>
                            <option value="100">100%</option>
                            @elseif ($watermark->opacity == 75)
                            <option value="75">75%</option>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="100">100%</option>
                            @else
                            <option value="100">100%</option>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            @endif
                        </select>
                        @if ($errors->has('opacity'))
                        <span class="help-block">
                            {{ $errors->first('opacity') }}
                        </span>
                        @endif
                    </div>

                    <!-- Enable Watermark -->
                    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                        <label class="control-label">تمكين Watermark</label>
                        <select class="form-control" name="is_active">
                            @if ($watermark->is_active)
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            @else 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            @endif
                        </select>
                        @if ($errors->has('is_active'))
                        <span class="help-block">
                            {{ $errors->first('is_active') }}
                        </span>
                        @endif
                    </div>

					<!-- Upload Watermark -->
                    <div class="form-group {{ $errors->has('watermark') ? 'has-error' : '' }}">
                        <label class="control-label">تحميل Watermark</label>
                        <input type="file" name="watermark"/>
                        @if ($errors->has('watermark'))
                        <span class="help-block">
                            {{ $errors->first('watermark') }}
                        </span>
                        @endif 
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

@endsection