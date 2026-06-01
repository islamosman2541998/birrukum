<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title> {{ @$settings->getItem('site_name') }} | @yield('title', $settings->getItem('meta_title_' . $current_lang )) </title>

    <meta name="keywords" content="@yield('meta_key', $settings->getItem('meta_key_' . $current_lang ))">
    <meta name="description" content="@yield('meta_description', $settings->getItem('meta_description_' . $current_lang ))">

    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="author" content="holol" />

    

    <!-- OpenGraph -->
    <meta property="og:title" content=" {{ $settings->getItem('site_name') }}  | @yield('title', $settings->getItem('meta_title_' . $current_lang ))" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content=" " />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="og:image" content="{{ asset($settings->getItem('logo')) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content />
    <meta property="twitter:title" content />
    <meta property="twitter:description" content=" " />
    <meta property="twitter:image" content />


    <!-- pixel script -->
    @if($settings->getItem('show_pixel') )
    {!! $settings->getItem('script_pixel') !!}
    @endif

    <!-- App Icons -->
    <link rel="shortcut icon" href="{{getImage($settings->getItem('icon')) }}" />

    <!-- VITE CSS -->
    @vite(['resources/assets/site/app.css'])

    <!-- VITE EN CSS -->
    @if( app()->isLocale('en') ) @vite(['resources/assets/site/app_en.css']) @endif

    <!-- Page custom head JS -->
    @yield('head-script')

    <!-- page custom styles -->
    @yield('style')


    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        /* main */
        .bg-main, .bg-main:hover, .btn-main, .btn.active, .home-icon, .bg-green, .nav-pills .nav-link.active, .btn-send,
        .categories-nav .nav-item .active, .categories-nav .nav-item .active, #projects .projects-more, .cart-total,
        .login_form .head, .btn-success{
            background-color: {{  $main_color}} !important;
        }
        .text-main, .footer-list .nav-item-icon, .footer-list .nav-item-icon, .social-list .list-item ,
        .breadcrumb .breadcrumb-item:not(.active) a, .categories-nav .nav-item .nav-link, .btn-out, .text-Zakat .aya
        , .profile .active h1{
            color: {{ $main_color }} !important;
        }
        .meun-li:hover, .profile .active {
            a, i {
                color: {{ $main_color }} !important;
            }
        }
        #projects .project-title {
            background-color: {{ $main_color }} !important;
        }
        #footer, #quick-donation .quick-donation-head .icon{
            background-color: {{ $main_color }} !important;
        }
        .categories-nav .nav-item, .btn-out{
            border-color: {{ $main_color }} !important;
        }
        .categories-nav .nav-item .active{
            color: white !important;
        }

        /* secound */
        .bg-secound, .bg-secound:hover, .btn-secound, .btn.active, 
        #projects .project-social .social-share, .cart-count,
        .heading--border-left::after {
            background-color: {{  $secound_color}} !important;
        }
        .text-secound, .bottom-navbar .dropdown-toggle:after, 
        .contact-us__item-icon,.contact-us__item-info .label {
            color: {{ $secound_color }} !important;
        }
        #footer {
            border-top: 5px solid {{ $secound_color }};
        }

    </style>


</head>
