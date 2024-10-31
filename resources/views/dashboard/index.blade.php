@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            @if ($posts)
                @foreach ($posts as $post)
                    <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <a class="alert-link" href="{{ route('posts.show', ['slug' => $post->slug]) }}"><i
                                    class="fa fa-fw fa-check-circle"></i> {{ $post->title }}</a>
                        </div>
                    </div>
                @endforeach
            @endif
            @if (empty($siteSetting['display_noti']['cd_value']))
                <div class="block block-rounded block-bordered">
                    <div class="block-header block-header-default">
                        <h4 class="block-title">{{ __('labels.title_notification') }}</h4>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option"
                                data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div
                            class="font-w600 animated fadeIn bg-body-light border-2x px-3 py-1 mb-3 shadow-sm mw-100 border-left border-success rounded-right">
                            {!! $siteSetting['header_notices']['cd_value'] ?? '' !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="content">
            @if (isset($siteSetting['display_product']['cd_value']) && $siteSetting['display_product']['cd_value'] == 'list')
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><?= __('labels.products_on_sale') ?></small></h3>
                    </div>
                    <div class="block-content block-content-full">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full2">
                            <thead>
                                <tr>
                                    <th><?= __('labels.product') ?></th>
                                    <th><?= __('labels.product_desc') ?></th>
                                    <th><?= __('labels.quantity') ?></th>
                                    <th><?= __('labels.price') ?></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($types)
                                    @foreach ($types as $type)
                                        @if (!empty($type->allCategory))
                                            @foreach ($type->allCategory as $item)
                                                @php
                                                    $sell_count = $item->sell()->count();
                                                @endphp
                                                <tr>
                                                    <td class="text-left">
                                                        @if (!empty($type['icon']))
                                                            <img src="{{ asset('assets/media/country/' . $type['icon']) }}"
                                                                alt="" width="30px" class="mr-1">
                                                        @else
                                                            <i class="nav-main-link-icon far fa fa-arrow-alt-circle-right mr-2"
                                                                style="font-size: 24px"></i>
                                                        @endif
                                                        {{ $item->name }}
                                                    </td>

                                                    <td class="text-left">
                                                        {{ $item->desc }}
                                                    </td>
                                                    <td class="text-left">
                                                        <span class="badge badge-primary">{{ $sell_count }}
                                                            <?= __('labels.product') ?></span>
                                                    </td>
                                                    <td class="text-left">
                                                        @if (Auth::user()->chietkhau != 0)
                                                            <i class="font-w400"
                                                                style="font-size: 0.77rem;"><del>{{ number_format($item->price) }}đ</del></i>
                                                            <i class="font-w400" style="font-size: 0.77rem;"></i> <strong
                                                                class="text-danger">»
                                                                {{ number_format(($item->price * (100 - Auth::user()->chietkhau)) / 100) }}đ</strong>
                                                        @else
                                                            <i class="font-w400" style="font-size: 0.77rem;"></i> <strong
                                                                class="text-danger">»
                                                                {{ number_format($item->price) }}đ</strong>
                                                        @endif
                                                    </td>

                                                    <td class="text-left">
                                                        @if ($sell_count == 0)
                                                            <button class="btn btn-hero-danger px-4" disabled><i
                                                                    class="fa fa-frown-open mr-1"></i>
                                                                <?= __('labels.out_of_stock') ?></button>
                                                        @else
                                                            <button class="btn btn-hero-primary px-4 buy-btn"
                                                                data-type-id="{{ $item->id }}"
                                                                data-name="{{ $item->name }}"
                                                                data-price="{{ Auth::user()->chietkhau != 0 ? ($item->price * (100 - Auth::user()->chietkhau)) / 100 : $item->price }}"
                                                                data-available="{{ $sell_count }}"><i
                                                                    class="fa fa-cart-plus mr-1"></i>
                                                                <?= __('labels.buy') ?></button>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="block block-rounded block-bordered">
                    <div class="block-header block-header-default">
                        <h4 class="block-title"><?= __('labels.search_by_product') ?></h4>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option"
                                data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form class="form-inline mb-4" action="" method="GET">
                            <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email"
                                name="name" placeholder="Nhập loại muốn tìm" value="{{ request()->name }}">
                            <button type="submit" class="btn btn-primary"><?= __('labels.search') ?></button>
                        </form>
                    </div>
                </div>

                @if ($types)
                    @foreach ($types as $type)
                        {{-- @if (!checkEmptyType($type['id']) && count($type->allCategory) > 0) --}}
                        <div class="block block-themed">
                            <div class="block-header bg-gd-dusk">
                                <h3 class="block-title">{{ $type['name'] }}
                                    @if (!empty($type['icon']))
                                        <img src="{{ asset('assets/media/country/' . $type['icon']) }}" alt=""
                                            width="30px" class="mr-1">
                                    @endif
                                </h3>
                            </div>
                            <div class="block-content block-content-full border-bottom">
                                <div class="row row-deck">
                                    @if (!empty($type->allCategory))
                                        @foreach ($type->allCategory as $item)
                                            @php
                                                $sell_count = $item->is_api ? $item->quantity_remain : $item->sell()->count();
                                            @endphp
                                            @if (isset($siteSetting['display_product']['cd_value']) && $siteSetting['display_product']['cd_value'] == 'iconbox')
                                                <div class="col-lg-6 col-xl-4 col-md-6 col-sm-12">
                                                    <div class="selectpackage">
                                                        <div class="col-md-12" style="position: static;">
                                                            <label class="p-3" style="cursor: auto;">
                                                                <span class="d-flex align-items-center">
                                                                    <div class="item item-circle text-black"
                                                                        style="min-width: 65px;">
                                                                        <strong style="font-size: 20px;">
                                                                            {{ $sell_count }} </strong>
                                                                    </div>
                                                                    <span class="ml-2">
                                                                        <h6 class="mb-1">{{ $item->name }}</h6>
                                                                        <span class="d-block">
                                                                            @if (Auth::user()->chietkhau != 0)
                                                                                <h6 class="mb-0"><del
                                                                                        style="color: #71695f;">{{ number_format($item->price) }}đ</del>
                                                                                    <font class="text-danger ml-1">»
                                                                                        {{ number_format(($item->price * (100 - Auth::user()->chietkhau)) / 100) }}đ
                                                                                    </font>
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="mb-0">
                                                                                    <font class="text-danger">»
                                                                                        {{ number_format($item->price) }}đ
                                                                                    </font>
                                                                                </h6>
                                                                            @endif
                                                                            <span class="d-block font-size-sm text-muted">
                                                                                {{ $item->desc }}
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                                </span></label>
                                                        </div>
                                                        <div class="col-md-12 d-flex"
                                                            style="margin-top: -10px;margin-bottom: 10px;">
                                                            <div class="col-lg-6 p-1">
                                                                <div class="float-right align-middle">
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btnShowInfoCategory"
                                                                        data-type-title="{{ $item->name }}"
                                                                        data-type-id="{{ $item->id }}"><i
                                                                            class="fas fa-info-circle"></i> Thông
                                                                        tin</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 p-1">
                                                                <div class="float-left align-middle">
                                                                    @if ($sell_count == 0)
                                                                        <button class="btn btn-outline-secondary"
                                                                            disabled><i class="fa fa-frown-open"></i>
                                                                            <?= __('labels.out_of_stock') ?></button>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-outline-primary px-4 buy-btn"
                                                                            data-type-id="{{ $item->id }}"
                                                                            data-name="{{ $item->name }}"
                                                                            data-price="{{ Auth::user()->chietkhau != 0 ? ($item->price * (100 - Auth::user()->chietkhau)) / 100 : $item->price }}"
                                                                            data-available="{{ $sell_count }}"><i
                                                                                class="fa fa-cart-plus mr-1"></i>
                                                                            <?= __('labels.buy') ?></button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-6 col-xl-2">
                                                    <a class="block block-rounded block-bordered block-link-pop block-themed text-center clone-item item-custom"
                                                        href="javascript:void(0)">
                                                        <div class="block-header">
                                                            <span
                                                                class="flex-fill font-size-h6 font-w400 js-tooltip-enabled"
                                                                data-toggle="tooltip" title=""
                                                                data-original-title="{{ $item->name }}">{{ $item->name }}</span>
                                                        </div>
                                                        <div class="block-content bg-body-light pt-2">
                                                            <div class="py-2">
                                                                <p class="h4 font-w700 mb-2 text-muted">
                                                                    @if (Auth::user()->chietkhau != 0)
                                                                        <i class="font-w400"
                                                                            style="font-size: 0.77rem;"><del>{{ number_format($item->price) }}đ</del></i>
                                                                        <i class="font-w400"
                                                                            style="font-size: 0.77rem;"></i> <strong
                                                                            class="text-danger">»
                                                                            {{ number_format(($item->price * (100 - Auth::user()->chietkhau)) / 100) }}đ</strong>
                                                                    @else
                                                                        <i class="font-w400"
                                                                            style="font-size: 0.77rem;"></i> <strong
                                                                            class="text-danger">»
                                                                            {{ number_format($item->price) }}đ</strong>
                                                                    @endif
                                                                </p>
                                                                <p class="h6 text-muted mb-1">
                                                                    <?= __('labels.remaning') ?>: <strong
                                                                        class="badge badge-success badge-pill font-size-h6 pl-2 pr-2">{{ $sell_count }}</strong>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="block-content block-content-full pricing_block">
                                                            <ul class="list-unstyled text-left">
                                                                @php
                                                                    $arr_desc = explode('|', $item->desc);
                                                                @endphp
                                                                @foreach ($arr_desc as $desc)
                                                                    <li><i class="fa fa-check text-success"></i>
                                                                        {{ $desc }}</li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                        <div
                                                            class="block-content block-content-full bg-body-light footer-btn">
                                                            <button type="button"
                                                                class="btn btn-alt-info btnShowInfoCategory"
                                                                data-type-title="{{ $item->name }}"
                                                                data-type-id="{{ $item->id }}"><i
                                                                    class="fas fa-info-circle"></i></button>
                                                            @if ($sell_count == 0)
                                                                <button class="btn btn-hero-danger" disabled><i
                                                                        class="fa fa-frown-open"></i>
                                                                    <?= __('labels.out_of_stock') ?></button>
                                                            @else
                                                                <button class="btn btn-hero-primary px-4 buy-btn"
                                                                    data-type-id="{{ $item->id }}"
                                                                    data-name="{{ $item->name }}"
                                                                    data-price="{{ Auth::user()->chietkhau != 0 ? ($item->price * (100 - Auth::user()->chietkhau)) / 100 : $item->price }}"
                                                                    data-available="{{ $sell_count }}"><i
                                                                        class="fa fa-cart-plus mr-1"></i>
                                                                    <?= __('labels.buy') ?></button>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                    @endforeach
                @endif
            @endif
        </div>

        <!-- Page Content -->
        <div class="content">

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
                                                    {{ $item->gettype->name }} -
                                                    {{ number_format($item->quantity * $item->gettype->price) }} VNĐ</font>
                                            </b>
                                            <span style="float: right;">
                                                <span class="badge badge-info js-tooltip-enabled" data-toggle="tooltip"
                                                    data-placement="top" title=""
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
                                                <span class="badge badge-info js-tooltip-enabled" data-toggle="tooltip"
                                                    data-placement="top" title=""
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
@endsection
