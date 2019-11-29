@extends ('dashboard.layout.app')

@section ('content')

<!-- Edit Store -->
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
                    <span class="caption-subject font-blue bold uppercase">Edit "{{ $store->title }}" Store</span>
                </div>
            </div>

			<div class="portlet-body">
				
                <form method="POST" action="{{ Protocol::home() }}/dashboard/stores/edit/{{ $store->username }}" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}

                    <div class="row">

                        <!-- Store Title -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('title') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="title" placeholder="Enter store title" value="{{ $store->title }}" name="title">
                                <label for="title">عنوان المتجر</label>
                                @if ($errors->has('title'))
                                <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store Username -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('username') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="username" placeholder="Enter store username" value="{{ $store->username }}" name="username">
                                <label for="username">اسم المستخدم</label>
                                @if ($errors->has('username'))
                                <span class="help-block">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('short_desc') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="short_desc" placeholder="Enter short description" value="{{ $store->short_desc }}" name="short_desc">
                                <label for="short_desc">وصف قصير</label>
                                @if ($errors->has('short_desc'))
                                <span class="help-block">{{ $errors->first('short_desc') }}</span>
                                @endif
                            </div>
                        </div>
    
                        <!-- Long Description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('long_desc') ? 'has-error' : '' }}">
                                <textarea rows="4" class="form-control" id="long_desc" placeholder="Enter long description" name="long_desc">{{ $store->long_desc }}</textarea>
                                <label for="long_desc">وصف طويل</label>
                                @if ($errors->has('long_desc'))
                                <span class="help-block">{{ $errors->first('long_desc') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store Category -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('category') ? 'has-error' : '' }}">
                                 <select class="form-control" id="category" name="category">
                                    <option></option>
                                    @if(count(Helper::parent_categories()))
                                    @foreach (Helper::parent_categories() as $parent)
                                    <optgroup label="{{ $parent->category_name }}">
                                        @if (count(Helper::sub_categories($parent->id)))
                                        @foreach (Helper::sub_categories($parent->id) as $sub)
                                        <option {{ $store->category == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                    @endforeach
                                    @endif
                                </select>
                                <label for="category">فئة المتجر</label>
                                @if ($errors->has('category'))
                                <span class="help-block">{{ $errors->first('category') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('status') ? 'has-error' : '' }}">
                                 <select class="form-control" id="status" name="status">
                                    @if ($store->status)
                                    <option value="1">نشيط</option>
                                    <option value="0">غير نشط</option>
                                    @else 
                                    <option value="0">غير نشط</option>
                                    <option value="1">نشيط</option>
                                    @endif
                                </select>
                                <label for="status">Store Status</label>
                                @if ($errors->has('status'))
                                <span class="help-block">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Change Logo -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('logo') ? 'has-error' : '' }}">
                                <input accept="image/*" type="file" name="logo" class="form-control" id="logo">
                                <label for="logo">تحرير الشعار</label>
                                @if ($errors->has('logo'))
                                <span class="help-block">{{ $errors->first('logo') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Change Cover -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input {{ $errors->has('cover') ? 'has-error' : '' }}">
                                <input accept="image/*" type="file" name="cover" class="form-control" id="cover">
                                <label for="cover">تحرير الغلاف</label>
                                @if ($errors->has('cover'))
                                <span class="help-block">{{ $errors->first('cover') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Store Address -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('address') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="address" placeholder="Enter store address" value="{{ $store->address }}" name="address">
                                <label for="address">عنوان المحل</label>
                                @if ($errors->has('address'))
                                <span class="help-block">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div> 

                        <!-- Facebook Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('fb_page') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="fb_page" placeholder="Enter facebook page" value="{{ $store->fb_page }}" name="fb_page">
                                <label for="fb_page">Facebook صفحة</label>
                                @if ($errors->has('fb_page'))
                                <span class="help-block">{{ $errors->first('fb_page') }}</span>
                                @endif
                            </div>
                        </div> 

                        <!-- Twitter Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('tw_page') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="tw_page" placeholder="Enter twitter page" value="{{ $store->tw_page }}" name="tw_page">
                                <label for="tw_page">Twitter صفحة</label>
                                @if ($errors->has('tw_page'))
                                <span class="help-block">{{ $errors->first('tw_page') }}</span>
                                @endif
                            </div>
                        </div> 

                        <!-- Google Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('go_page') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="go_page" placeholder="Enter google page" value="{{ $store->go_page }}" name="go_page">
                                <label for="fb_page">Google صفحة</label>
                                @if ($errors->has('go_page'))
                                <span class="help-block">{{ $errors->first('go_page') }}</span>
                                @endif
                            </div>
                        </div> 

                        <!-- Youtube Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('yt_page') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="yt_page" placeholder="Enter youtube page" value="{{ $store->yt_page }}" name="yt_page">
                                <label for="fb_page">Youtube صفحة</label>
                                @if ($errors->has('yt_page'))
                                <span class="help-block">{{ $errors->first('yt_page') }}</span>
                                @endif
                            </div>
                        </div> 

                        <!-- Website -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('website') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="website" placeholder="Enter website" value="{{ $store->website }}" name="website">
                                <label for="fb_page">موقع الكتروني</label>
                                @if ($errors->has('website'))
                                <span class="help-block">{{ $errors->first('website') }}</span>
                                @endif
                            </div>
                        </div>                      

                        <div class="col-md-12">
                            <button style="width: 100%" type="submit" class="btn default">تحديث المتجر</button>
                        </div>

                    </div>

                </form>

		    </div>
		</div>

	</div>

</div>

@endsection