@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default border-bottom bg-gd-dusk">
                    <h3 class="block-title" style="color: white;"><?= __('labels.orders_history') ?></h3>
                </div>
                <div class="block-content">
                    <div>
                        <button type="button" class="btn btn-sm 
                        btn-success">
                            <i class="si si-wallet"></i> Số dư: {{ number_format($api->balance) }}
                        </button>
                        <a href="{{ route('get_api_manager_category', ['id' => $api->id]) }}" class="btn btn-sm btn-danger">
                            <i class="si si-list"></i> Quản lý danh mục
                        </a>
                        <a href="{{ route('get_api_manager_product', ['id' => $api->id]) }}" class="btn btn-sm btn-success">
                            <i class="si si-handbag"></i> Quản lý sản phẩm
                        </a>
                        <a href="{{ route('api_edit_site', ['id' => $api->id]) }}" class="btn btn-sm btn-danger">
                            <i class="si si-action-undo"></i> Quay lại
                        </a>
                    </div>
                    <div style="margin-top: 15px;">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?= __('labels.order_no') ?></th>
                                        <th><?= __('labels.time') ?></th>
                                        <th><?= __('labels.type') ?></th>
                                        <th>Giá gốc từ API</th>
                                        <th>Lãi</th>
                                        <th class="text-center"><?= __('labels.order_status') ?></th>
                                        <th class="text-center"><i class="far fa-question-circle"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($getHistoryBuy)
                                        @foreach ($getHistoryBuy as $history)
                                            <tr>
                                                <td class="text-center"><a
                                                        href="{{ route('don_hang', ['id' => $history->id]) }}">#{{ $history->id }}</a>
                                                </td>
                                                <td>
                                                    {{ format_time($history->created_at, 'd/m/Y H:i:s') }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>{{ $history->gettype->name }}</li>
                                                        <li>Số lượng: {{ $history->quantity }}</li>
                                                        <li>Giá bán: <span
                                                                class="badge badge-danger">{{ number_format($history->price) }}đ</span>
                                                        </li>
                                                        <li>Tổng tiền: <span
                                                                class="badge badge-danger">{{ number_format($history->total_price) }}đ</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li>Giá gốc: <span
                                                                class="badge badge-warning">{{ number_format($history->price_api) }}đ</span>
                                                        </li>
                                                        <li>Tổng tiền: <span
                                                                class="badge badge-warning">{{ number_format($history->price_actual) }}đ</span>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td><span
                                                        class="badge badge-success">{{ number_format($history->profit) }}đ</span>
                                                </td>
                                                <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                                    <span class="badge badge-success"><?= __('labels.completed') ?></span>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('don_hang', ['id' => $history->id]) }}"
                                                            class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Xem Chi Tiết">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('export_txt', ['id' => $history->id]) }}"
                                                            class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Tải Về">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        Chưa có đơn hàng nào!
                                    @endif

                                </tbody>
                            </table>
                            {{ $getHistoryBuy->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
