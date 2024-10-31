@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <div class="block-content">
                        <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                            <div class="alert-body">
                                <i data-feather="info" class="mr-50 align-middle"></i>
                                <span>Lưu ý chọn loại trước khi import</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="js-select2 form-control" id="select_type" name="example-select2" style="width: 100%;" data-placeholder="Chọn loại">
                                <option value="">Chọn thể loại</option>
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
                            <button type="button" class="btn btn-hero-lg btn-rounded btn-primary mr-1 mb-3" id="btn_import">
                                <i data-feather='upload-cloud'></i>
                                Import
                            </button>
                        </div>
    
                        <div class="text-center mb-3">
                            <span class="nav-main-link-badge badge badge-pill badge-info font-size-h5">Tổng: <span id="check-count-total">0</span></span>
                            <span class="nav-main-link-badge badge badge-pill badge-success font-size-h5">Thành công: <span id="insert">0</span></span>
                            <span class="nav-main-link-badge badge badge-pill badge-warning font-size-h5">Update: <span id="update">0</span></span>
                            <span class="nav-main-link-badge badge badge-pill badge-danger font-size-h5">Lỗi: <span id="die">0</span></span>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
