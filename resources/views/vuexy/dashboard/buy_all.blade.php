@extends("layouts.master")
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    Tìm kiếm
                    <form class="form-inline mb-4" action="" method="GET">
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email" name="id" placeholder="theo mã đơn" value="{{request()->id}}">
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password" name="username" placeholder="theo username" value="{{request()->username}}">
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password" name="phone" placeholder="theo sdt" value="{{request()->phone}}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <div style="margin-top: 15px;">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Mã Đơn</th>
                                        <th>Thời Gian</th>
                                        <th>Khách hàng</th>
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
                                                <td><a class=""
                                                        href="{{ route('don_hang', ['id' => $history->id]) }}">#{{ $history->id }}</a>
                                                </td>
                                                <td>
                                                    {{ format_time($history->created_at, 'd/m/Y H:i:s') }}
                                                </td>
                                                <td>{{ $history->getuser->username }}</td>
                                                <td>
                                                    <span class="label label-info"><em
                                                            class="font-size-sm text-muted">{{ $history->gettype->name }}</em></span>
                                                </td>
                                                <td>{{ $history->quantity }}</td>
                                                <td>{{ number_format($history->total_price) }}đ</td>
                                                <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                                    <span class="badge badge-success">Hoàn thành</span>
                                                </td>
                                                <td class="d-sm-table-cell text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('don_hang', ['id' => $history->id]) }}"
                                                            class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Xem Chi Tiết">
                                                            <i data-feather='eye'></i>
                                                        </a>
                                                        <a href="{{ route('export_txt', ['id' => $history->id]) }}"
                                                            class="btn btn-outline-danger js-click-ripple-enabled js-tooltip-enabled"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="Tải Về">
                                                            <i data-feather='arrow-down-circle'></i>
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
    </div>
    <!-- END: Content-->
@endsection
