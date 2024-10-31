@extends("layouts.master")
@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow bg-warning" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa fa-2x fa-coins text-warning-light"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white font-size-h3 font-w300 mb-0">
                                    + {{ number_format($total_subday) }} VNĐ
                                </p>
                                <p class="text-white-75 mb-0">
                                    Tổng nạp hôm qua ( {{ \Carbon\Carbon::yesterday()->format('d/m/Y') }} )
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow bg-primary" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa fa-2x fa-coins text-primary-lighter"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white font-size-h3 font-w300 mb-0">
                                    + {{ number_format($total_date) }} VNĐ
                                </p>
                                <p class="text-white-75 mb-0">
                                    Tổng nạp hôm nay ( {{ \Carbon\Carbon::today()->format('d/m/Y') }} )
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow bg-success" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa fa-2x fa-coins text-success-light"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white font-size-h3 font-w300 mb-0">
                                    + {{ number_format($total_week) }} VNĐ
                                </p>
                                <p class="text-white-75 mb-0">
                                    Tổng nạp tuần này ( {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }} )
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow bg-danger" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fa fa-2x fa-coins text-danger-light"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white font-size-h3 font-w300 mb-0">
                                    + {{ number_format($total_month) }} VNĐ
                                </p>
                                <p class="text-white-75 mb-0">
                                    Tổng nạp tháng này : ( {{ \Carbon\Carbon::today()->format('m/Y') }} )
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default border-bottom bg-gd-dusk">
                    <h3 class="block-title" style="color: white;">Lịch Sử Giao Dịch</h3>
                </div>
                <div class="block-content">
                    Tìm kiếm
                    <form class="form-inline mb-4" action="" method="GET">
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email" name="trans_id"
                            placeholder="theo mã giao dịch" value="{{ request()->trans_id }}">
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password"
                            name="username" placeholder="theo username" value="{{ request()->username }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <div style="margin-top: 15px;">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Ngày giao dịch</th>
                                        <th>Mã giao dịch</th>
                                        <th>Khách hàng</th>
                                        <th>Số tiền</th>
                                        <th>Mô tả</th>
                                        <th>Admin xử lý giao dịch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($gethistory))
                                        @foreach ($gethistory as $item)
                                            <tr>
                                                <td>{{ format_time($item->created_at, 'd/m/Y H:i:s') }}</td>
                                                <td>{{ $item->trans_id }}</td>
                                                <td>{{ $item->getuser->username }}</td>
                                                <td>{{ number_format($item->coin) }}đ</td>

                                                <td><em>{{ $item->memo }} </em></td>
                                                <td>{{ $item->getadmin->username ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        Chưa có giao dịch nạp tiền!
                                    @endif
                                </tbody>
                            </table>
                            {{ $gethistory->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="block block-rounded block-bordered">
                <div class="block-content">
                    <h2>TOP 10 Nạp nhiều nhất trong tháng {{ date('m/Y') }} này</h2>
                    <div class="table-responsive push">
                        <table class="table table-hover table-striped table-borderless table-vcenter mb-0">
                            <tbody>
                                @if (!empty($top_deposit_month))
                                    @foreach ($top_deposit_month as $item)
                                        <tr>
                                            <td class="text-center" style="width: 140px;">
                                                <img class="img-avatar img-avatar-thumb"
                                                    src="{{ asset('assets/media/avatars/avatar12.jpg') }}" alt="">
                                            </td>
                                            <td style="min-width: 200px;">
                                                <div class="py-4">
                                                    <p class="mb-0">
                                                        <a class="link-fx font-w700 d-inline-block"
                                                            href="javascript:void(0)">
                                                            {{ $item->getuser->username }} </a>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="text-right" style="min-width: 160px;">
                                                <p class="font-size-h3 text-black mb-0">
                                                    <i class="fa fa-angle-up text-success mr-1"></i>
                                                    {{ number_format($item->total) }} VNĐ
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <!-- END Main Container -->
@endsection
