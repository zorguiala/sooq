@extends (Theme::get().'.layout.app')



@section ('seo')



{!! SEO::generate() !!}



@endsection



@section ('styles')

    <link href="{{ Protocol::home() }}/content/assets/front-end/css/icons/et-line-font/et-line.css" rel="stylesheet" type="text/css">

@endsection



@section ('pageHeader')



<div class="plans-header">

	

	<div class="plans-header-body">

<h2 class="text-uppercase"><font color="#E8E8E8">{{ Lang::get('pricing.lang_header_upgrade_now') }}</font></h2>
	</div>



</div>



@endsection



@section ('content')



<!-- Pricing Plans -->

<div class="row">



	<!-- Main Features -->

	<div class="col-md-12">

		

		<div class="heading-title">

            			<section id="slider" class="slider-container slider-top-pagination">
            
				<div class="container">
					<h2 class="title font-additional font-weight-bold text-uppercase wow zoomIn" data-wow-delay="0.3s"><span class="customColor">
				<i class="fa fa-minus"></i> <h2>{{ Lang::get('pricing.lang_the_best_value') }}</h2> <i class="fa fa-minus"></i> </h2></span>
					<div class="starSeparatorBox clearfix">
						<div class="starSeparator wow zoomIn" data-wow-delay="0.3s">
							<span aria-hidden="true"><i class="fa fa-bullseye"></i></span>
						</div>
                        						</div>

						</div>

			</section>
            <p>{{ Lang::get('pricing.lang_the_best_value_p') }}</p>

        </div>



		<div class="row">

			

			<div class="features">

				

				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon customBgColor">

							<i class="et-line-trophy"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_featured_ads') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_featured_ads_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-lock"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_encrypted_payment') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_encrypted_payment_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-bargraph"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_statistics') }}</h2><i class="icon-point-down"></i>

						<p>تتبع إعلاناتك و شاهد من أين تأتي النقرات</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-megaphone"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_no_advertisements') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_no_advertisements_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-envelope"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_feedback') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_feedback_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-linegraph"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_autoshare') }}</h2><i class="icon-point-down"></i>

						<p>مشاركة اعلاناتك تلقائيا على الفيس بوك</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-shield"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_trusted_seller') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_trusted_seller_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-map"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_online_store') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_online_store_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-chat"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_support') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_support_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-pictures"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_more_images') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_more_images_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-hourglass"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_no_limiting') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_no_limiting_p') }}</p>

					</div>

				</div>



				<div class="col-md-4">

					<!-- plan feature -->

					<div class="plan-feature">

						<div class="plan-icon">

							<i class="et-line-happy"></i>

						</div>

						<h2>{{ Lang::get('pricing.lang_more') }}</h2><i class="icon-point-down"></i>

						<p>{{ Lang::get('pricing.lang_more_p') }}</p>

					</div>

				</div>



			</div>



			<!-- Upgrade Now -->

			<div class="col-md-12 text-center">

			

				<a class="upgrade-btn legitRipple" href="{{ Protocol::home() }}/upgrade">{{ Lang::get('pricing.lang_get_started_now') }}</a>

				

			</div>



		</div>



	</div>



</div>



@endsection