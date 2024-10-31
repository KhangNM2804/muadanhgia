@extends("layouts.master")
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{route('post_setting')}}" class="form-material m-t-40">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Chọn giao diện</label>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="example-radio-custom-inline1" name="giaodien" value="" {{ (old('giaodien',getSetting('giaodien')) == '')?"checked":"" }}>
                                <label class="custom-control-label" for="example-radio-custom-inline1">Mặc định</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="example-radio-custom-inline2" name="giaodien" value="vuexy" {{ (old('giaodien',getSetting('giaodien')) == 'vuexy')?"checked":"" }}>
                                <label class="custom-control-label" for="example-radio-custom-inline2">Vuexy</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tên website <span class="help"></span></label>
                            <input type="text" name="website_name" class="form-control form-control-line" value="{{getSetting('website_name')}}" />
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề website</label>
                            <input type="text" name="website_title" class="form-control form-control-line" value="{{getSetting('website_title')}}" />
                        </div>
                        <div class="form-group">
                            <label>Mô tả website</label>
                            <textarea name="website_description" class="form-control" rows="5">{{getSetting('website_description')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-email">Admin Email <span class="help"></span></label>
                            <input type="email" id="admin_email" name="admin_email" class="form-control" value="{{getSetting('admin_email')}}" />
                        </div>
                        <div class="form-group">
                            <label>Số dư tối thiểu để sử dụng tools <span class="help"></span></label>
                            <input type="text" name="min_amount_to_use_tools" class="form-control form-control-line" value="{{getSetting('min_amount_to_use_tools')}}" />
                        </div>
                        <div class="form-group">
                            <label>Ngân hàng <span class="help"></span></label>
                            <input type="text" name="bank_name" class="form-control form-control-line" value="{{getSetting('bank_name')}}" />
                        </div>
                        <div class="form-group">
                            <label>Tài khoản ngân hàng <span class="help"></span></label>
                            <input type="text" name="bank_account" class="form-control form-control-line" value="{{getSetting('bank_account')}}" />
                        </div>
                        <div class="form-group">
                            <label>Tên tài khoản ngân hàng <span class="help"></span></label>
                            <input type="text" name="bank_holder" class="form-control form-control-line" value="{{getSetting('bank_holder')}}" />
                        </div>
                        <div class="form-group">
                            <label>Username VCBDigibank ( Nếu dùng auto ) <span class="help"></span></label>
                            <input type="text" name="bank_user" class="form-control form-control-line" value="{{getSetting('bank_user')}}" />
                        </div>
                        <div class="form-group">
                            <label>Password VCBDigibank ( Nếu dùng auto ) <span class="help"></span></label>
                            <input type="password" name="bank_pass" class="form-control form-control-line" value="{{getSetting('bank_pass')}}" />
                        </div>
                        <div class="form-group">
                            <label>Cú pháp chuyển khoản <span class="help"></span></label>
                            <input type="text" name="bank_syntax" class="form-control form-control-line" value="{{getSetting('bank_syntax')}}" />
                        </div>
                        <div class="form-group">
                            <label>Zalo hỗ trợ <span class="help"></span></label>
                            <input type="text" name="zalo_support" class="form-control form-control-line" value="{{getSetting('zalo_support')}}" />
                        </div>
                        <div class="form-group">
                            <label>Thông báo đầu trang</label>
                            <textarea id="js-ckeditor" name="header_notices">{{getSetting('header_notices')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Token BM ( Sử dụng cho tool check bm )</label>
                            <input type="text" name="token_bm" class="form-control form-control-line" value="{{getSetting('token_bm')}}" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chính sách bảo hành</label>
                                    <textarea id="js-ckeditor2" name="baohanh_accept">{{getSetting('baohanh_accept')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Từ chối bảo hành</label>
                                    <textarea id="js-ckeditor3" name="baohanh_noaccept">{{getSetting('baohanh_noaccept')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mã Google Analytics</label>
                            <textarea name="gg_analytics" class="form-control" rows="5">{{getSetting('gg_analytics')}}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Lưu cấu hình</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            if (jQuery('#js-ckeditor:not(.js-ckeditor-enabled)').length) {
                CKEDITOR.replace('js-ckeditor');
            }
            if (jQuery('#js-ckeditor2:not(.js-ckeditor-enabled)').length) {
                CKEDITOR.replace('js-ckeditor2');
            }
            if (jQuery('#js-ckeditor3:not(.js-ckeditor-enabled)').length) {
                CKEDITOR.replace('js-ckeditor3');
            }

        })

    </script>
@endpush
