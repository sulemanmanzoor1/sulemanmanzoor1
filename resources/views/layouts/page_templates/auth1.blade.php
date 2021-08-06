<div class="wrapper ">
    @include('layouts.navbars.sidebar1')
    <div class="main-panel">
        @include('layouts.navbars.navs.auth1')
        @include('layouts.script')
        @yield('content')
        <!-- @include('layouts.footers.auth') -->

    </div>
</div>