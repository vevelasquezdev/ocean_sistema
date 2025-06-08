<header class="page-header" role="banner">
    <!-- we need this logo when user switches to nav-function-top -->
    {{-- <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ asset('smartadmin/dist/img/logo.png') }}" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Maquingenieros</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div> --}}
    <!-- DOC: nav menu layout change shortcut -->
    <div class="hidden-md-down dropdown-icon-menu position-relative">
        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
            <i class="ni ni-menu"></i>
        </a>                            
    </div>
    <!-- DOC: mobile button appears during mobile width -->
    <div class="hidden-lg-up">
        <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
            <i class="ni ni-menu"></i>
        </a>
    </div>
    
  
    <div class="ml-auto d-flex">
       
        <!-- app settings -->
        <div class="hidden-md-down">
            <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-settings">
                <i class="fal fa-cog"></i>
            </a>
        </div>                            
        <!-- app user menu -->
        <div>
            <a href="#" data-toggle="dropdown" title="{{ optional(Auth::user())->email }}" class="header-icon d-flex align-items-center justify-content-center ml-2">                                    
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    @if(Auth::user())
                        <img class="profile-image rounded-circle" src="{{ optional(Auth::user())->profile_photo_url }}" alt="{{ optional(Auth::user())->name }}" />
                    @else
                        <img src="{{ asset('smartadmin/dist/img/demo/avatars/avatar-m.png') }}" class="profile-image rounded-circle" alt="`"> 
                    @endif
                    
                @else

                @if(Auth::user())
                    {{ optional(Auth::user())->name }}
                @else
                    NOMBRE
                @endif
                    

                    <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                    <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                        <span class="mr-2">                                                
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                @if(Auth::user())
                                    <img class="profile-image rounded-circle" src="{{ optional(Auth::user())->profile_photo_url }}" alt="{{ optional(Auth::user())->name }}" />
                                @else
                                    <img src="{{ asset('smartadmin/dist/img/demo/avatars/avatar-m.png') }}" class="profile-image rounded-circle" alt="`"> 
                                @endif
                                
                            @else

                            @if(Auth::user())
                                {{ optional(Auth::user())->name }}
                            @else
                                NOMBRE
                            @endif
                                

                                <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </span>
                        <div class="info-card-text">
                            <div class="fs-lg text-truncate text-truncate-lg">@if(Auth::user()) {{ optional(Auth::user())->name }} @else nombre @endif</div>
                            <span class="text-truncate text-truncate-md opacity-80">@if(Auth::user()) {{ optional(Auth::user())->email }} @else email @endif</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider m-0"></div>
                {{-- <a href="{{ route('profile.show') }}" class="dropdown-item">
                    <span data-i18n="drpdwn.reset_layout">{{ __('Profile') }}</span>
                </a>                                    --}}

                <div class="dropdown-divider m-0"></div>
                <a href="#" class="dropdown-item" data-action="app-reset">
                    <span data-i18n="drpdwn.reset_layout">Restablecer diseño</span>
                </a>
                <a href="#" class="dropdown-item" data-toggle="modal" data-target=".js-modal-settings">
                    <span data-i18n="drpdwn.settings">Configuraci&oacute;n diseño</span>
                </a>
                <div class="dropdown-divider m-0"></div>
                <a href="#" class="dropdown-item" data-action="app-fullscreen">
                    <span data-i18n="drpdwn.fullscreen">Pantalla completa</span>
                    <i class="float-right text-muted fw-n">F11</i>
                </a>
                <a href="#" class="dropdown-item" data-action="app-print">
                    <span data-i18n="drpdwn.print">Imprimir p&aacute;gina</span>
                    <i class="float-right text-muted fw-n">Ctrl + P</i>
                </a>                                    
                <div class="dropdown-divider m-0"></div>

                <a class="dropdown-item fw-500 pt-3 pb-3" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                    
                    <span data-i18n="drpdwn.page-logout">{{ __('Log out') }}</span>
                    <span class="float-right fw-n">&commat;{{ optional(Auth::user())->name }}</span>
                </a>
                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                    @csrf
                </form>                                    
            </div>
        </div>
    </div>
</header>