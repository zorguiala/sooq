<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <title>{{ Helper::settings_general()->title }} | Dashboard</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link rel="shortcut icon" href="https://sooqwatheq.co/application/public/uploads/settings/favicon/favicon.png">

    @yield('head')

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/front-end/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/cubeportfolio/cubeportfolio.css" rel="stylesheet" type="text/css" />

    <!-- JQuery Map Plugin -->
    <link rel="stylesheet" type="text/css" href="https://sooqwatheq.co/content/assets/css/components.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

    <!-- ckEditor CDN -->
    <script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>

    <!-- Modals -->
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
    <link href="https://sooqwatheq.co/content/assets/back-end/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Uploader Css Files -->
    <link href="https://sooqwatheq.co/content/assets/front-end/css/uploader.min.css" rel="stylesheet">

    <script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key={{ config('google-maps.key') }}'></script>
    <script src="https://sooqwatheq.co/content/assets/front-end/js/plugins/locationpicker/locationpicker.jquery.min.js"></script>

    {!! Charts::assets() !!}


</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white" data-root="https://sooqwatheq.co" id="root">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="https://sooqwatheq.co/dashboard">
                    <img style="margin: -3px 0 0;" src="https://sooqwatheq.co/application/public/uploads/settings/logo/footer/logo.png" alt="logo" class="logo-default" /> </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    
                    <!-- Ads Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/notifications/ads" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            @if (Helper::count_notifications('ads') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('ads') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Payments Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/notifications/payments" class="dropdown-toggle">
                            <i class="icon-wallet"></i>
                            @if (Helper::count_notifications('payments') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('payments') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Comments Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/comments" class="dropdown-toggle">
                            <i class="icon-bubbles"></i>
                            @if (Helper::count_notifications('comments') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('comments') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Reports Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/notifications/reports" class="dropdown-toggle">
                            <i class="icon-flag"></i>
                            @if (Helper::count_notifications('reports') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('reports') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Messages Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/messages/admin" class="dropdown-toggle">
                            <i class="icon-envelope"></i>
                            @if (Helper::count_notifications('messages') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('messages') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Stores Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/notifications/stores" class="dropdown-toggle">
                            <i class="icon-basket"></i>
                            @if (Helper::count_notifications('stores') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('stores') }} </span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Users Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="https://sooqwatheq.co/dashboard/notifications/users" class="dropdown-toggle">
                            <i class="icon-users"></i>
                            @if (Helper::count_notifications('users') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('users') }} </span>
                            @endif
                        </a>
                    </li>
                    
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{ Profile::picture(Auth::id()) }}" />
                            <span class="username username-hide-on-mobile">  
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="https://sooqwatheq.co/account/settings" target="_blank">
                                    <i class="icon-user"></i> ملفي </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://sooqwatheq.co/create">
                                    <i class="icon-pencil"></i> إعلان
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="https://sooqwatheq.co/" target="_blank">
                                    <i class="icon-eye"></i> عرض الموقع </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://tawk.to/mendelman">
                                    <i class="icon-envelope"></i> الاتصال </a>
                            </li>
                            <li>
                                <a href="https://sooqwatheq.co/auth/logout">
                                    <i class="icon-power"></i> تسجيل الخروج </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <div class="clearfix"> </div>
    <div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">
        
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                    <span></span>
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>

            <!-- Dashboard Home Page -->
            <li class="nav-item start">
                <a href="https://sooqwatheq.co/dashboard/fares" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">لوحة القيادة</span>
                </a>
            </li>

            <!-- Ads Settings -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/ads" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">إعدادات الإعلانات</span>
                </a>
            </li>

            <!-- Blog Articles -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/articles" class="nav-link nav-toggle">
                    <i class="icon-feed"></i>
                    <span class="title">مقالات المدونة</span>
                </a>
            </li>

            <!-- Comments Management -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/comments" class="nav-link nav-toggle">
                    <i class="icon-bubbles"></i>
                    <span class="title">إدارة التعليقات</span>
                </a>
            </li>

            <!-- Categories Management -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/categories" class="nav-link nav-toggle">
                    <i class="icon-list"></i>
                    <span class="title">إعدادات الاقسام</span>
                </a>
            </li>

            <!-- Notifications -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-bell"></i>
                    <span class="title">إخطارات</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/notifications/ads" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">اعلانات</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/notifications/payments" class="nav-link ">
                            <i class="icon-wallet"></i>
                            <span class="title">دفع</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/notifications/comments" class="nav-link ">
                            <i class="icon-bubbles"></i>
                            <span class="title">Comments</span>
                        </a>
                    </li> -->
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/notifications/reports" class="nav-link ">
                            <i class="icon-flag"></i>
                            <span class="title">تقارير</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/messages/admin" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">رسائل</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/notifications/stores" class="nav-link ">
                            <i class="icon-basket"></i>
                            <span class="title">مخازن</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/notifications/users" class="nav-link ">
                            <i class="icon-users"></i>
                            <span class="title">المستخدمين</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Mail Box -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-envelope"></i>
                    <span class="title">إعدادات الرسائل</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/messages/stores" class="nav-link ">
                            <i class="icon-bubbles"></i>
                            <span class="title">ملاحظات المتجر</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/messages/users" class="nav-link ">
                            <i class="icon-users"></i>
                            <span class="title">رسائل المستخدمين</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/messages/admin" class="nav-link ">
                            <i class="icon-diamond"></i>
                            <span class="title">رسائل المسؤول</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Users Settings -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/users" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">إعدادات المستخدمين</span>
                </a>
            </li>

            <!-- Stores Settings -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/stores" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">إدارة المخازن</span>
                </a>
            </li>

            <!-- Offers Settings -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/offers" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title">إعدادات العروض</span>
                </a>
            </li>

            <!-- Advertisement Settings -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/advertisements" class="nav-link nav-toggle">
                    <i class="icon-rocket"></i>
                    <span class="title">الإعلانات</span>
                </a>
            </li>

            <!-- Payments Settings -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-credit-card"></i>
                    <span class="title">إدارة المدفوعات</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/payments/accounts" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">مدفوعات الحسابات</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/payments/ads" class="nav-link">
                            <i class="icon-badge"></i>
                            <span class="title">مدفوعات الاعلانات</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Currencies Settings -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle" href="https://sooqwatheq.co/dashboard/currencies">
                    <i class="fa fa-dollar"></i>
                    <span class="title">إعدادات العملات</span>
                </a>
            </li>

            <!-- Payments Gateways -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="fa fa-cc-stripe"></i>
                    <span class="title">بوابات المدفوعات</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/paypal" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PayPal إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/2checkout" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">2Checkout إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/stripe" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Stripe إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/mollie" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Mollie إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/paystack" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PayStack إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/paysafecard" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PaySafeCard إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/razorpay" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">RazorPay إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/barion" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Barion إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/cashu" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">CashU إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/pagseguro" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PagSeguro إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/paytm" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Paytm إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/payments/interkassa" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">InterKassa إعدادات </span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- SMS Gateways -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-paper-plane"></i>
                    <span class="title">بوابات الرسائل القصيرة</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/sms/nexmo" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Nexmo إعدادات</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/sms/identifyme" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">IdentifyMe إعدادات</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/sms/smscru" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">SmscRu Settings</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/sms/smsgateway" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">SmsGateway Settings</span>
                        </a>
                    </li> -->
                </ul>
            </li>

            <!-- Cloud Services -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-cloud"></i>
                    <span class="title">خدمات سحابية</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/cloud/amazon" class="nav-link ">
                            <i class="fa fa-amazon"></i>
                            <span class="title">Amazon S3</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/cloud/google" class="nav-link ">
                            <i class="fa fa-google"></i>
                            <span class="title">Google Cloud</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/cloud/rackspace" class="nav-link ">
                            <i class="fa fa-rocket"></i>
                            <span class="title">RackSpace Cloud</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/cloud/cloudinary" class="nav-link ">
                            <i class="fa fa-cloud-upload"></i>
                            <span class="title">Cloudinary Cloud</span>
                        </a>
                    </li> -->
                </ul>
            </li>

            <!-- Geo Settings -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-globe"></i>
                    <span class="title">الإدارة الجغرافية</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/geo/countries" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">بلدان</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/geo/states" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">الدول</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/geo/cities" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">المدن</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Pages Settings -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/pages" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title">إعدادات الصفحات</span>
                </a>
            </li>

            <!-- Failed Login -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/login/history" class="nav-link nav-toggle">
                    <i class="icon-shield"></i>
                    <span class="title">فشل تسجيل الدخول</span>
                </a>
            </li>

            <!-- IP Blocker -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-ban"></i>
                    <span class="title">مانع</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/firewall/add" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">حظر IP</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/firewall" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">قائمة الحظر</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Themes Management -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/themes" class="nav-link nav-toggle">
                    <i class="icon-picture"></i>
                    <span class="title">إدارة المواضيع</span>
                </a>
            </li>

            <!-- Site Settings -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">إعدادات التطبيقات</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/general" class="nav-link ">
                            <i class="icon-equalizer"></i>
                            <span class="title">الاعدادات العامة</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="https://sooqwatheq.co/dashboard/settings/home" class="nav-link ">
                            <i class="icon-home"></i>
                            <span class="title">إعدادات الصفحة الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/security" class="nav-link ">
                            <i class="icon-shield"></i>
                            <span class="title">اعدادات الامان</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/smtp" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">SMTP الإعدادات</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/seo" class="nav-link ">
                            <i class="icon-rocket"></i>
                            <span class="title">SEO الإعدادات</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/watermark" class="nav-link ">
                            <i class="fa fa-image"></i>
                            <span class="title">Watermark إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/geo" class="nav-link ">
                            <i class="icon-pointer"></i>
                            <span class="title">GEO إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/auth" class="nav-link ">
                            <i class="fa fa-lock"></i>
                            <span class="title">Auth إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/membership" class="nav-link ">
                            <i class="icon-star"></i>
                            <span class="title">Membership إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="https://sooqwatheq.co/dashboard/settings/footer" class="nav-link ">
                            <i class="icon-arrow-down"></i>
                            <span class="title">Footer إعدادات </span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Maintenance -->
            <li class="nav-item  ">
                <a href="https://sooqwatheq.co/dashboard/maintenance" class="nav-link nav-toggle">
                    <i class="icon-power"></i>
                    <span class="title">وضع الصيانة</span>
                </a>
            </li>
                        
        </ul>

    </div>
@extends ('dashboard.layout.app')

@section ('content')

<!-- Quick stats -->
<div class="row">

    <div class="col-md-12">
        <!-- Session Messages -->
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }} 
        </div>
        @endif
    </div>

	<!-- Total Ads -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-bullhorn"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_ads }}</span>
                </div>
                <div class="desc"> كل الاعلانات </div>
            </div>
        </a>
    </div>

    <!-- Total Categories -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-list"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_cats }}</span>
                </div>
                <div class="desc"> ;كل الاقسام </div>
            </div>
        </a>
    </div>

    <!-- Total Stores -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-home"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_stores }}</span>
                </div>
                <div class="desc"> كل المتاجر </div>
            </div>
        </a>
    </div>

    <!-- Total Users -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_users }}</span>
                </div>
                <div class="desc"> كل الزوار </div>
            </div>
        </a>
    </div>

    <!-- Total Messages -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-envelope"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_messages }}</span>
                </div>
                <div class="desc"> كل الرسائل </div>
            </div>
        </a>
    </div>

    <!-- Total Comments -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_comments }}</span>
                </div>
                <div class="desc"> كل التعليقات </div>
            </div>
        </a>
    </div>

    <!-- Total Views -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-eye"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_views }}</span>
                </div>
                <div class="desc"> كل المشاهدات </div>
            </div>
        </a>
    </div>

    <!-- Total Pages -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
            <div class="visual">
                <i class="fa fa-file"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span>{{ $total_pages }}</span>
                </div>
                <div class="desc"> كل الصفحات </div>
            </div>
        </a>
    </div>

</div>

<!-- Ads Visits -->
<div class="row">
    <div class="col-md-12">
        
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">إعلانات الإعلانات</span>
                </div>
            </div>
            <div class="portlet-body">

                {!! $visits->render() !!}

            </div>
        </div>

    </div>
</div>

<!-- users and stores -->
<div class="row">
	
    <!-- users -->
	<div class="col-md-6">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">أحدث المستخدمين</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="general-item-list">

                    @if($latest_users)
                    @foreach($latest_users as $user)
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">
                                <img class="item-pic rounded" src="{{ Profile::user_picture($user->id) }}">
                                <a href="https://sooqwatheq.co/dashboard/users/details/{{ $user->username }}" class="item-name primary-link">{{ $user->first_name }} {{ $user->last_name }}</a>
                                <span class="item-label">{{ Helper::date_ago($user->created_at) }}</span>
                            </div>
                            @if($user->status)
                            <span class="item-status">
                                <span class="badge badge-empty badge-success"></span> Active
                            </span>
                            @else
                            <span class="item-status">
                                <span class="badge badge-empty badge-danger"></span> Pending
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

	</div>

    <!-- stores -->
    <div class="col-md-6">

        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-blue bold uppercase">أحدث المتاجر</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="general-item-list">
                    @if($latest_stores)
                    @foreach($latest_stores as $store)
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">
                                <img class="item-pic rounded" src="{{ $store->logo }}">
                                <a href="https://sooqwatheq.co/dashboard/stores/details/{{ $store->username }}" class="item-name primary-link">{{ $store->username }}</a>
                                <span class="item-label">{{ Helper::date_ago($store->created_at) }}</span>
                            </div>
                            @if ($store->status)
                            <span class="item-status">
                                <span class="badge badge-empty badge-success"></span> فتح
                            </span>
                            @else
                            <span class="item-status">
                                <span class="badge badge-empty badge-danger"></span> غلق
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

    </div>

</div>


@endsection
     <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> &copy; @php echo date('Y'); @endphp
                <a href="https://www.arbe5.com" target="_blank">Arbe5</a>
                All Rights Reserved. (Version <b>1.3.9</b>)
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>

        <script src="https://sooqwatheq.co/content/assets/back-end/assets/global/scripts/app.min.js" type="text/javascript"></script>

        <script src="https://sooqwatheq.co/content/assets/back-end/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>

        <script src="https://sooqwatheq.co/content/assets/back-end/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
        <script src="https://sooqwatheq.co/content/assets/back-end/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://sooqwatheq.co/content/assets/front-end/js/plugins/uploaders/uploader.min.js"></script>

        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>