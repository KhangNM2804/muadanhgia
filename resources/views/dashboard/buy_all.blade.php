@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default border-bottom bg-gd-dusk"><h3 class="block-title" style="color: white;">Danh sách đơn hàng đã mua</h3></div>
            <div class="block-content">
                Tìm kiếm
                <form class="mb-4" action="" method="GET">
                    <div class="mb-4">
                        <label class="form-label" for="example-ltf-email">Theo mã đơn</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email" name="id" placeholder="Theo mã đơn" value="{{request()->id}}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="example-ltf-email">Theo UID</label>
                        <textarea class="form-control" name="uid" id="" cols="30" rows="5" placeholder="Có thể tìm số lượng lớn theo uid, mỗi uid 1 dòng">{{request()->uid}}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="example-ltf-email">Theo username</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password" name="username" placeholder="Theo username" value="{{request()->username}}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="example-ltf-email">Theo số điện thoại</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password" name="phone" placeholder="Theo sdt" value="{{request()->phone}}">
                    </div>
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
                                        <td><a class="" href="{{ route('don_hang', ['id' => $history->id]) }}">#{{$history->id}}</a></td>
                                        <td>
                                            {{format_time($history->created_at,"d/m/Y H:i:s")}}
                                        </td>
                                        <td>{{$history->getuser->username}}</td>
                                        <td>
                                            <span class="label label-info"><em class="font-size-sm text-muted">{{$history->gettype->name}}</em></span>
                                        </td>
                                        <td>{{$history->quantity}}</td>
                                        <td>{{number_format($history->total_price)}}đ</td>
                                        <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                            <span class="badge badge-success">Hoàn thành</span>
                                            @if ($history->trashed())
                                            <span class="badge badge-danger">Đã xoá phía client</span>
                                            @endif
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
                        {{ $getHistoryBuy->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</main>
@endsection