		@include ('dashboard.includes.header')

        <div class="page-container">
            
        @include ('dashboard.includes.sidebar')

            <div class="page-content-wrapper">

                <div class="page-content">

                @yield('content')

                </div>

            </div>

        </div>

        @include ('dashboard.includes.footer')