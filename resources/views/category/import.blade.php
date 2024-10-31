@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-themed">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">Import nguyên liệu bán</h3>
                        <div class="block-options"></div>
                    </div>
                    <div class="block-content">
                        <div class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">Thông số hệ thống. Nếu trong quá trình import bị lỗi do các thông số dưới thì vui lòng liên hệ nhà cung cấp hosting để tăng limit</p>
                                <p class="mb-0">max_execution_time: {{$max_execution_time}}s</p>
                                <p class="mb-0">post_max_size: {{$post_max_size}}</p>
                            </div>
                        </div>
                        <div class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">Lưu ý chọn loại trước khi import</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="js-select2 form-control" id="select_type" name="example-select2" style="width: 100%;" data-placeholder="Chọn loại">
                                <option></option>
                                @if (!empty($categorys))
                                    @foreach ($categorys as $item)
                                        <option value="{{$item->id}}">{{$item->name}} - {{number_format($item->price)}}đ</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example-textarea-input">Nhập danh sách via/ clone/ bm</label>
                            <textarea class="form-control" id="list-id" name="example-textarea-input" rows="10" placeholder=""></textarea>
                        </div>
                        
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-hero-lg btn-rounded btn-hero-primary mr-1 mb-3" id="btn_import">
                                <i class="fa fa-rocket mr-1"></i>
                                Import
                            </button>
                        </div>
    
                        <div class="text-center mb-3">
                            <span class="nav-main-link-badge badge badge-pill badge-info p-3 font-size-h5">Tổng: <span id="check-count-total">0</span></span>
                            <span class="nav-main-link-badge badge badge-pill badge-success p-3 font-size-h5">Thêm mới: <span id="insert">0</span></span>
                            <span class="nav-main-link-badge badge badge-pill badge-warning p-3 font-size-h5">Update: <span id="update">0</span></span>
                            <span class="nav-main-link-badge badge badge-pill badge-danger p-3 font-size-h5">Lỗi: <span id="die">0</span></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="example-textarea-input" class="text-success">Danh sách Thêm mới</label>
                                    <textarea class="form-control" id="list-insert" name="example-textarea-input" rows="8" readonly=""></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <label for="example-textarea-input" class="text-warning">Danh sách Update</label>
                                    <textarea class="form-control" id="list-update" name="example-textarea-input" rows="8" readonly=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block block-themed">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">Lịch sử up hàng</h3>
                        <div class="block-options"></div>
                    </div>
                    <div class="block-content">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Name</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($histories))
                                        @foreach ($histories as $item)
                                        <tr>
                                            <td>{{ format_time($item->created_at,"d/m/Y H:i:s")}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{ $item->amount }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                    Chưa có giao dịch nạp tiền!
                                    @endif
                                </tbody>
                            </table>
                            {{ $histories->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
@endsection