<div class="wrapper ">
    @include('slayouts.navbars.sidebar')
    <div class="main-panel">
        @include('slayouts.navbars.navs.auth')
        @include('layouts.script')
        @yield('content')
        <!-- @include('slayouts.footers.auth') -->
    </div>
</div>