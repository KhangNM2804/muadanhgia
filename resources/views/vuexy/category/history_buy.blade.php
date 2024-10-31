@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lịch sử mua hàng</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Thời Gian</th>
                            <th>Loại</th>
                            <th>Số Lượng</th>
                            <th>Tổng Đơn Hàng</th>
                            <th>Trạng Thái</th>
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
                                        <span class="badge badge-success">Hoàn thành</span>
                                    </td>
                                    <td class="d-sm-table-cell text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('don_hang', ['id' => $history->id]) }}" class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Xem Chi Tiết">
                                                <i data-feather='eye'></i>
                                            </a>
                                            <a href="{{ route('export_txt', ['id' => $history->id]) }}" class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tải Về">
                                                <i data-feather='download'></i>
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
    <!-- END: Content-->
@endsection
