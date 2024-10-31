@extends("layouts.master")
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0">+ {{ number_format($total_subday) }} VNĐ</h2>
                                <p class="card-text">Tổng nạp hôm qua ( {{  \Carbon\Carbon::yesterday()->format("d/m/Y") }} )</p>
                            </div>
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu font-medium-5"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0">+ {{ number_format($total_date) }} VNĐ</h2>
                                <p class="card-text">Tổng nạp hôm nay ( {{  \Carbon\Carbon::today()->format("d/m/Y") }} )</p>
                            </div>
                            <div class="avatar bg-light-success p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server font-medium-5"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0">+ {{ number_format($total_week) }} VNĐ</h2>
                                <p class="card-text">Tổng nạp tuần này ( {{  \Carbon\Carbon::now()->startOfWeek()->format("d/m/Y") }} - {{  \Carbon\Carbon::now()->endOfWeek()->format("d/m/Y") }} )</p>
                            </div>
                            <div class="avatar bg-light-danger p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity font-medium-5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0">+ {{ number_format($total_month) }} VNĐ</h2>
                                <p class="card-text">Tổng nạp tháng này : ( {{  \Carbon\Carbon::today()->format("m/Y") }} )</p>
                            </div>
                            <div class="avatar bg-light-warning p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon font-medium-5"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    
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

        </div>
    </div>
    <!-- END: Content-->
@endsection
