@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default border-bottom bg-gd-dusk"><h3 class="block-title" style="color: white;"><?= __('labels.orders_history') ?></h3></div>
            <div class="block-content">
                <div style="margin-top: 15px;">
                    <div class="react-bootstrap-table table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th><?= __('labels.order_no') ?></th>
                                    <th><?= __('labels.time') ?></th>
                                    <th><?= __('labels.type') ?></th>
                                    <th><?= __('labels.quantity') ?></th>
                                    <th><?= __('labels.total_amount') ?></th>
                                    <th><?= __('labels.order_status') ?></th>
                                    <th><i class="far fa-question-circle"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getHistoryBuy)
                                    @foreach ($getHistoryBuy as $history)
                                    <tr>
                                        <td><a class="" href="{{ route('don_hang', ['id' => $history->id]) }}">#{{$history->id}}</a></td>
                                        <td>
                                            {{format_time($history->created_at,"d/m/Y H:i:s")}}
                                        </td>
                                        <td>
                                            <span class="label label-info"><em class="font-size-sm text-muted">{{$history->gettype->name}}</em></span>
                                        </td>
                                        <td>{{$history->quantity}}</td>
                                        <td>{{number_format($history->total_price)}}đ</td>
                                        <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                            <span class="badge badge-success"><?= __('labels.completed') ?></span>
                                        </td>
                                        <td class="d-sm-table-cell text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('don_hang', ['id' => $history->id]) }}" class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xem Chi Tiết">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ route('export_txt', ['id' => $history->id]) }}" class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tải Về">
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