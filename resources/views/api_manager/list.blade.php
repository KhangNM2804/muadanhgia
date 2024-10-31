@extends('layouts.master')
@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
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
                                    Lợi nhuận hôm qua ( {{ \Carbon\Carbon::yesterday()->format('d/m/Y') }} )
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
                                    Lợi nhuận hôm nay ( {{ \Carbon\Carbon::today()->format('d/m/Y') }} )
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
                                    Lợi nhuận tuần này ( {{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }} -
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
                                    Lợi nhuận tháng này : ( {{ \Carbon\Carbon::today()->format('m/Y') }} )
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">Vui lòng cấu hình cronjob <strong>php artisan command:sync-product-api</strong> để
                    tự động cập nhật sản phẩm và giá
                </p>
            </div>
            <!-- Table -->
            <div class="block block-themed">
                <div class="block-header bg-gd-dusk">
                    <h3 class="block-title">Danh sách website đang kết nối</h3>
                </div>
                <div class="block-content">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            <p class="mb-0">
                                {{ Session::get('success') }}
                            </p>

                        </div>
                    @endif

                    <a href="{{ route('api_add_site') }}" class="btn btn-alt-primary">
                        <i class="fa fa-fw fa-check mr-1"></i> Thêm website đấu api
                    </a>
                    <table class="table table-vcenter mt-2">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#ID</th>
                                <th>Website</th>
                                <th>API_KEY</th>
                                <th>Số dư</th>
                                <th>Trạng thái</th>
                                <th>Hệ thống</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($apis)
                                @foreach ($apis as $item)
                                    <tr>
                                        <th class="text-center" scope="row">{{ $item->id }}</th>
                                        <td class="font-w600">
                                            {{ $item->domain }}
                                        </td>
                                        <td class="font-w600">
                                            {{ $item->api_key }}
                                        </td>
                                        <td class="font-w600">
                                            {{ number_format($item->balance) }}
                                        </td>
                                        <td>
                                            @if ($item->active)
                                                <span class="badge badge-success badge-pill">Hoạt động</span>
                                            @else
                                                <span class="badge badge-danger badge-pill">Tạm dừng</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->system == 1)
                                                <span class="badge badge-success badge-pill">Trong cùng hệ thống</span>
                                            @endif
                                            @if ($item->system == 2)
                                                <span class="badge badge-danger badge-pill">Hệ thống ngoài</span>
                                            @endif
                                            @if ($item->system == 3)
                                                <span class="badge badge-danger badge-pill">Hệ thống cmsnt</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('api_edit_site', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil-alt"></i> Quản lý
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Table -->
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
@endsection
