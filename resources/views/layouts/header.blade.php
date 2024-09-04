<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0') }}" />
    <meta name="description"
        content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.') }}" />
    <meta name="keywords"
        content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app') }}" />
    <meta name="author" content="pixelstrap') }}" />
    <title>Admiro - Premium Admin Template</title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ asset('assets/images/favicon.png" type="image/x-icon') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png" type="image/x-icon') }}" />
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com')" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap"
        rel="stylesheet') }}" />
    <!-- Flag icon css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}" />


    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}" />
    <!-- iconly-icon-->
    <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bulk-style.css') }}" />
    <!-- iconly-icon-->
    <link rel="stylesheet" href="{{ asset('assets/css/themify.css') }}" />
    <!--fontawesome-->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-min.css') }}" />
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/weather-icons/weather-icons.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}" />
    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css" media="screen') }}"/>

</head>

<body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <header class="page-header row">
            <div class="logo-wrapper d-flex align-items-center col-auto"><a href="index.html"><img
                        class="light-logo img-fluid" src="../assets/images/logo/logo1.png" alt="logo" /><img
                        class="dark-logo img-fluid" src="../assets/images/logo/logo-dark.png" alt="logo" /></a><a
                    class="close-btn toggle-sidebar" href="javascript:void(0)">
                    <svg class="svg-color">
                        <use href="../assets/svg/iconly-sprite.svg#Category"></use>
                    </svg></a></div>
            <div class="page-main-header col">
                <div class="header-left">
                    <form class="form-inline search-full col" action="#" method="get">
                        <div class="form-group w-100">
                            <div class="Typeahead Typeahead--twitterUsers">
                                <div class="u-posRelative">
                                    <input class="demo-input Typeahead-input form-control-plaintext w-100"
                                        type="text" placeholder="Search Admiro .." name="q" title=""
                                        autofocus="autofocus" />
                                    <div class="spinner-border Typeahead-spinner" role="status"><span
                                            class="sr-only">Loading...</span></div><i class="close-search"
                                        data-feather="x"></i>
                                </div>
                                <div class="Typeahead-menu"></div>
                            </div>
                        </div>
                    </form>
                    <div class="form-group-header d-lg-block d-none">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative d-flex align-items-center">
                                <input class="demo-input py-0 Typeahead-input form-control-plaintext w-100"
                                    type="text" placeholder="Type to Search..." name="q" title="" /><i
                                    class="search-bg iconly-Search icli"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-right">
                    <ul class="header-right">

                        <li class="search d-lg-none d-flex"> <a href="javascript:void(0)">
                                <svg>
                                    <use href="../assets/svg/iconly-sprite.svg#Search"></use>
                                </svg></a></li>
                        <li> <a class="dark-mode" href="javascript:void(0)">
                                <svg>
                                    <use href="../assets/svg/iconly-sprite.svg#moondark"></use>
                                </svg></a></li>

                        <li><a class="full-screen" href="javascript:void(0)">
                                <svg>
                                    <use href="../assets/svg/iconly-sprite.svg#scanfull"></use>
                                </svg></a></li>


                        <li class="profile-nav custom-dropdown">
                            <div class="user-wrap">
                                <div class="user-img"><img src="../assets/images/profile.png" alt="user" /></div>
                                <div class="user-content">
                                    <h6>Ava Davis</h6>
                                    <p class="mb-0">Admin<i class="fa-solid fa-chevron-down"></i></p>
                                </div>
                            </div>
                            <div class="custom-menu overflow-hidden">
                                <ul class="profile-body">
                                    <li class="d-flex">
                                        <svg class="svg-color">
                                            <use href="../assets/svg/iconly-sprite.svg#Profile"></use>
                                        </svg><a class="ms-2" href="user-profile.html">Account</a>
                                    </li>
                                    <li class="d-flex">
                                        <svg class="svg-color">
                                            <use href="../assets/svg/iconly-sprite.svg#Message"></use>
                                        </svg><a class="ms-2" href="letter-box.html">Inbox</a>
                                    </li>
                                    <li class="d-flex">
                                        <svg class="svg-color">
                                            <use href="../assets/svg/iconly-sprite.svg#Document"></use>
                                        </svg><a class="ms-2" href="to-do.html">Task</a>
                                    </li>
                                    <li class="d-flex">
                                        <form action="{{ route('logout') }}" method="post" id="logout">
                                            @csrf
                                            <svg class="svg-color">
                                                <use href="../assets/svg/iconly-sprite.svg#Login"></use>
                                            </svg>

                                            <a class="ms-2"  onclick="event.preventDefault(); document.getElementById('logout').submit();">Log Out</a>
                                        </form>

                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
