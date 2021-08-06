<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo">
        <a href="{{route('dashboard')}}" class="simple-text logo-normal">
            Beauty Salon
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @if(Auth::guard('user')->check())
            @if(Auth::guard('user')->user()->role==1)
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('file.dashboard') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'salon' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('salons')}}">
                    <i class="material-icons">content_cut</i>
                    <p>{{ __('file.salon') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'countries' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('countries')}}">
                    <i class="material-icons">language</i>
                    <p>{{__('file.countries')}}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('cities')}}">
                    <i class="material-icons">location_city</i>
                    <p>{{__('file.cities')}}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'category' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('category')}}">
                    <i class="material-icons">list</i>
                    <p>{{__('file.category')}}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'services' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('admin.service')}}">
                    <i class="material-icons">auto_fix_high</i>
                    <p>{{__('file.services')}}</p>
                </a>
            </li>
			<li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('all.users')}}">
                    <i class="material-icons">people</i>
                    <p>{{__('file.users')}}</p>
                </a>
            </li>
			  <li class="nav-item{{ $activePage == 'sliders' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('admin.sliders')}}">
                    <i class="material-icons">auto_fix_high</i>
                    <p>{{__('file.sliders')}}</p>
                </a>
            </li>
			 <li class="nav-item{{ $activePage == 'aboutus' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('admin.aboutus')}}">
                    <i class="material-icons">auto_fix_high</i>
                    <p>{{__('file.aboutus')}}</p>
                </a>
            </li>
			<li class="nav-item{{ $activePage == 'setting' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('admin.setting')}}">
                    <i class="material-icons">settings_suggest</i>
                    <p>{{__('file.setting')}}</p>
                </a>
            </li>
            @endif
            @endif

        </ul>
    </div>
</div>