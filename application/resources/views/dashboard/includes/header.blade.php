<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <title>{{ Helper::settings_general()->title }} | Dashboard</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link rel="shortcut icon" href="{{ Protocol::home() }}/application/public/uploads/settings/favicon/favicon.png">

    @yield('head')

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/front-end/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/cubeportfolio/cubeportfolio.css" rel="stylesheet" type="text/css" />

    <!-- JQuery Map Plugin -->
    <link rel="stylesheet" type="text/css" href="{{ Protocol::home() }}/content/assets/css/components.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

    <!-- ckEditor CDN -->
    <script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>

    <!-- Modals -->
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ Protocol::home() }}/content/assets/back-end/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Uploader Css Files -->
    <link href="{{ Protocol::home() }}/content/assets/front-end/css/uploader.min.css" rel="stylesheet">

    <script type="text/javascript" src='https://maps.google.com/maps/api/js?libraries=places&key={{ config('google-maps.key') }}'></script>
    <script src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/locationpicker/locationpicker.jquery.min.js"></script>

    {!! Charts::assets() !!}


</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white" data-root="{{ Protocol::home() }}" id="root">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{ Protocol::home() }}/dashboard">
                    <img style="margin: -3px 0 0;" src="{{ Protocol::home() }}/application/public/uploads/settings/logo/footer/logo.png" alt="logo" class="logo-default" /> </a>
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
                        <a href="{{ Protocol::home() }}/dashboard/notifications/ads" class="dropdown-toggle">
                            <i class="icon-list"></i>
                            @if (Helper::count_notifications('ads') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('ads') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Payments Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/payments" class="dropdown-toggle">
                            <i class="icon-wallet"></i>
                            @if (Helper::count_notifications('payments') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('payments') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Comments Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="{{ Protocol::home() }}/dashboard/comments" class="dropdown-toggle">
                            <i class="icon-bubbles"></i>
                            @if (Helper::count_notifications('comments') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('comments') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Reports Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/reports" class="dropdown-toggle">
                            <i class="icon-flag"></i>
                            @if (Helper::count_notifications('reports') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('reports') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Messages Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="{{ Protocol::home() }}/dashboard/messages/admin" class="dropdown-toggle">
                            <i class="icon-envelope"></i>
                            @if (Helper::count_notifications('messages') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('messages') }} </span>
                            @endif
                        </a>
                    </li>

                    <!-- Stores Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/stores" class="dropdown-toggle">
                            <i class="icon-basket"></i>
                            @if (Helper::count_notifications('stores') > 0)
                            <span class="badge badge-default"> {{ Helper::count_notifications('stores') }} </span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Users Notifications -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/users" class="dropdown-toggle">
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
                                <a href="{{ Protocol::home() }}/account/settings" target="_blank">
                                    <i class="icon-user"></i> ملفي </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ Protocol::home() }}/create">
                                    <i class="icon-pencil"></i> إعلان
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="{{ Protocol::home() }}/" target="_blank">
                                    <i class="icon-eye"></i> عرض الموقع </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://tawk.to/mendelman">
                                    <i class="icon-envelope"></i> الاتصال </a>
                            </li>
                            <li>
                                <a href="{{ Protocol::home() }}/auth/logout">
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