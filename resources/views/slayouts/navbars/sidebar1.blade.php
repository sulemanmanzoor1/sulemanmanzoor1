<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo">
        <a href="{{route('salon.dashboard')}}" class="simple-text logo-normal">
            Beauty Salon
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">

            @if(Auth::guard('salon')->check())
            @if(Auth::guard('salon')->user()->role==3)
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('salon.dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('file.dashboard') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'service' ? ' active' : '' }}">

                <a class="nav-link" href="{{route('salon.service')}}">
                    <i class="material-icons">auto_fix_high</i>
                    <p>{{__('file.services') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'gallery' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('gallery')}}">
                    <i class="material-icons">image</i>
                    <p>{{__('file.gallery') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'coupon' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('coupon')}}">
                    <i class="material-icons">label_off</i>
                    <p>{{__('file.coupon') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'time' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('salon.time')}}">
                    <i class="material-icons">watch_later</i>
                    <p>{{__('file.time_management') }}</p>
                </a>

            </li>

            <li class="nav-item{{ $activePage == 'setting' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('salon.setting')}}">
                    <i class="material-icons">settings_suggest</i>
                    <p>{{__('file.setting') }}</p>
                </a>
            </li>
			 <li class="nav-item{{ $activePage == 'appointment' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('salon.appointment')}}">
                    <i class="material-icons">calendar_today</i>
                    <p>{{__('file.appointment') }}</p>
                </a>
            </li>
			 <li class="nav-item{{ $activePage == 'notification' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('salon.notification')}}">
                    <i class="material-icons">notifications</i>
                    <p>{{__('file.notification') }}</p>
                </a>
            </li>
            @endif
            @endif
        </ul>
    </div>
</div>