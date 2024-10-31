<!DOCTYPE html>
<html class="loading  light-layout" lang="en" data-layout=" light-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ getSetting('website_name') }}</title>

    <meta name="description" content="{{ getSetting('website_name') }}">
    <meta name="author" content="thanhtrungit.net">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ getSetting('website_title') }}">
    <meta property="og:site_name" content="{{ getSetting('website_description') }}">
    <meta property="og:description" content="{{ getSetting('website_description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vuexy/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vuexy/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vuexy/app-assets/css/plugins/forms/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/plugins/forms/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/pages/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vuexy/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vuexy/app-assets/css/pages/app-invoice.css') }}">
    <!-- END: Page CSS-->
    @stack('style')
    {!! getSetting('gg_analytics') !!}
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                                data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                    Chúc bạn một ngày mới vui vẻ!
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ml-auto">

                <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                            data-feather="moon"></i></a></li>


                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                        id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span
                                class="user-name font-weight-bolder">{{ Auth::user()->username }}</span><span
                                class="user-status">Đang hoạt động</span></div><span class="avatar"><img class="round"
                                src="{{ asset('vuexy/app-assets/images/portrait/small/avatar-s-11.jpg') }}"
                                alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="{{route('account')}}"><i class="mr-50" data-feather="user"></i>
                            Trang cá nhân</a>
                        <a class="dropdown-item" href="#"><i class="mr-50"
                                data-feather="credit-card"></i> Số dư {{ number_format(Auth::user()->coin) }}</a>
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"><i class="mr-50"
                                data-feather="power"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('dashboard') }}"><span
                            class="brand-logo">
                            <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%"
                                        y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%"
                                        x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path"
                                                d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                style="fill:currentColor"></path>
                                            <path id="Path1"
                                                d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                                points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                            </polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                                points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                            </polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                                                points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                            </polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg></span>
                        <h2 class="brand-text">{{ getSetting('website_name') }}</h2>
                    </a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li class="{!! active_menu(['account']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('account') }}"><i data-feather="user-check"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Tài khoản</span></a>
                </li>
                <li class="{!! active_menu(['dashboard']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('dashboard') }}"><i data-feather="shopping-cart"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Mua hàng</span></a>
                </li>
                @if (!checkEmptyType(4))
                    <li class="{!! active_menu(['muamail']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('muamail') }}"><i data-feather="mail"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Mua Mail</span></a>
                    </li>
                @endif
                <li class="{!! active_menu(['history_buy']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('history_buy') }}"><i data-feather="clock"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Lịch sử mua hàng</span></a>
                </li>
                <li class="{!! active_menu(['baiviet']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('baiviet') }}"><i data-feather="book"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Tut hay</span></a>
                </li>
                <li class=" navigation-header">Thanh toán</i>
                </li>
                <li class="{!! active_menu(['naptien']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('naptien') }}"><i data-feather="dollar-sign"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Nạp tiền</span></a>
                </li>
                <li class="{!! active_menu(['lichsunap']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('lichsunap') }}"><i data-feather="credit-card"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Lịch sử giao dịch</span></a>
                </li>
                <li class=" navigation-header">Công cụ</i>
                </li>
                <li class="{!! active_menu(['checkliveuid']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('checkliveuid') }}"><i data-feather="facebook"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Check Live UID</span></a>
                </li>
                <li class="{!! active_menu(['checkbm']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('checkbm') }}"><i data-feather="check-circle"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Check BM Limit / Live</span></a>
                </li>
                <li class="{!! active_menu(['tool2fa']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('tool2fa') }}"><i data-feather="key"></i><span
                            class="menu-title text-truncate" data-i18n="Email">2FA Tool</span></a>
                </li>
                <li class="{!! active_menu(['hotro']) !!} nav-item"><a class="d-flex align-items-center"
                        href="{{ route('hotro') }}"><i data-feather="phone-outgoing"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Hỗ trợ</span></a>
                </li>
                @can('admin_role')
                    <li class=" navigation-header">Admin</i>
                    </li>
                    <li class="{!! active_menu(['listUser']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('listUser') }}"><i data-feather="users"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Khách hàng</span></a>
                    </li>
                    <li class="{!! active_menu(['category_index']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('category_index') }}"><i data-feather="layers"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Danh sách thể loại</span></a>
                    </li>
                    <li class="{!! active_menu(['get_create_cate']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('get_create_cate') }}"><i data-feather="folder-plus"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Tạo thể loại</span></a>
                    </li>
                    <li class="{!! active_menu(['import']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('import') }}"><i data-feather="archive"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Import nguyên liệu</span></a>
                    </li>
                    <li class="{!! active_menu(['dropzone.index']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('dropzone.index') }}"><i data-feather="upload-cloud"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Upload Backup Via</span></a>
                    </li>
                    <li class="{!! active_menu(['buy_all']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('buy_all') }}"><i data-feather="list"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Lịch sử mua toàn hệ thống</span></a>
                    </li>
                    <li class="{!! active_menu(['deposit_all']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('deposit_all') }}"><i data-feather="pie-chart"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Lịch sử nạp tiền</span></a>
                    </li>
                    <li class="{!! active_menu(['addcoin']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('addcoin') }}"><i data-feather="edit-3"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Nạp tiền thủ công</span></a>
                    </li>
                    <li class="{!! active_menu(['posts']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('posts') }}"><i data-feather="book"></i><span class="menu-title text-truncate"
                                data-i18n="Email">Quản lý bài viết</span></a>
                    </li>
                    <li class="{!! active_menu(['setting']) !!} nav-item"><a class="d-flex align-items-center"
                            href="{{ route('setting') }}"><i data-feather="settings"></i><span
                                class="menu-title text-truncate" data-i18n="Email">Cài đặt Web</span></a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
