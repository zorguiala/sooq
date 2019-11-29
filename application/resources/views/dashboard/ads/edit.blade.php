@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
	<div class="col-md-12">

		<!-- Session Messages -->
        @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif 
		
		<div class="profile">
			<div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue bold uppercase">تحرير الإعلان</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_1_1">
                            <form role="form" action="{{ Protocol::home() }}/dashboard/ads/edit/{{ $ad->ad_id }}" method="POST" enctype="multipart/form-data">

                            	{{ csrf_field() }}

                            	<!-- Ad Title -->
                                <div class="form-group {{ $errors->has('title') ? 'has-error' :'' }}">
                                    <label class="control-label">Title</label>
                                    <input placeholder="Title" value="{{ $ad->title }}" class="form-control" type="text" name="title"> 
                                    @if ($errors->has('title'))
	                                <span class="help-block">{{ $errors->first('title') }}</span>
	                                @endif
                                </div>

                                <!-- Ad Description -->
                                <div class="form-group {{ $errors->has('description') ? 'has-error' :'' }}">
                                    <label class="control-label">Description</label>
                                    <textarea class="form-control" rows="10" placeholder="Description" name="description">{{ $ad->description }}</textarea> 
                                    @if ($errors->has('description'))
	                                <span class="help-block">{{ $errors->first('description') }}</span>
	                                @endif
                                </div>

                                <!-- Ad Category -->
                                <div class="form-group {{ $errors->has('category') ? 'has-error' :'' }}">
                                    <label class="control-label">اختر القسم</label>
                                    <select class="form-control" name="category">
                                        @if(count(Helper::parent_categories()))
                                        @foreach (Helper::parent_categories() as $parent)
                                        <option value="{{ $parent->id }}" {{ $ad->category == $parent->id ? 'selected' : '' }}>-- {{ $parent->category_name }} --</option>
                                        @if (count(Helper::sub_categories($parent->id)))
                                        @foreach (Helper::sub_categories($parent->id) as $sub)
                                        <option {{ $ad->category == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->category_name }}</option>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('category'))
	                                <span class="help-block">{{ $errors->first('category') }}</span>
	                                @endif
                                </div>

                                <!-- Regular Price -->
                                <div class="form-group {{ $errors->has('regular_price') ? 'has-error' :'' }}">
                                    <label class="control-label">Regular Price</label>
                                    <input placeholder="Regular Price" value="{{ $ad->regular_price }}" class="form-control" type="text" name="regular_price"> 
                                    @if ($errors->has('regular_price'))
	                                <span class="help-block">{{ $errors->first('regular_price') }}</span>
	                                @endif
                                </div>

                                <!-- Ad Price -->
                                <div class="form-group {{ $errors->has('price') ? 'has-error' :'' }}">
                                    <label class="control-label">Sale Price</label>
                                    <input placeholder="Sale Price" value="{{ $ad->price }}" class="form-control" type="text" name="price"> 
                                    @if ($errors->has('price'))
                                    <span class="help-block">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>

                                <!-- Currency -->
                                <div class="form-group {{ $errors->has('currency') ? 'has-error' :'' }}">
                                    <label class="control-label">Currency</label>
                                    <select class="form-control" name="currency">
                                    	@foreach (Currencies::database() as $currency)
                                        <option value="{{ $currency->code }}" {{ $ad->currency == $currency->code ? 'selected' : '' }}>{{ $currency->code }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('currency'))
	                                <span class="help-block">{{ $errors->first('currency') }}</span>
	                                @endif
                                </div>

                                <!-- Negotiable -->
                                <div class="form-group {{ $errors->has('negotiable') ? 'has-error' :'' }}">
                                    <label class="control-label">قابل للتفاوض</label>
                                    <select class="form-control" name="negotiable">
                                        @if ($ad->negotiable)
                                        <option value="1">قابل للتفاوض</option>
                                        <option value="0">غير قابل للتفاوض</option>
                                        @else
                                        <option value="0">غير قابل للتفاوض</option>
                                        <option value="1">قابل للتفاوض</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('negotiable'))
                                    <span class="help-block">{{ $errors->first('negotiable') }}</span>
                                    @endif
                                </div>

                                <!-- Condition -->
                                <div class="form-group {{ $errors->has('condition') ? 'has-error' :'' }}">
                                    <label class="control-label">Condition</label>
                                    <select class="form-control" name="condition">
                                    	@if ($ad->is_used)
                                        <option value="1">مستخدم</option>
                                        <option value="0">جديد</option>
                                        @else
                                        <option value="0">جديد</option>
                                        <option value="1">مستخدم</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('condition'))
	                                <span class="help-block">{{ $errors->first('condition') }}</span>
	                                @endif
                                </div>

                                <!-- Status -->
                                <div class="form-group {{ $errors->has('status') ? 'has-error' :'' }}">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" name="status">
                                    	@if ($ad->status)
                                        <option value="1">نشط</option>
                                        <option value="0">غير نشط</option>
                                        @else
                                        <option value="0">غير نشط</option>
                                        <option value="1">نشط</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
	                                <span class="help-block">{{ $errors->first('status') }}</span>
	                                @endif
                                </div>

                                <!-- Featured -->
                                <div class="form-group {{ $errors->has('featured') ? 'has-error' :'' }}">
                                    <label class="control-label">Featured</label>
                                    <select class="form-control" name="featured">
                                    	@if ($ad->is_featured)
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                        @else
                                        <option value="0">لا</option>
                                        <option value="1">نعم</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('featured'))
	                                <span class="help-block">{{ $errors->first('featured') }}</span>
	                                @endif
                                </div>

                                <!-- Archived -->
                                <div class="form-group {{ $errors->has('archived') ? 'has-error' :'' }}">
                                    <label class="control-label">Archived</label>
                                    <select class="form-control" name="archived">
                                    	@if ($ad->is_archived)
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                        @else
                                        <option value="0">لا</option>
                                        <option value="1">نعم</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('archived'))
	                                <span class="help-block">{{ $errors->first('archived') }}</span>
	                                @endif
                                </div>

                                <!-- Youtube -->
                                <div class="form-group {{ $errors->has('youtube') ? 'has-error' :'' }}">
                                    <label class="control-label">Youtube Video</label>
                                    <input placeholder="Youtube Video" value="{{ $ad->youtube }}" class="form-control" type="text" name="youtube"> 
                                    @if ($errors->has('youtube'))
                                    <span class="help-block">{{ $errors->first('youtube') }}</span>
                                    @endif
                                </div>

                                <!-- Affiliate Link -->
                                <div class="form-group {{ $errors->has('affiliate_link') ? 'has-error' :'' }}">
                                    <label class="control-label">اضف لينك</label>
                                    <input placeholder="Amazon, eBay, Aliexpress... Affiliate link here" value="{{ $ad->affiliate_link }}" class="form-control" type="text" name="affiliate_link"> 
                                    @if ($errors->has('affiliate_link'))
                                    <span class="help-block">{{ $errors->first('affiliate_link') }}</span>
                                    @endif
                                </div>

                                <!-- Photos Uploader -->
                                <div class="images-uploader-box">
                                    <ul>
                                        @if (Profile::hasStore(Auth::id()))
                                            @php 
                                                $maxImages = Helper::settings_membership()->pro_ad_images;
                                            @endphp
                                        @else 
                                            @php 
                                                $maxImages = Helper::settings_membership()->free_ad_images;
                                            @endphp
                                        @endif
            
                                        @for ($i = 1; $i <= $maxImages; $i++)
                                        <li>
                                            <div class="images-uploader-item">

                                                    <div style="top:37%; height: 100%">
                                                        <a href="#" class="images-uploader-item-addphoto">
                                                            <i class="icon-plus3"></i>
                                                            <input onchange="uploaderGetPreview(this)" id="uploaderImageId{{ $i }}" class="images-uploader-input" name="photos[]" type="file" accept="image/*" style="top: -10px;right: -40px;position: absolute;cursor: pointer;opacity: 0;font-size: 100px;" />
                                                        </a>
                                                    </div>

                                                    <div class="images-uploader-nav-panel" id="remove-icon-uploaderImageId{{ $i }}"  onclick="uploaderRemovePreview(this)" data-input-id="uploaderImageId{{ $i }}">
                                                        <i class="icon-cross2 images-uploader-remove-icon"></i>
                                                    </div>

                                                    <div class="images-uploader-preview" id="uploaderImageId{{ $i }}Preview"></div>
                                            </div>
                                        </li>
                                        @endfor
                                    </ul>
                                </div>

                                <!-- Old Images -->
                                <div>
                                    <ul style="list-style: none;padding-left: 0" class="row">
                                        @for ($j=0; $j<= $ad->photos_number; $j++)
                                        <li class="col-sm-6 col-md-3" style="margin-bottom: 20px;">
                                            <a href="{{ Protocol::home() }}/application/public/uploads/images/{{ $ad->ad_id }}/previews/preview_{{ $j }}.jpg" target="_blank">
                                                <div style="background-image: url({{ Protocol::home() }}/application/public/uploads/images/{{ $ad->ad_id }}/previews/preview_{{ $j }}.jpg);height: 90px;width: 100%;border-radius: 5px !important;background-position: 50%;background-size: cover;"></div>
                                            </a>
                                        </li>
                                        @endfor
                                    </ul>
                                </div>

                                <div class="margiv-top-10">
                                    <button type="submit" class="btn default" style="width: 100%;text-transform: uppercase;"> تحديث الإعلان </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
		</div>

	</div>
</div>

@endsection