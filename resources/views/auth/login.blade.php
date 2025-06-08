<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
            Login | HALCONN
        </title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="smartadmin/dist/css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="smartadmin/dist/css/app.bundle.css">
        <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
        <link id="myskin" rel="stylesheet" media="screen, print" href="smartadmin/dist/css/skins/skin-master.css">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="smartadmin/dist/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="smartadmin/dist/img/favicon/favicon-32x32.png">
        <link rel="mask-icon" href="smartadmin/dist/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="stylesheet" media="screen, print" href="smartadmin/dist/css/page-login-alt.css">
        <style type="text/css">
            .numbersDashboard{
                background: #363337;
                cursor: pointer;
                height: 35px;
                color: #ffffff;
                padding-top: 9px;
                border-radius: 5px;
            }
            
            .table-sm th, .table-sm td {
                padding: 1px;
            }
        </style>
    </head>
   
    <body>       
        <script>
            
            'use strict';

            var classHolder = document.getElementsByTagName("BODY")[0],               
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            }
            else
            {
                console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...", "color: #ed1c24");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);

            }
            else if (themeSettings.themeURL && document.getElementById('mytheme'))
            {
                document.getElementById('mytheme').href = themeSettings.themeURL;
            }
            /** 
             * Save to localstorage 
             **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|footer|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /** 
             * Reset settings
             **/
            var resetSettings = function()
            {
                localStorage.setItem("themeSettings", "");
            }

        </script>
        <div class="blankpage-form-field">
            <div style="background: #363337" class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                    <center><img src="smartadmin/dist/img/logo_oscuro.png" style="width: 13%" alt="smartadmin WebApp" aria-roledescription="logo"></center>
                    {{-- <span class="page-logo-text mr-1">HALCONN</span> --}}
                    <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                </a>
                
            </div>
            <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">

                <x-jet-validation-errors class="mb-3 rounded-0" />

                @if (session('status'))
                    <div class="alert alert-success mb-3 rounded-0" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form id="formlogin" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <x-jet-label value="{{ __('Email') }}" />

                        <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                                    name="email" :value="old('email')" required />
                        <x-jet-input-error for="email"></x-jet-input-error>                        
                    </div>
                    <div class="form-group">
                        <x-jet-label value="{{ __('Password') }}" />

                        <x-jet-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
                                     name="password" required autocomplete="current-password"/>
                        <x-jet-input-error for="password"></x-jet-input-error>                        
                    </div>
                    <div class="form-group">
                        <div class="frame-wrap">                            
                            {{-- <table class="table table-sm text-center">
                                <tr>
                                    <td style="width: 32%;"><div class="numbersDashboard" onclick="setNumbersSelectDashboard(1)"><p>1</p></div></td>
                                    <td style="width: 32%;"><div class="numbersDashboard" onclick="setNumbersSelectDashboard(2)"><p>2</p></div></td>
                                    <td style="width: 35%;"><div class="numbersDashboard" onclick="setNumbersSelectDashboard(3)"><p>3</p></div></td>
                                </tr>
                                <tr>
                                    <td><div class="numbersDashboard" onclick="setNumbersSelectDashboard(4)"><p>4</p></div></td>
                                    <td><div class="numbersDashboard" onclick="setNumbersSelectDashboard(5)"><p>5</p></div></td>
                                    <td><div class="numbersDashboard" onclick="setNumbersSelectDashboard(6)"><p>6</p></div></td>
                                </tr>
                                <tr>
                                    <td><div class="numbersDashboard" onclick="setNumbersSelectDashboard(7)"><p>7</p></div></td>
                                    <td><div class="numbersDashboard" onclick="setNumbersSelectDashboard(8)"><p>8</p></div></td>
                                    <td><div class="numbersDashboard" onclick="setNumbersSelectDashboard(9)"><p>9</p></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><div class="numbersDashboard" onclick="setNumbersSelectDashboard(0)"><p>0</p></div></td>
                                    <td> <div class="numbersDashboard" onclick="setNumbersSelectDashboard('Clear')"><p>Clear</p></div></td>
                                </tr>
                            </table>                            --}}
                        </div>
                    </div>
                    
                    <div class="row mb-3">                        
                        <button type="submit" class="btn btn-primary text-uppercase waves-effect waves-themed btn-block">
                            Iniciar sesión
                        </button>
                    </div>

                    
                </form>
            </div>
           
        </div>
        
        <video poster="smartadmin/dist/img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
            <source src="smartadmin/dist/media/video/cc.webm" type="video/webm">
            <source src="smartadmin/dist/media/video/cc.mp4" type="video/mp4">
        </video>
        <!-- BEGIN Color profile -->
        <!-- this area is hidden and will not be seen on screens or screen readers -->
        <!-- we use this only for CSS color refernce for JS stuff -->
        <p id="js-color-profile" class="d-none">
            <span class="color-primary-50"></span>
            <span class="color-primary-100"></span>
            <span class="color-primary-200"></span>
            <span class="color-primary-300"></span>
            <span class="color-primary-400"></span>
            <span class="color-primary-500"></span>
            <span class="color-primary-600"></span>
            <span class="color-primary-700"></span>
            <span class="color-primary-800"></span>
            <span class="color-primary-900"></span>
            <span class="color-info-50"></span>
            <span class="color-info-100"></span>
            <span class="color-info-200"></span>
            <span class="color-info-300"></span>
            <span class="color-info-400"></span>
            <span class="color-info-500"></span>
            <span class="color-info-600"></span>
            <span class="color-info-700"></span>
            <span class="color-info-800"></span>
            <span class="color-info-900"></span>
            <span class="color-danger-50"></span>
            <span class="color-danger-100"></span>
            <span class="color-danger-200"></span>
            <span class="color-danger-300"></span>
            <span class="color-danger-400"></span>
            <span class="color-danger-500"></span>
            <span class="color-danger-600"></span>
            <span class="color-danger-700"></span>
            <span class="color-danger-800"></span>
            <span class="color-danger-900"></span>
            <span class="color-warning-50"></span>
            <span class="color-warning-100"></span>
            <span class="color-warning-200"></span>
            <span class="color-warning-300"></span>
            <span class="color-warning-400"></span>
            <span class="color-warning-500"></span>
            <span class="color-warning-600"></span>
            <span class="color-warning-700"></span>
            <span class="color-warning-800"></span>
            <span class="color-warning-900"></span>
            <span class="color-success-50"></span>
            <span class="color-success-100"></span>
            <span class="color-success-200"></span>
            <span class="color-success-300"></span>
            <span class="color-success-400"></span>
            <span class="color-success-500"></span>
            <span class="color-success-600"></span>
            <span class="color-success-700"></span>
            <span class="color-success-800"></span>
            <span class="color-success-900"></span>
            <span class="color-fusion-50"></span>
            <span class="color-fusion-100"></span>
            <span class="color-fusion-200"></span>
            <span class="color-fusion-300"></span>
            <span class="color-fusion-400"></span>
            <span class="color-fusion-500"></span>
            <span class="color-fusion-600"></span>
            <span class="color-fusion-700"></span>
            <span class="color-fusion-800"></span>
            <span class="color-fusion-900"></span>
        </p>
        
        <!-- END Color profile -->
        <script>
            (function(i, s, o, g, r, a, m)
            {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function()
                {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-141754477-1', 'auto');
            ga('send', 'pageview');
        </script>

        <script src="smartadmin/dist/js/vendors.bundle.js"></script>
        <script src="smartadmin/dist/js/app.bundle.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>

        <script>
            contador = 0;
            function setNumbersSelectDashboard(data){    
                contador=contador+1;
                var inp = $('input[name=password]');
                if(data === "Clear") {
                    console.log('Limpiar')
                    inp.val('');
                }else{
                    var ant = inp.val();
                    var newN = data;
                    inp.val(`${ant}${newN}`);
                    console.log(data)
                    if(contador>=3){                        
                        $('#formlogin').submit();
                        contador=0;                                          
                    }                  
                }                
            }
        </script>
        <!-- Page related scripts -->
    </body>
    <!-- END Body -->
</html>