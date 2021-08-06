<div class="wrapper ">
    @include('slayouts.navbars.sidebar1')
    <div class="main-panel">
        @include('slayouts.navbars.navs.auth1')
        @include('layouts.script')
        @yield('content')
        <!-- @include('layouts.footers.auth') -->

    </div>
</div>