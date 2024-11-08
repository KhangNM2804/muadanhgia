@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default border-bottom bg-gd-dusk">
                    <h3 class="block-title" style="color: white;"><?= __('labels.orders_history') ?></h3>
                </div>

                <div class="block-content">
                    <form method="GET" action="{{ route('history_buy') }}" class="form-inline mb-3">
                        <input type="text" name="code" class="form-control mr-2" placeholder="Mã đơn hàng"
                            value="{{ request('code') }}">
                        @php
                            $listType = getTypeOrder();
                        @endphp
                        <select name="type_order_id" class="form-control mr-2">
                            <option value="">Chọn loại đơn hàng</option>
                            @foreach ($listType as $type)
                                <option value="{{ $type->id }}"
                                    {{ request('type_order_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="date_from" class="form-control mr-2" value="{{ request('date_from') }}"
                            placeholder="Từ ngày">
                        <input type="date" name="date_to" class="form-control mr-2" value="{{ request('date_to') }}"
                            placeholder="Đến ngày">
                        <select name="per_page" class="form-control mr-2">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 dòng</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 dòng</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 dòng</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <div style="margin-top: 15px;">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th><?= __('labels.code') ?></th>
                                        <th><?= __('labels.type_order') ?></th>
                                        <th><?= __('labels.price') ?></th>
                                        <th><?= __('labels.total_money') ?></th>
                                        <th><?= __('labels.created_at') ?></th>
                                        <th><?= __('labels.status') ?></th>
                                        <th><i class="far fa-question-circle"></i></th>
                                    </tr>
                                </thead>
                                <tbody data-store='@json($getHistoryBuy)'>
                                    @if ($getHistoryBuy)
                                        @foreach ($getHistoryBuy as $history)
                                            <tr>
                                                <td class="text-left">{{ $history->code }}</td>
                                                <td class="text-left"><span
                                                        class="label label-info">{{ $history->type->name }}</span></td>
                                                <td>{{ number_format($history->price) }}đ</td>
                                                <td>{{ number_format($history->total_money) }}đ</td>
                                                <td>{{ format_time($history->created_at, 'd/m/Y H:i:s') }}</td>
                                                <td>{!! $history->status_label !!}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger btn-view-order"
                                                        data-id="{{ $history->id }}" data-toggle="modal"
                                                        data-target="#orderDetailModal">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">Chưa có đơn hàng nào!</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                            {{ $getHistoryBuy->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal hiển thị chi tiết đơn hàng -->
        <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="orderDetailsContent" class="row">
                            <div class="col-md-6">
                                <p id="field-order-code"><strong>Mã đơn hàng:</strong> <span id="order-code"></span></p>
                                <p id="field-order-type"><strong>Loại đơn hàng:</strong> <span id="order-type"></span></p>
                                <p id="field-order-price"><strong>Giá:</strong> <span id="order-price"></span>đ</p>
                                <p id="field-order-total"><strong>Tổng tiền:</strong> <span id="order-total"></span>đ</p>
                                <p id="field-order-created-at"><strong>Ngày tạo:</strong> <span
                                        id="order-created-at"></span></p>

                                <p id="field-order-content"> <strong>Nội dung:</strong> <br><span id="order-content"></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p id="field-order-status"><strong>Trạng thái:</strong> <span id="order-status"></span></p>
                                <p id="field-order-notes"><strong>Ghi chú:</strong> <span id="order-notes"></span></p>
                                <p id="field-order-link"><strong>Liên kết:</strong> <a id="order-link" href="#"
                                        target="_blank">Xem chi tiết</a></p>
                                <p id="field-order-total-quantity"><strong>Số lượng tổng cộng:</strong> <span
                                        id="order-total-quantity"></span></p>
                                <p id="field-order-quantity-run"><strong>Số lượng đã chạy:</strong> <span
                                        id="order-quantity-run"></span></p>
                                <p id="field-order-images"><strong>Hình ảnh:</strong> <br><span id="order-images"></span>
                                </p>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>


    </main>
    <script>
        $(document).ready(function() {
            // Lấy dữ liệu từ thuộc tính data-store và parse thành mảng
            const historyData = JSON.parse($('tbody[data-store]').attr('data-store'));
            const orders = historyData.data || [];
            console.log(historyData);

            $('.btn-view-order').on('click', function() {
                const historyId = $(this).data('id');
                const history = orders.find(item => item.id === historyId);
                console.log(history);

                if (history) {
                    // Cập nhật các trường dữ liệu và ẩn các trường không có dữ liệu
                    $('#field-order-code').toggle(!!history.code).find('#order-code').text(history.code ||
                        '');
                    $('#field-order-type').toggle(!!history.type?.name).find('#order-type').text(history
                        .type?.name || '');
                    $('#field-order-price').toggle(!!history.price).find('#order-price').text(new Intl
                        .NumberFormat().format(history.price));
                    $('#field-order-total').toggle(!!history.total_money).find('#order-total').text(new Intl
                        .NumberFormat().format(history.total_money));
                    $('#field-order-created-at').toggle(!!history.created_at).find('#order-created-at')
                        .text(moment(history.created_at).format('DD/MM/YYYY HH:mm:ss') || '');

                    $('#field-order-status').toggle(!!history.status_label).find('#order-status').html(
                        history.status_label || 'N/A');
                    $('#field-order-notes').toggle(!!history.note).find('#order-notes').text(history.note ||
                        'Không có ghi chú');
                    $('#field-order-link').toggle(!!history.link).find('#order-link').attr('href', history
                        .link || '#').text('Xem chi tiết');
                    $('#field-order-total-quantity').toggle(!!history.total_quantity).find(
                        '#order-total-quantity').text(history.total_quantity || '');
                    $('#field-order-quantity-run').toggle(!!history.quantity_run).find(
                        '#order-quantity-run').text(history.quantity_run || 'N/A');
                    $('#field-order-content').toggle(!!history.content).find('#order-content').html(history
                        .content ? JSON.parse(history.content).join("<br>") : 'N/A');

                    if (history.images) {
                        $('#field-order-images').show().find('#order-images').html(
                            JSON.parse(history.images).map(img =>
                                `<img src="/storage/app/review_images/${img}" alt="Order Image" style="width: 100px; margin: 5px;">`
                            ).join('')
                        );
                    } else {
                        $('#field-order-images').hide();
                    }
                }
            });
        });
    </script>
@endsection
