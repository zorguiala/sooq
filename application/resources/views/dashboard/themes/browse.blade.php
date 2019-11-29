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

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">اختيار موضوع</span>
                </div>
            </div>

            <div class="portlet-body">
                
                <form method="POST" action="{{ Protocol::home() }}/dashboard/themes">
                    
                    {{ csrf_field() }}

                    <div class="form-group form-md-line-input {{ $errors->has('theme') ? 'has-error' : '' }}">
                        <select class="form-control" id="theme" name="theme">
                            @foreach ($themes as $theme)
                            <option {{ (config('view.theme') == basename($theme)) ? "selected" : ""  }} value="{{ basename($theme) }}">{{ basename($theme) }}</option>
                            @endforeach
                        </select>
                        <label for="theme">اختيار موضوع</label>
                        @if ($errors->has('theme'))
                        <span class="help-block">{{ $errors->first('theme') }}</span>
                        @endif
                    </div>                 

                    <button type="submit" class="btn default btn-block">تحديث</button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection