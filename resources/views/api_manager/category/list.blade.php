@extends('layouts.master')
@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <!-- Table -->
            <div class="block block-themed">
                <div class="block-header bg-gd-dusk">
                    <h3 class="block-title">Danh mục: {{ $api->domain }}</h3>

                </div>
                <div class="block-content">
                    <div>
                        <a href="{{ route('api_edit_site', ['id' => $api->id]) }}" class="btn btn-sm btn-danger">
                            <i class="si si-action-undo"></i> Quay lại quản lý api
                        </a>
                    </div>
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            <p class="mb-0">
                                {{ Session::get('success') }}
                            </p>

                        </div>
                    @endif
                    <table class="table table-vcenter mt-2">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#ID</th>
                                <th>Tên danh mục</th>
                                <th>Hiển thị</th>
                                <th>Thứ tự</th>
                                <th>Ngày tạo</th>
                                <th>Update lần cuối</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categories)
                                @foreach ($categories as $type)
                                    <tr>
                                        <th class="text-center" scope="row">{{ $type->id }}</th>
                                        <td class="font-w600">
                                            {{ $type->name }}
                                        </td>
                                        <td>
                                            {!! get_display($type->display) !!}
                                        </td>
                                        <td>
                                            {{ $type->sort_num }}
                                        </td>
                                        <td>
                                            {{ format_time($type->created_at, 'd-m-Y H:i:s') }}
                                        </td>
                                        <td>
                                            {{ format_time($type->updated_at, 'd-m-Y H:i:s') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('get_edit_type', ['id' => $type->id]) }}"
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
