@extends('layouts.master')
@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <!-- Table -->
            <div class="block block-themed">
                <div class="block-header bg-gd-dusk">
                    <h3 class="block-title">Danh sách thể loại</h3>

                </div>
                <div class="block-content">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            <p class="mb-0">
                                {{ Session::get('success') }}
                            </p>

                        </div>
                    @endif

                    <a href="{{ route('get_create_cate') }}" class="btn btn-alt-primary">
                        <i class="fa fa-fw fa-check mr-1"></i> Tạo thể loại mới
                    </a>
                    <table class="table table-vcenter mt-2">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#ID</th>
                                <th>Tên thể loại</th>
                                <th>Mô tả</th>
                                <th>Loại</th>
                                <th>Giá bán</th>
                                <th>Hiển thị</th>
                                <th>Thứ tự</th>
                                <th>Ngày tạo</th>
                                <th>Update lần cuối</th>
                                <th>Số lượng đang bán</th>
                                <th>Nguồn hàng</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categorys)
                                @foreach ($categorys as $cate)
                                    <tr>
                                        <th class="text-center" scope="row">{{ $cate->id }}</th>
                                        <td class="font-w600">
                                            {{ $cate->name }}
                                        </td>
                                        <td>
                                            {{ $cate->desc }}
                                        </td>
                                        <td>
                                            {{ $cate->gettype->name }}
                                        </td>
                                        <td>
                                            {{ number_format($cate->price) }}
                                        </td>
                                        <td>
                                            {!! get_display($cate->display) !!}
                                        </td>
                                        <td>
                                            {{ $cate->sort_num }}
                                        </td>
                                        <td>
                                            {{ format_time($cate->created_at, 'd-m-Y H:i:s') }}
                                        </td>
                                        <td>
                                            {{ format_time($cate->updated_at, 'd-m-Y H:i:s') }}
                                        </td>
                                        <td>
                                            @php
                                                $count = $cate->sell()->count();
                                            @endphp
                                            @if ($count > 0)
                                                {{ $count }}
                                                <a href="{{ route('export_data_sell', ['id' => $cate->id]) }}"
                                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Export">
                                                    <i class="fa fa-download"></i> Export data
                                                </a>
                                            @else
                                                {{ $count }}
                                            @endif

                                        </td>
                                        <td>
                                            @if (!$cate->is_api)
                                                <span class="badge badge-pill badge-success">Hệ thống</span>
                                            @else
                                                <a class="badge badge-pill badge-primary"
                                                    href="{{ route('api_edit_site', ['id' => $cate->connect_api_id]) }}">API</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('get_edit_cate', ['id' => $cate->id]) }}"
                                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil-alt"></i>
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
