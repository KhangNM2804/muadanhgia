@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="example-textarea-input">Danh sách Business ID</label>
                        <textarea class="form-control" id="list-id" name="example-textarea-input" rows="10" placeholder="Nhập Business ID mỗi dòng"></textarea>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-hero-lg btn-rounded btn-primary mr-1 mb-3" id="btn-submit">
                            <i data-feather='share-2'></i>
                            Kiểm Tra</button>
                    </div>

                    <div class="text-center mb-3">
                        <span class=" badge  badge-info">Tổng: <span id="check-count-total">0</span></span>
                        <span class=" badge  badge-success">Limit $350: <span id="check-count-350">0</span></span>
                        <span class=" badge  badge-warning">Limit $50: <span id="check-count-50">0</span></span>
                        <span class=" badge  badge-success">Tổng BM Live: <span id="check-count-live">0</span></span>
                        <span class=" badge  badge-danger">Tổng BM Lỗi: <span id="check-count-error">0</span></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                <label for="example-textarea-input" class="text-success">Danh sách BM 350$</label>
                                <textarea class="form-control" id="list-bm-350" name="example-textarea-input" rows="8" readonly=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                <label for="example-textarea-input" class="text-warning">Danh sách BM 50$</label>
                                <textarea class="form-control" id="list-bm-50" name="example-textarea-input" rows="8" readonly=""></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                <label for="example-textarea-input" class="text-success">Danh sách BM Live</label>
                                <textarea class="form-control" id="list-bm-red" name="example-textarea-input" rows="8" readonly=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                <label for="example-textarea-input" class="text-danger"><del>Danh sách Die</del></label>
                                <textarea class="form-control" id="list-bm-error" name="example-textarea-input" rows="8" readonly=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection