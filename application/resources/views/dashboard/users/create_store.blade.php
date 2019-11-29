@extends ('dashboard.layout.app')

@section ('content')

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

        <!-- Create a store -->
        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">Create new store for "{{ $user->username }}"</span>
                </div>
            </div>

            <div class="portlet-body">

                <form method="POST" action="{{ Protocol::home() }}/dashboard/users/{{ $user->username }}/create/store" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}

                    <div class="row">

                        <!-- Store username -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('username') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="username" placeholder="Enter store username" value="{{ old('username') }}" name="username">
                                <label for="username">اسم مستخدم المتجر</label>
                                @if ($errors->has('username'))
                                <span class="help-block">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store title -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('title') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="title" placeholder="Enter store title" value="{{ old('title') }}" name="title">
                                <label for="title">عنوان المتجر</label>
                                @if ($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store short description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('short_desc') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="short_desc" placeholder="Enter store short description" value="{{ old('short_desc') }}" name="short_desc">
                                <label for="short_desc">Store short description</label>
                                @if ($errors->has('short_desc'))
                                <span class="help-block">{{ $errors->first('short_desc') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store long description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('long_desc') ? 'has-error' : '' }}">
                                <textarea rows="5" class="form-control" id="long_desc" name="long_desc" placeholder="Enter store long description">{{ old('long_desc') }}</textarea>
                                <label for="long_desc">Store long description</label>
                                @if ($errors->has('long_desc'))
                                <span class="help-block">{{ $errors->first('long_desc') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store expires after (days) -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('ends_at') ? 'has-error' : '' }}">
                                <input type="number" class="form-control" id="ends_at" placeholder="Store ends after how many days?" value="{{ old('ends_at') }}" name="ends_at">
                                <label for="ends_at">Store expires after (days)</label>
                                @if ($errors->has('ends_at'))
                                <span class="help-block">{{ $errors->first('ends_at') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store Category -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('category') ? 'has-error' :'' }}">
                                <select id="category" class="form-control" name="category">
                                    @if(count(Helper::parent_categories()))
                                    @foreach (Helper::parent_categories() as $parent)
                                    <option value="{{ $parent->id }}" {{ old('category') == $parent->id ? 'selected' : '' }}>-- {{ $parent->category_name }} --</option>
                                    @if (count(Helper::sub_categories($parent->id)))
                                    @foreach (Helper::sub_categories($parent->id) as $sub)
                                    <option {{ old('category') == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
                                    @endforeach
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                                <label for="category">Store category</label>
                                @if ($errors->has('category'))
                                <span class="help-block">{{ $errors->first('category') }}</span>
                                @endif
                            </div> 
                        </div>     

                        <div class="col-md-12">
                            <button type="submit" style="width: 100%" class="btn blue">إنشاء المتجر</button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection