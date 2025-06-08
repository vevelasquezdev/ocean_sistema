<aside class="page-sidebar" style="background: #272525">
    <div class="page-logo" style="background: #1c1c1c">
        <a href="/" class="page-logo-link press-scale-down d-flex align-items-center position-relative">
            <img src="{{ asset('smartadmin/dist/img/logo_oscuro.png') }}" style="width: 9%; margin-left:5%" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1"></span>
            {{-- <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i> --}}
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            @if(Auth::user())
                <img src="{{ optional(Auth::user())->profile_photo_url }}" class="profile-image rounded-circle" alt="`">
            @else
                <img src="{{ asset('smartadmin/dist/img/demo/avatars/avatar-m.png') }}" class="profile-image rounded-circle" alt="`"> 
            @endif
            
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                       
                        @if(Auth::user())
                            {{  optional(Auth::user())->name }}
                        @else
                            USUARIO
                        @endif
                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm"> 
                    @if(Auth::user())
                        {{ optional(Auth::user())->rol }}
                    @else
                        ROL
                    @endif
                   
                </span>
            </div>
            <img src="{{ asset('smartadmin/dist/img/card-backgrounds/cover-2-lg.png') }}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            @if((Auth::user())->rol=='ADMINISTRADOR')
                @include('layouts.menu.administrador')
            @elseif((Auth::user())->rol=='MOZO')
                @include('layouts.menu.mozo')
            @elseif((Auth::user())->rol=='CAJA')
                @include('layouts.menu.caja')
            @elseif((Auth::user())->rol=='BAR')
                @include('layouts.menu.bar')
            @elseif((Auth::user())->rol=='COCINA')
                @include('layouts.menu.bar')
            @elseif((Auth::user())->rol=='ALMACEN')
                @include('layouts.menu.almacen')
            @endif
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <ul class="list-table m-auto nav-footer-buttons">                            
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Llama al autor de este sistema">
                    927245347&nbsp;&nbsp;<i class="fal fa-phone"></i> 
                </a>
            </li>
        </ul>
    </div> <!-- END NAV FOOTER -->
</aside>