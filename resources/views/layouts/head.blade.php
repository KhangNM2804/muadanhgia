<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ $siteSetting['website_title']['cd_value'] ?? '' }}</title>

    <meta name="description" content="{{ $siteSetting['website_name']['cd_value'] ?? '' }}">
    <meta name="author" content="thanhtrungit.net">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ $siteSetting['website_title']['cd_value'] ?? '' }}">
    <meta property="og:site_name" content="{{ $siteSetting['website_description']['cd_value'] ?? '' }}">
    <meta property="og:description" content="{{ $siteSetting['website_description']['cd_value'] ?? '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="{{ $siteSetting['image_share']['cd_value'] ?? '' }}">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ $siteSetting['favicon']['cd_value'] ?? '' }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ $siteSetting['favicon']['cd_value'] ?? '' }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $siteSetting['favicon']['cd_value'] ?? '' }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/highlightjs/styles/atom-one-light.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/Holdon/HoldOn.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=' . time()) }}">
    @stack('style')
    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <!-- END Stylesheets -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    {!! $siteSetting['gg_analytics']['cd_value'] ?? '' !!}
</head>

<body>
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <!-- Side Overlay-->
        <aside id="side-overlay">
            <!-- Side Header - Close Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="content-header bg-body-dark justify-content-center text-danger" data-toggle="layout"
                data-action="side_overlay_close" href="javascript:void(0)">
                <i class="fa fa-2x fa-times-circle"></i>
            </a>
            <!-- END Side Header - Close Side Overlay -->
        </aside>
        <!-- END Side Overlay -->

        <!-- Sidebar -->
        <!--
                Sidebar Mini Mode - Display Helper classes

                Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

                Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
                Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
                Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
            -->
        <nav id="sidebar" aria-label="Main Navigation">
            <!-- Side Header (mini Sidebar mode) -->
            <div class="smini-visible-block">
                <div class="content-header">
                    <!-- Logo -->
                    <a class="link-fx font-size-lg text-white" href="{{ route('dashboard') }}">
                        <span class="text-white-75">D</span><span class="text-white">M</span>
                    </a>
                    <!-- END Logo -->
                </div>
            </div>
            <!-- END Side Header (mini Sidebar mode) -->

            <!-- Side Header (normal Sidebar mode) -->
            <div class="bg-header-dark">
                <div class="content-header justify-content-lg-center">
                    <!-- Logo -->
                    <a class="link-fx font-size-lg text-white font-w600" href="{{ route('dashboard') }}">
                        {{ $siteSetting['website_name']['cd_value'] ?? '' }}
                    </a>
                    <!-- END Logo -->

                    <!-- Options -->
                    <div class="d-lg-none">
                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="text-white ml-2" data-toggle="layout" data-action="sidebar_close"
                            href="javascript:void(0)">
                            <i class="fa fa-times-circle"></i>
                        </a>
                        <!-- END Close Sidebar -->
                    </div>
                    <!-- END Options -->
                </div>
            </div>
            <!-- END Side Header (normal Sidebar mode) -->

            <!-- Side Navigation -->
            <div class="js-sidebar-scroll">
                <div class="content-side content-side-full text-center pb-0">
                    <div class="smini-hide">
                        <a class="img-link d-block mb-2" href="{{ route('account') }}">
                            <img class="img-avatar img-avatar-thumb"
                                src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                        </a>
                        <a class="font-w600 text-dual" href="{{ route('account') }}">{{ Auth::user()->username }} -
                            ID: {{ Auth::user()->id }}</a><br>
                        @if (Auth::user()->role == 1)
                            <span class="badge badge-danger badge-pill">admin</span>
                        @elseif(Auth::user()->role == 2)
                            <span class="badge badge-warning badge-pill">nhân viên</span>
                        @else
                            <span class="badge badge-primary badge-pill">member</span>
                        @endif
                        <span class="badge badge-info  badge-pill"><?= __('labels.balance') ?>: <span
                                id="top_balance">{{ number_format(Auth::user()->coin) }}</span></span>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('change_lang', ['locale' => 'vi']) }}"><img
                                src="{{ asset('assets/media/country/109-vietnam.png') }}" width="25px"></a>
                        <a href="{{ route('change_lang', ['locale' => 'en']) }}"><img
                                src="{{ asset('assets/media/country/110-united kingdom.png') }}" width="25px"></a>
                        <a href="{{ route('change_lang', ['locale' => 'th']) }}"><img
                                src="{{ asset('assets/media/country/088-thailand.png') }}" width="25px"></a>
                    </div>
                </div>
                <div class="content-side">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['account']) !!}" href="{{ route('account') }}">
                                <i class="nav-main-link-icon fa fa-2x fa-user"></i>
                                <span class="nav-main-link-name"><?= __('labels.account') ?></span>
                            </a>
                        </li>
                        <li class="nav-main-heading">Thanh toán</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['naptien']) !!}" href="{{ route('naptien') }}">
                                <i class="nav-main-link-icon fa fa-dollar-sign"></i>
                                <span class="nav-main-link-name"><?= __('labels.recharge') ?></span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['lichsunap']) !!}" href="{{ route('lichsunap') }}">
                                <i class="nav-main-link-icon si si-credit-card"></i>
                                <span class="nav-main-link-name"><?= __('labels.charge_history') ?></span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['history_buy']) !!}" href="{{ route('history_buy') }}">
                                <i class="nav-main-link-icon fa fa-history"></i>
                                <span class="nav-main-link-name"><?= __('labels.orders_history') ?></span>
                            </a>
                        </li>
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['ticket.index']) !!}" href="{{ route('ticket.index') }}">
                                <i class="nav-main-link-icon fas fa-clipboard-check"></i>
                                @can('admin_role')
                                    <span class="nav-main-link-name">Quản lý tickets</span>
                                @else
                                    <span class="nav-main-link-name"><?= __('labels.tickets') ?></span>
                                @endcan
                                <span
                                    class="nav-main-link-badge badge badge-pill badge-danger">{{ get_unread_tickets() }}</span>
                            </a>
                        </li> --}}
                        @php
                            $listType = getTypeOrder();
                        @endphp
                        @if ($listType)
                            <li class="nav-main-item open">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                    aria-haspopup="true" aria-expanded="true" href="#">
                                    <i class="nav-main-link-icon si si-social-google"></i>
                                    <span class="nav-main-link-name"><?= __('labels.gg_map') ?></span>
                                </a>
                                <ul class="nav-main-submenu">
                                    @foreach ($listType as $type)
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ (request()->path ?? '') == $type->path ? 'active' : '' }}"
                                                href="{{ route('orders.create', ['path' => $type->path]) }}">
                                                <span class="nav-main-link-name">{{ $type->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                        <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['baiviet']) !!}" href="{{ route('baiviet') }}">
                                <i class="nav-main-link-icon far fa fa-file-alt"></i>
                                <span class="nav-main-link-name"><?= __('labels.tutorials') ?></span>
                            </a>
                        </li>

                        {{-- <li class="nav-main-heading"><?= __('labels.tools') ?></li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['share_tkqc_to_via']) !!}" href="{{ route('share_tkqc_to_via') }}">
                                <i class="nav-main-link-icon fa fa-code text-danger"></i>
                                <span class="nav-main-link-name">Share TKQC</span>
                                <span class="nav-main-link-badge badge badge-pill badge-danger">hot</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['xmdt.index']) !!}" href="{{ route('xmdt.index') }}">
                                <i class="nav-main-link-icon fa fa-address-card text-primary"></i>
                                <span class="nav-main-link-name">Tạo phôi XMDT</span>
                                <span class="nav-main-link-badge badge badge-pill badge-danger">hot</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['setting_api']) !!}" href="{{ route('setting_api') }}">
                                <i class="nav-main-link-icon fa fa-code text-danger"></i>
                                <span class="nav-main-link-name"><?= __('labels.connect_api') ?></span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['checkliveuid']) !!}" href="{{ route('checkliveuid') }}">
                                <i class="nav-main-link-icon fab fa-facebook-f"></i>
                                <span class="nav-main-link-name"><?= __('labels.check_live_uid') ?></span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['checkbm']) !!}" href="{{ route('checkbm') }}">
                                <i class="nav-main-link-icon fa fa-check-circle"></i>
                                <span class="nav-main-link-name"><?= __('labels.checkbm') ?></span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['checkbmxmdt']) !!}" href="{{ route('checkbmxmdt') }}">
                                <i class="nav-main-link-icon fa fa-check-circle"></i>
                                <span class="nav-main-link-name">Check BM XMDN</span>
                                <span class="nav-main-link-badge badge badge-pill badge-danger">hot</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['tool2fa']) !!}" href="{{ route('tool2fa') }}">
                                <i class="nav-main-link-icon fa fa-lock"></i>
                                <span class="nav-main-link-name"><?= __('labels.2fatool') ?></span>
                            </a>
                        </li> --}}
                        <li class="nav-main-item">
                            <a class="nav-main-link {!! active_menu(['hotro']) !!}" href="{{ route('hotro') }}">
                                <i class="nav-main-link-icon fa fa-headset"></i>
                                <span class="nav-main-link-name"><?= __('labels.support') ?></span>
                            </a>
                        </li>

                        @can('staff_role')
                            <li class="nav-main-heading">Admin</li>
                        @endcan
                        @can('admin_role')
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['listUser']) !!}" href="{{ route('listUser') }}">
                                    <i class="nav-main-link-icon si si-users"></i>
                                    <span class="nav-main-link-name">Khách hàng</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['type.index']) !!}" href="{{ route('type.index') }}">
                                    <i class="nav-main-link-icon fa fa-list-ol"></i>
                                    <span class="nav-main-link-name">Quản lý danh mục</span>
                                </a>
                            </li>
                            {{-- <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['category_index']) !!}" href="{{ route('category_index') }}">
                                    <i class="nav-main-link-icon si si-social-dropbox"></i>
                                    <span class="nav-main-link-name">Danh sách thể loại</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['import']) !!}" href="{{ route('import') }}">
                                    <i class="nav-main-link-icon si si-list"></i>
                                    <span class="nav-main-link-name">Import nguyên liệu</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['get_listviasell']) !!}" href="{{ route('get_listviasell') }}">
                                    <i class="nav-main-link-icon fab fa-buysellads"></i>
                                    <span class="nav-main-link-name">Danh sách đang bán</span>
                                </a>
                            </li> --}}
                            {{-- <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['dropzone.index']) !!}" href="{{ route('dropzone.index') }}">
                                    <i class="nav-main-link-icon fa fa-cloud-upload-alt"></i>
                                    <span class="nav-main-link-name">Upload Backup Via</span>
                                </a>
                            </li> --}}
                            {{-- <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['dropzone_phoi.index']) !!}"
                                    href="{{ route('dropzone_phoi.index') }}">
                                    <i class="nav-main-link-icon fa fa-cloud-upload-alt"></i>
                                    <span class="nav-main-link-name">Upload Phôi via</span>
                                </a>
                            </li> --}}
                        @endcan
                        @can('staff_role')
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['buy_all']) !!}" href="{{ route('buy_all') }}">
                                    <i class="nav-main-link-icon si si-pin"></i>
                                    <span class="nav-main-link-name">Lịch sử mua toàn hệ thống</span>
                                </a>
                            </li>
                        @endcan
                        @can('admin_role')
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['deposit_all']) !!}" href="{{ route('deposit_all') }}">
                                    <i class="nav-main-link-icon si si-rocket"></i>
                                    <span class="nav-main-link-name">Lịch sử nạp tiền</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['login_history']) !!}" href="{{ route('login_history') }}">
                                    <i class="nav-main-link-icon si si-credit-card"></i>
                                    <span class="nav-main-link-name">Login History</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['doanhthu_chart']) !!}" href="{{ route('doanhthu_chart') }}">
                                    <i class="nav-main-link-icon fa fa-chart-pie"></i>
                                    <span class="nav-main-link-name">Biểu đồ doanh thu</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['addcoin']) !!}" href="{{ route('addcoin') }}">
                                    <i class="nav-main-link-icon si si-rocket"></i>
                                    <span class="nav-main-link-name">Nạp tiền thủ công</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['posts']) !!}" href="{{ route('posts') }}">
                                    <i class="nav-main-link-icon fa fa-book"></i>
                                    <span class="nav-main-link-name">Quản lý bài viết</span>
                                </a>
                            </li>
                            {{-- <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['setting_telegram']) !!}" href="{{ route('setting_telegram') }}">
                                    <i class="nav-main-link-icon fab fa-telegram"></i>
                                    <span class="nav-main-link-name">Cấu hình BOT telegram</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['list_api_connect']) !!}" href="{{ route('list_api_connect') }}">
                                    <i class="nav-main-link-icon si si-share"></i>
                                    <span class="nav-main-link-name">Kết nối API</span>
                                </a>
                            </li> --}}
                            <li class="nav-main-item">
                                <a class="nav-main-link {!! active_menu(['setting']) !!}" href="{{ route('setting') }}">
                                    <i class="nav-main-link-icon si si-settings"></i>
                                    <span class="nav-main-link-name">Cài đặt Web</span>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </div>
            </div>
            <!-- END Side Navigation -->
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div>
                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                    <button type="button" class="btn btn-dual" data-toggle="layout" data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>
                <!-- END Left Section -->
                @if (!empty($siteSetting['header_noti_marquee']['cd_value']))
                    <div style="width: 50%;">
                        <marquee width="100%" direction="left"
                            style="background:yellow; border-radius:25px; font-weight:700" scrolldelay="20"
                            behavior="scroll" scrollamount="3">
                            {{ $siteSetting['header_noti_marquee']['cd_value'] }}
                        </marquee>
                    </div>
                @endif
                <!-- Right Section -->
                <div>
                    <!-- User Dropdown -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-dual" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-fw fa-user-circle"></i>
                            <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right p-0"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                                <img class="img-avatar img-avatar48 img-avatar-thumb"
                                    src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                <div class="pt-2">
                                    <a class="text-white font-w600"
                                        href="{{ route('account') }}">{{ Auth::user()->username }}</a>
                                </div>
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item" href="{{ route('account') }}">
                                    <i class="far fa-fw fa-user mr-1"></i> <?= __('labels.account') ?>
                                </a>
                                <a class="dropdown-item" href="{{ route('lichsunap') }}">
                                    <i class="far fa-fw fa-file-alt mr-1"></i> <?= __('labels.transaction_history') ?>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-wallet fa-fw mr-1"></i>
                                    <?= __('labels.balance') ?>: {{ number_format(Auth::user()->coin) }}
                                </a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> <?= __('labels.logout') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- END User Dropdown -->
                </div>
                <!-- END Right Section -->
            </div>
            <!-- END Header Content -->



            <!-- Header Loader -->
            <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
            <div id="page-header-loader" class="overlay-header bg-primary-darker">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->
