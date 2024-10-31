@extends('auth.master_auth.master')
@section('content')
    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image">
                <div class="row no-gutters justify-content-center bg-primary-dark-op">
                    <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                        <!-- Sign In Block -->
                        <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
                            <div class="row no-gutters">
                                <div class="col-md-12 order-md-1 bg-white">
                                    <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                                        <!-- Header -->
                                        <div class="mb-2 text-center">
                                            @if (!empty($siteSetting['web_logo']['cd_value'] ?? ''))
                                                <img src="{{ $siteSetting['web_logo']['cd_value'] ?? '' }}" alt="">
                                            @endif
                                        </div>
                                        <div class="mb-2 text-center">
                                            <a class="link-fx font-w700 font-size-h1" href="">
                                                <span
                                                    class="text-dark">{{ $siteSetting['website_name']['cd_value'] ?? '' }}</span><span
                                                    class="text-primary"></span>
                                            </a>
                                            <p class="text-uppercase font-w700 font-size-sm text-muted">
                                                <?= __('labels.login') ?></p>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger" role="alert">
                                                <p class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }} <br>
                                                    @endforeach
                                                </p>

                                            </div>
                                        @endif
                                        @if (Session::has('register_completed'))
                                            <div class="alert alert-success" role="alert">
                                                <p class="mb-0">
                                                    {{ Session::get('register_completed') }}
                                                </p>

                                            </div>
                                        @endif
                                        @if (Session::has('login_fail'))
                                            <div class="alert alert-danger" role="alert">
                                                <p class="mb-0">
                                                    {{ Session::get('login_fail') }}
                                                </p>

                                            </div>
                                        @endif
                                        <form action="{{ route('post.login') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-alt"
                                                    id="login-username" name="username"
                                                    placeholder="<?= __('labels.account') ?>"
                                                    value="{{ request()->old('username') ?? '' }}" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-alt"
                                                    id="login-password" name="password"
                                                    placeholder="<?= __('labels.password') ?>"
                                                    value="{{ request()->old('password') ?? '' }}" autocomplete="off">
                                            </div>
                                            @if (getSetting('flag_recaptcha') == 'on')
                                                {!! app('captcha')->display($attributes = [], $options = ['lang' => 'vi']) !!}
                                            @endif
                                            <div
                                                class="form-group d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-left">
                                                <div class="custom-control custom-checkbox custom-control-primary">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="login-remember-me" name="remember">
                                                    <label class="custom-control-label"
                                                        for="login-remember-me"><?= __('labels.remember') ?></label>
                                                </div>
                                                <div class="font-w600 font-size-sm py-1">
                                                    <a
                                                        href="{{ route('password.request') }}"><?= __('labels.forgot_password') ?></a>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-hero-primary">
                                                    <i class="fa fa-fw fa-sign-in-alt mr-1"></i> <?= __('labels.login') ?>
                                                </button>
                                            </div>
                                        </form>
                                        <div class="font-w600 font-size-sm py-1 text-center">
                                            <?= __('labels.no_account') ?> <a
                                                href="{{ route('get.register') }}"><?= __('labels.register') ?></a>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{ route('change_lang', ['locale' => 'vi']) }}"><img
                                                    src="{{ asset('assets/media/country/109-vietnam.png') }}"
                                                    width="25px"></a>
                                            <a href="{{ route('change_lang', ['locale' => 'en']) }}"><img
                                                    src="{{ asset('assets/media/country/110-united kingdom.png') }}"
                                                    width="25px"></a>
                                            <a href="{{ route('change_lang', ['locale' => 'th']) }}"><img
                                                    src="{{ asset('assets/media/country/088-thailand.png') }}"
                                                    width="25px"></a>
                                        </div>
                                        <!-- END Sign In Form -->
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- END Sign In Block -->
                    </div>
                </div>
            </div>
            {{-- <button class="btn btn-hero-danger scroll-down"><?= __('labels.click_show_product') ?></button> --}}
            <div class="content" id="selling-bm">
                @if ($types)
                    @foreach ($types as $type)
                        @if (!checkEmptyType($type['id']))
                            <div class="block block-rounded block-bordered">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title text-center">
                                        @if (!empty($type['icon']))
                                            <img src="{{ asset('assets/media/country/' . $type['icon']) }}" alt=""
                                                width="30px" class="mr-1">
                                        @endif
                                        <?= __('labels.list') ?> {{ $type['name'] }} <?= __('labels.sale_on_at') ?>
                                        {{ $siteSetting['website_name']['cd_value'] ?? '' }}
                                    </h3>
                                </div>
                                <div class="block-content block-content-full border-bottom">
                                    <div class="row">
                                        @foreach ($type->allCategory as $item)
                                            @php
                                                $sell_count = $item->is_api
                                                    ? $item->quantity_remain
                                                    : $item->sell()->count();
                                            @endphp
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 mb-1">
                                                <div class="custom-control custom-block custom-control-primary">
                                                    <label class="custom-control-label p-2" for="type-select-7">
                                                        <span class="d-flex align-items-center">
                                                            <div class="item item-circle bg-black-5 text-primary-light"
                                                                style="min-width: 60px;">
                                                                @if ($sell_count == 0)
                                                                    <span class="text-danger text-center font-weight-bolder"
                                                                        style="font-size: 9px;">SOLD OUT</span>
                                                                @else
                                                                    <strong
                                                                        class="text-primary">{{ $sell_count }}</strong>
                                                                @endif
                                                            </div>
                                                            <span class="text-truncate ml-2">
                                                                <span class="font-w700">{{ $item->name }}</span>
                                                                <span
                                                                    class="d-block font-size-sm text-muted">{{ $item->desc }}</span>
                                                                <i style="position: absolute; right: 5px; bottom: 10px;"
                                                                    class="fa fa-question-circle text-muted js-tooltip-enabled"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title=""
                                                                    data-original-title="{{ $item->desc }}"></i>
                                                                <span class="d-block font-size-sm text-muted">
                                                                    <i class="font-w400" style="font-size: 0.77rem;"></i>
                                                                    <strong class="text-danger">»
                                                                        {{ number_format($item->price) }}đ</strong>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                    <span class="custom-block-indicator">
                                                        <i class="fa fa-check"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif


                @if (empty($siteSetting['list_transaction_flg']['cd_value'] ?? null))
                    <!-- Users and Purchases -->
                    <div class="row row-deck">
                        <div class="col-xl-6 invisible" data-toggle="appear">
                            <!-- Users -->
                            <div class="block block-themed">
                                <div class="block-header bg-gd-dusk">
                                    <h3 class="block-title"><?= __('labels.orders_history') ?></h3>
                                </div>
                                <div class="block-content">
                                    @if ($getHistoryBuy)
                                        @foreach ($getHistoryBuy as $item)
                                            <div
                                                class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                                <b>
                                                    <font color="green"> <i class="fa fa-bell"></i>
                                                        {{ substr($item->getuser->username, 0, strlen($item->getuser->username) - 3) }}***
                                                    </font>:
                                                    <font color="red">Đã mua {{ $item->quantity }}
                                                        {{ $item->gettype->name }}
                                                        - {{ number_format($item->quantity * $item->gettype->price) }} VNĐ
                                                    </font>
                                                </b>
                                                <span style="float: right;">
                                                    <span class="badge badge-info js-tooltip-enabled"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="2021-02-20 17:45:52">
                                                        <em> {{ time_elapsed_string($item->created_at) }}</em>
                                                    </span>
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- END Users -->
                        </div>
                        <div class="col-xl-6 invisible" data-toggle="appear" data-timeout="200">
                            <!-- Purchases -->
                            <div class="block block-themed">
                                <div class="block-header bg-gd-dusk">
                                    <h3 class="block-title"><?= __('labels.transaction_history') ?></h3>
                                </div>
                                <div class="block-content">
                                    @if ($getHistoryBank)
                                        @foreach ($getHistoryBank as $item)
                                            <div
                                                class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                                <b>
                                                    <font color="green"> <i class="fa fa-bell"></i>
                                                        {{ substr($item->getuser->username, 0, strlen($item->getuser->username) - 3) }}***
                                                    </font>:
                                                    <font color="red">Đã nạp {{ number_format($item->coin) }} VNĐ -
                                                        {{ $item->type }}</font>
                                                </b>
                                                <span style="float: right;">
                                                    <span class="badge badge-info js-tooltip-enabled"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="2021-02-20 17:45:52">
                                                        <em> {{ time_elapsed_string($item->created_at) }}</em>
                                                    </span>
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- END Purchases -->
                        </div>
                    </div>
                    <!-- END Users and Purchases -->
                @endif
            </div>

            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
@endsection
