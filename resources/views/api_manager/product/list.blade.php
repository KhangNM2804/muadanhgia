@extends('layouts.master')
@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <!-- Table -->
            <div class="block block-themed">
                <div class="block-header bg-gd-dusk">
                    <h3 class="block-title">Danh sách sản phẩm: {{ $api->domain }}</h3>

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
                                <th>Tên thể loại</th>
                                <th>Giá bán</th>
                                <th>Đang bán</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products)
                                @foreach ($products as $cate)
                                    <tr>
                                        <th class="text-center" scope="row">{{ $cate->id }}</th>
                                        <td>
                                            <span class="font-w600">{{ $cate->name }}</span>
                                            <ul>
                                                <li>{{ $cate->desc }}</li>
                                                <li>Loại: {{ $cate->gettype->name }}</li>
                                                <li>Hiển thị: {!! get_display($cate->display) !!}</li>
                                                <li>Thứ tự: {{ $cate->sort_num }}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    Giá gốc
                                                </span>
                                                <input type="number" class="form-control" value="{{ $cate->origin_price }}"
                                                    readonly disabled>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    Giá bán
                                                </span>
                                                <input type="number" class="form-control inputPriceProduct"
                                                    value="{{ $cate->price }}"
                                                    name="product_price[price][{{ $cate->id }}]"
                                                    data-product_id="{{ $cate->id }}"
                                                    data-connect_api_id="{{ $api->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            {{ $cate->quantity_remain }}
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
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $(".inputPriceProduct").focusout(function() {
                var _this = $(this);
                var api_id = _this.data('connect_api_id')
                var product_id = _this.data('product_id')
                var price = _this.val()
                _this.attr('disabled', true)
                Dashmix.layout('header_loader_on');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax_api_manager_product_update_price') }}',
                    data: {
                        api_id: api_id,
                        product_id: product_id,
                        price: price
                    },
                    success: function(res) {
                        Dashmix.layout('header_loader_off');
                        _this.attr('disabled', false)
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            })
        });
    </script>
@endpush
