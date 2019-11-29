@extends (Theme::get().'.layout.app')



@section ('seo')



{!! SEO::generate() !!}



@endsection



@section ('content')



<div class="row">

	

	<!-- Sub Categories -->

	<div class="col-md-12">



		<!-- Browse By Countries -->
        <div class="block-title" style="    text-align: center;">
				<h3><span>{{ $parent_category->category_name }}</span></h3>
			</div>


						</div>

			


        @if(count($sub_categories))



        <div class="row" DIR="RTL">


            <div class="ui horizontal segments col-md-12" style="margin: 0px; border:0px; box-shadow: 0 0 0 0;  text-align: center;">
                <div class="row ui  centered grid" >
            @foreach ($sub_categories as $category)
                
            

                
                    <div class="ui segment col-md-2 col-sm-3 col-xs-6" style="margin:0px;    border-radius: 0;                    box-shadow: 0 0 0 0;">
        
                        <div class="imgover">
                            <img src="{{ $category->icon }}" width="50" alt="">
                        </div>
        
                        <a class="menuu" href="{{ Protocol::home() }}/category/{{ $parent_category->category_slug }}/{{ $category->category_slug }}">
                            {{ $category->category_name }}</a>
        
                    </div>
                



            
            
            @endforeach
        </div>
    </div>

        </div>



        @else



        <!-- Nothing to show right now -->

		<div class="alert bg-info alert-styled-left">

		@lang ('return/info.lang_nothing_to_show')

    	</div>



        @endif



	</div>



    <!-- Latest Ads -->

    <div class="col-md-12 container">



        <div class="row ui  centered grid">


            @if (count($latest_ads))

            @foreach ($latest_ads as $ad)



            <div class="ui card card_sm" style=" @if ($ad->is_featured)  border: 1px solid #ff000069;  @endif width: 260px;"
                dir="ltr">
                <div class="content">
            
                    <a class="right floated "
                        href="{{ Profile::hasStore($ad->user_id) ? Protocol::home().'/store/'.Profile::hasStore($ad->user_id)->username : '#' }}">
                        <div class="namecard">{{$ad->user_name{0}->first_name}} {{$ad->user_name{0}->last_name}}</div>
                        <img style="border: 1px solid green;" class="ui avatar image" src="{{ Profile::picture($ad->user_id) }}"
                            title="{{ Lang::get('update_two.lang_verified_account') }}"
                            alt="{{ Profile::hasStore($ad->user_id) ? Profile::hasStore($ad->user_id)->title : Profile::full_name($ad->user_id) }}">
            
                    </a>
                    <div class="meta">{{$ad->timeleft}}</div>
                </div>
                <a href="{{ Protocol::home() }}/listing/{{ $ad->slug }}"
                    {{ !is_null($ad->affiliate_link) ? 'target="_blank"' : '' }}">
                </a>
                <div class="image">
                    @if ($ad->is_featured)

                    <a class="ui teal right ribbon label">إعلان متميز</a>
                    @endif
                    <img src="{{ EverestCloud::getThumnail($ad->ad_id, $ad->images_host) }}" title="{{ $ad->title }}">
                </div>
            
                <div class="content" style="padding-top: 2px;padding-bottom: 2px;color: grey;">
                    <span class="right floated">
                        {{$ad->views}} <i class="eye icon" style="float: right; margin-top: 18%;"></i>
                    </span>
                    <img src="{{ Protocol::home() }}/content/assets/front-end/icons/svg/coins.svg" width="20" alt="">
                    <span style="color: red; font-weight: 700;">{{ Helper::getPriceFormat($ad->price, $ad->currency) }}</span>
                </div>
                <a href="{{ Protocol::home() }}/listing/{{ $ad->slug }}"
                    {{ !is_null($ad->affiliate_link) ? 'target="_blank"' : '' }}">
                    <div class="extra content" style="   direction: rtl;  text-align: center;padding-top: 0px;">
                        <h4 style="  white-space: nowrap; direction: rtl;
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                        max-width: 200px;font-size: 14px;"> <span>{{ $ad->title }} </span> </h4>
                    </div>
                </a>
                <div class="extra content">
                    <div class="ui two buttons">
                        <div class="ui basic green button bnt_card"><a href="{{ Protocol::home() }}/listing/{{ $ad->slug }}"
                                {{ !is_null($ad->affiliate_link) ? 'target="_blank"' : '' }}">
                                <img src="{{ Protocol::home() }}/content/assets/front-end/icons/svg/phone.svg" width="20" alt=""
                                    style="margin-top: 6%;float: right">
                                <h4 class="h_card" style="color: green;font-size: 14px;">إتصل</h4>
                            </a></div>
                        <div class="ui basic red button bnt_card"><a href="{{ Protocol::home() }}/listing/{{ $ad->slug }}"
                                {{ !is_null($ad->affiliate_link) ? 'target="_blank"' : '' }}">
                                <img src="{{ Protocol::home() }}/content/assets/front-end/icons/svg/chatting.svg" width="20" alt=""
                                    style="margin-top: 6%;float: right">
                                <h4 class="h_card" style="color: red;font-size: 14px;">دردشة</h4>
                            </a></div>
                    </div>
                </div>
            
            </div>            @endforeach

            @endif



        </div>



        @if (count($latest_ads))

        <div class="col-md-12 text-center mb-20">

            {{ $latest_ads->links() }}

        </div>

        @else 

        <div class="col-md-12">

            <div class="alert bg-info alert-styled-left">

                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>

                @lang ('return/info.lang_nothing_to_show')

            </div>

        </div>

        @endif



    </div>



</div>



@endsection