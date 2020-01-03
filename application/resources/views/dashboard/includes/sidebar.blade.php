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
            <!-- Ads Settings -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard" class="nav-link nav-toggle">
                    <i class="icon-rocket"></i>
                    <span class="title">لوحه القيادة</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/ads" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">إعدادات الإعلانات</span>
                </a>
            </li>

            
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/articles" class="nav-link nav-toggle">
                    <i class="icon-feed"></i>
                    <span class="title">مقالات المدونة</span>
                </a>
            </li>

            <!-- Comments Management -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/comments" class="nav-link nav-toggle">
                    <i class="icon-bubbles"></i>
                    <span class="title">إدارة التعليقات</span>
                </a>
            </li>

            <!-- Categories Management -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/categories" class="nav-link nav-toggle">
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
                        <a href="{{ Protocol::home() }}/dashboard/notifications/ads" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">اعلانات</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/payments" class="nav-link ">
                            <i class="icon-wallet"></i>
                            <span class="title">دفع</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/comments" class="nav-link ">
                            <i class="icon-bubbles"></i>
                            <span class="title">Comments</span>
                        </a>
                    </li> -->
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/reports" class="nav-link ">
                            <i class="icon-flag"></i>
                            <span class="title">تقارير</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/messages/admin" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">رسائل</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/stores" class="nav-link ">
                            <i class="icon-basket"></i>
                            <span class="title">مخازن</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/notifications/users" class="nav-link ">
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
                        <a href="{{ Protocol::home() }}/dashboard/messages/stores" class="nav-link ">
                            <i class="icon-bubbles"></i>
                            <span class="title">ملاحظات المتجر</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/messages/users" class="nav-link ">
                            <i class="icon-users"></i>
                            <span class="title">رسائل المستخدمين</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/messages/admin" class="nav-link ">
                            <i class="icon-diamond"></i>
                            <span class="title">رسائل المسؤول</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Users Settings -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/users" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">إعدادات المستخدمين</span>
                </a>
            </li>

            <!-- Stores Settings -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/stores" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">إدارة المخازن</span>
                </a>
            </li>

            <!-- Offers Settings -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/offers" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title">إعدادات العروض</span>
                </a>
            </li>

            <!-- Advertisement Settings -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/advertisements" class="nav-link nav-toggle">
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
                        <a href="{{ Protocol::home() }}/dashboard/payments/accounts" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">مدفوعات الحسابات</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/payments/ads" class="nav-link">
                            <i class="icon-badge"></i>
                            <span class="title">مدفوعات الاعلانات</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Currencies Settings -->
            <li class="nav-item  ">
                <a class="nav-link nav-toggle" href="{{ Protocol::home() }}/dashboard/currencies">
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
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/paypal" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PayPal إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/2checkout" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">2Checkout إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/stripe" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Stripe إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/mollie" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Mollie إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/paystack" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PayStack إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/paysafecard" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PaySafeCard إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/razorpay" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">RazorPay إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/barion" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Barion إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/cashu" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">CashU إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/pagseguro" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">PagSeguro إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/paytm" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Paytm إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/payments/interkassa" class="nav-link ">
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
                        <a href="{{ Protocol::home() }}/dashboard/settings/sms/nexmo" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">Nexmo إعدادات</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/sms/identifyme" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">IdentifyMe إعدادات</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/sms/smscru" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">SmscRu Settings</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/sms/smsgateway" class="nav-link ">
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
                        <a href="{{ Protocol::home() }}/dashboard/settings/cloud/amazon" class="nav-link ">
                            <i class="fa fa-amazon"></i>
                            <span class="title">Amazon S3</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/cloud/google" class="nav-link ">
                            <i class="fa fa-google"></i>
                            <span class="title">Google Cloud</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/cloud/rackspace" class="nav-link ">
                            <i class="fa fa-rocket"></i>
                            <span class="title">RackSpace Cloud</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/cloud/cloudinary" class="nav-link ">
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
                        <a href="{{ Protocol::home() }}/dashboard/geo/countries" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">بلدان</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/geo/states" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">الدول</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/geo/cities" class="nav-link ">
                            <i class="fa fa-circle"></i>
                            <span class="title">المدن</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Pages Settings -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/pages" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title">إعدادات الصفحات</span>
                </a>
            </li>

            <!-- Failed Login -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/login/history" class="nav-link nav-toggle">
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
                        <a href="{{ Protocol::home() }}/dashboard/firewall/add" class="nav-link ">
                            <i class="icon-plus"></i>
                            <span class="title">حظر IP</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/firewall" class="nav-link ">
                            <i class="icon-list"></i>
                            <span class="title">قائمة الحظر</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Themes Management -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/themes" class="nav-link nav-toggle">
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
                        <a href="{{ Protocol::home() }}/dashboard/settings/general" class="nav-link ">
                            <i class="icon-equalizer"></i>
                            <span class="title">الاعدادات العامة</span>
                        </a>
                    </li>
                    <li class="nav-item start">
                        <a href="{{ Protocol::home() }}/dashboard/settings/home" class="nav-link ">
                            <i class="icon-home"></i>
                            <span class="title">إعدادات الصفحة الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/security" class="nav-link ">
                            <i class="icon-shield"></i>
                            <span class="title">اعدادات الامان</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/smtp" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">SMTP الإعدادات</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/seo" class="nav-link ">
                            <i class="icon-rocket"></i>
                            <span class="title">SEO الإعدادات</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/watermark" class="nav-link ">
                            <i class="fa fa-image"></i>
                            <span class="title">Watermark إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/geo" class="nav-link ">
                            <i class="icon-pointer"></i>
                            <span class="title">GEO إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/auth" class="nav-link ">
                            <i class="fa fa-lock"></i>
                            <span class="title">Auth إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/membership" class="nav-link ">
                            <i class="icon-star"></i>
                            <span class="title">Membership إعدادات </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="{{ Protocol::home() }}/dashboard/settings/footer" class="nav-link ">
                            <i class="icon-arrow-down"></i>
                            <span class="title">Footer إعدادات </span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Maintenance -->
            <li class="nav-item  ">
                <a href="{{ Protocol::home() }}/dashboard/maintenance" class="nav-link nav-toggle">
                    <i class="icon-power"></i>
                    <span class="title">وضع الصيانة</span>
                </a>
            </li>
                        
        </ul>

    </div>
