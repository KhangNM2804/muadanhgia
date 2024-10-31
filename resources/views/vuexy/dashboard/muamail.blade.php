@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="card-title text-white">Thông báo từ hệ thống</h4>
                    <p class="card-text">{!!getSetting('header_notices')!!}</p>
                </div>
            </div>
            @if (count($listMail) > 0)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="text-primary" data-feather='briefcase'></i> Danh sách Mail</h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Chi tiết</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($listMail as $item)
                                <tr>
                                    <td>
                                        <span class="font-weight-bold">{{$item->name}}</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold"><i data-feather='info'></i> {{$item->desc}}</span>
                                    </td>
                                    <td>
                                        @if($item->sell->count() > 0)
                                            <div class="badge badge-glow badge-primary">Còn {{$item->sell->count()}}</div>
                                        @else
                                            <div class="badge badge-glow badge-danger">Hết hàng</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold"><i class="text-danger" data-feather='chevrons-right'></i> {{number_format($item->price)}}đ</span>
                                    </td>
                                    <td>
                                        @if($item->sell->count() > 0)
                                            <button type="button" data-type-id="{{$item->id}}" data-name="{{$item->name}}" data-price="{{$item->price}}" data-available="{{$item->sell->count()}}" class="btn btn-primary waves-effect waves-float waves-light buy-btn">Mua</button>
                                        @else
                                            <button type="button" class="btn btn-danger waves-effect waves-float waves-light disabled">Mua</button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="row match-height">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="card-title text-white">Lịch sử mua gần nhất</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group mt-1">
                                @if ($getHistoryBuy)
                                    @foreach ($getHistoryBuy as $item)
                                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="">{{substr($item->getuser->username,0,strlen($item->getuser->username)-3)}}*** dã mua {{$item->quantity}} {{$item->gettype->name}} - {{number_format($item->gettype->price)}} VNĐ</h5>
                                                <small class="text-secondary">{{time_elapsed_string($item->created_at)}}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header btn-primary">
                            <h4 class="card-title text-white">Lịch sử nạp tiền gần nhất</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group mt-1">
                                @if ($getHistoryBank)
                                    @foreach ($getHistoryBank as $item)
                                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="">{{substr($item->getuser->username,0,strlen($item->getuser->username)-3)}}*** đã nạp {{number_format($item->coin)}} VNĐ - {{$item->type}}</h5>
                                                <small class="text-secondary">{{time_elapsed_string($item->created_at)}}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
