<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="#">{{ $title }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <!-- <form class="navbar-form">
                <div class="input-group no-border">
                    <input type="text" value="" class="form-control" placeholder="Search...">
                    <button type="submit" class="btn btn-white btn-round btn-just-icon">
                        <i class="material-icons">search</i>
                        <div class="ripple-container"></div>
                    </button>
                </div>
            </form> -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="material-icons">dashboard</i>
                        <p class="d-lg-none d-md-block">
                            {{ __('Stats') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="dripicons-web"></i> <span>{{__('file.language')}}</span> <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                        <li class="nav-item dropdown">
                            <a href="{{ url('language_switch/en') }}" class="btn btn-link nav-link"> English</a>
                        </li>

                        <li>
                            <a href="{{ url('language_switch/ar') }}" class="btn btn-link"> عربى</a>
                        </li>

                    </ul>
                </li>
				<li class="nav-item dropdown">
                    <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            {{ __('Account') }}
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="{{route('admin.profile')}}">{{ __('file.profile') }}</a>
                        <!-- <a class="dropdown-item" href="#">{{ __('Settings') }}</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('admin-logout')}}">{{ __('file.logout') }}</a>
                    </div>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification">5</span>
                        <p class="d-lg-none d-md-block">
                            {{ __('Some Actions') }}
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">{{ __('Mike John responded to your email') }}</a>
                        <a class="dropdown-item" href="#">{{ __('You have 5 new tasks') }}</a>
                        <a class="dropdown-item" href="#">{{ __('You\'re now friend with Andrew') }}</a>
                        <a class="dropdown-item" href="#">{{ __('Another Notification') }}</a>
                        <a class="dropdown-item" href="#">{{ __('Another One') }}</a>
                    </div>
                </li> -->
                
            </ul>
        </div>
    </div>
</nav>