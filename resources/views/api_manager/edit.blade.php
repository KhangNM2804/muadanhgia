@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-themed">
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title">Edit website đấu api</h3>
                        </div>


                        <form action="{{ route('post_api_edit_site', ['id' => $api->id]) }}" method="post">
                            @csrf
                            <div class="block-content">
                                <div class="mb-2">
                                    <button type="button"
                                        class="btn btn-sm 
                                    btn-success">
                                        <i class="si si-wallet"></i> Số dư: {{ number_format($api->balance) }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary" id="btnReSyncProduct"
                                        data-api_id="{{ $api->id }}">
                                        <i class="si si-reload"></i> Đồng bộ danh mục & sản phẩm
                                    </button>
                                    <a href="{{ route('get_api_manager_category', ['id' => $api->id]) }}"
                                        class="btn btn-sm btn-danger">
                                        <i class="si si-list"></i> Quản lý danh mục
                                    </a>
                                    <a href="{{ route('get_api_manager_product', ['id' => $api->id]) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="si si-handbag"></i> Quản lý sản phẩm
                                    </a>
                                    <a href="{{ route('get_api_manager_orders', ['id' => $api->id]) }}"
                                        class="btn btn-sm btn-danger">
                                        <i class="si si-basket-loaded"></i> Danh sách đơn hàng
                                    </a>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissable" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h3 class="alert-heading font-size-h4 my-2">Có lỗi</h3>
                                        <p class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }} <br>
                                            @endforeach
                                        </p>
                                    </div>
                                @endif
                                @if (Session::has('fail'))
                                    <div class="alert alert-danger" role="alert">
                                        <p class="mb-0">
                                            {{ Session::get('fail') }}
                                        </p>

                                    </div>
                                @endif

                                <div class="row py-sm-3 py-md-5">

                                    <div class="col-sm-10 col-md-8">
                                        <div class="form-group">
                                            <select class="form-control" name="system" disabled>
                                                @foreach ($system_api as $key => $item)
                                                    <option value="{{ $key }}"
                                                        @if (old('system', $api->system) == $key) selected @endif>
                                                        {{ $item }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="block-form-username">Domain</label>
                                            <input type="text" class="form-control" name="domain"
                                                placeholder="https://demo.com" value="{{ old('domain', $api->domain) }}">
                                        </div>
                                        <div
                                            class="form-group {{ old('system', $api->system) != 3 ? 'd-block' : 'd-none' }}">
                                            <label for="block-form-password">API_KEY</label>
                                            <input type="text" class="form-control" name="api_key" placeholder=""
                                                value="{{ old('api_key', $api->api_key) }}">
                                            Vui lòng bảo mật thông tin API_KEY, nếu để lộ thông tin ra ngoài -> bên phát
                                            triển mã nguồn không chịu trách nhiệm
                                        </div>
                                        <div id="system_cmsnt"
                                            class="{{ old('system', $api->system) == 3 ? 'd-block' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="block-form-username">Username</label>
                                                <input type="text" class="form-control" name="username" placeholder="abc"
                                                    value="{{ old('username', $api->username) }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="block-form-username">Password</label>
                                                <input type="text" class="form-control" name="password"
                                                    placeholder="xxxx" value="{{ old('password', $api->password) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="block-form-password">Tự động cập nhật giá</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="auto_price" placeholder=""
                                                    value="{{ old('auto_price', $api->auto_price) }}">
                                            </div>
                                            Hệ thống sẽ tự động tăng giá sản phẩm API lên 10%, để 0 nếu muốn tắt chức năng
                                            cập nhật giá tự động.
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Tự động cập nhật tên sản phẩm</label>
                                            <div
                                                class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="example-sw-custom-success-lg2" name="auto_change_name"
                                                    value="1"
                                                    {{ old('auto_change_name', $api->auto_change_name) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="example-sw-custom-success-lg2"></label>
                                            </div>
                                            Hệ thống sẽ tự động cập nhật tên sản phẩm và mô tả sản phẩm
                                            theo API nguồn. Nếu bạn muốn đổi tên sản phẩm, vui lòng tắt chức năng này
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Active</label>
                                            <div
                                                class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="example-sw-custom-success-lg3" name="active" value="1"
                                                    {{ old('active', $api->active) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="example-sw-custom-success-lg3"></label>
                                            </div>
                                            Nếu tắt, hệ thống sẽ tự động ẩn các sản phẩm liên quan đến API này
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fa fa-check"></i> Lưu thay đổi
                                </button>
                                <button type="reset" class="btn btn-sm btn-warning">
                                    <i class="fa fa-repeat"></i> Reset
                                </button>
                                <a href="{{ route('list_api_connect') }}" class="btn btn-sm btn-alt-primary">
                                    Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $("#btnReSyncProduct").click(function() {
                var _this = $(this);
                var api_id = _this.data('api_id')
                _this.attr('disabled', true)
                Dashmix.layout('header_loader_on');
                $.ajax({
                    type: 'GET',
                    url: '/api-management/re_sync/' + api_id,
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
