@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header bg-gd-dusk">
                    <h3 class="block-title">Thiết lập</h3>
                    <div class="block-options"></div>
                </div>
                <div class="block-content">
                    <form method="POST" action="{{ route('post_setting') }}" class="form-material m-t-40">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Chọn giao diện</label>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="example-radio-custom-inline1"
                                    name="giaodien" value=""
                                    {{ old('giaodien', getSetting('giaodien')) == '' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="example-radio-custom-inline1">Mặc định</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Chọn kiểu hiển thị sản phẩm</label>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_display_product1"
                                    name="display_product" value=""
                                    {{ old('display_product', getSetting('display_product')) == '' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_display_product1">Mặc định</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_display_product2"
                                    name="display_product" value="list"
                                    {{ old('display_product', getSetting('display_product')) == 'list' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_display_product2">Dạng list</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_display_product3"
                                    name="display_product" value="iconbox"
                                    {{ old('display_product', getSetting('display_product')) == 'iconbox' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_display_product3">Dạng icon box</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Chọn kiểu hiển thị thông báo</label>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_display_noti1"
                                    name="display_noti" value=""
                                    {{ old('display_noti', getSetting('display_noti')) == '' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_display_noti1">Hiển thị đầu trang
                                    chủ</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_display_noti2"
                                    name="display_noti" value="popup"
                                    {{ old('display_noti', getSetting('display_noti')) == 'popup' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_display_noti2">Popup</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Ẩn / Hiện lịch sử nạp, mua</label>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_list_transaction_flg1"
                                    name="list_transaction_flg" value=""
                                    {{ old('list_transaction_flg', getSetting('list_transaction_flg')) == '' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_list_transaction_flg1">Hiển thị</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="setting_list_transaction_flg2"
                                    name="list_transaction_flg" value="off"
                                    {{ old('list_transaction_flg', getSetting('list_transaction_flg')) == 'off' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="setting_list_transaction_flg2">Ẩn</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Bật / Tắt recaptcha Google</label>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="flag_recaptcha1"
                                    name="flag_recaptcha" value="on"
                                    {{ old('flag_recaptcha', getSetting('flag_recaptcha')) == 'on' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="flag_recaptcha1">Hiển thị</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                <input type="radio" class="custom-control-input" id="flag_recaptcha2"
                                    name="flag_recaptcha" value="off"
                                    {{ old('flag_recaptcha', getSetting('flag_recaptcha')) == 'off' || old('flag_recaptcha', getSetting('flag_recaptcha')) == '' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="flag_recaptcha2">Ẩn</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Giới hạn account đăng nhập trên mỗi IP<span class="help"></span></label>
                            <input type="number" name="limit_login_ip" class="form-control form-control-line"
                                value="{{ getSetting('limit_login_ip') }}" placeholder="Mặc định 0: là không giới hạn" />
                        </div>
                        <div class="form-group">
                            <label>Thời gian tắt thông báo<span class="help"></span></label>
                            <input type="number" name="off_popup_hour" class="form-control form-control-line"
                                value="{{ getSetting('off_popup_hour') }}" placeholder="Mặc định 3 giờ" />
                        </div>
                        <div class="form-group">
                            <label>Favicon <span class="help"></span></label>
                            <input type="text" name="favicon" class="form-control form-control-line"
                                value="{{ getSetting('favicon') }}" />
                            <i>Upload ảnh lên <a href="https://imgur.com/upload"
                                    target="_blank">https://imgur.com/upload</a> sau đó dán vào đây</i>
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện khi share link <span class="help"></span></label>
                            <input type="text" name="image_share" class="form-control form-control-line"
                                value="{{ getSetting('image_share') }}" />
                            <i>Upload ảnh lên <a href="https://imgur.com/upload"
                                    target="_blank">https://imgur.com/upload</a> sau đó dán vào đây</i>
                        </div>
                        <div class="form-group">
                            <label>Logo <span class="help"></span></label>
                            <input type="text" name="web_logo" class="form-control form-control-line"
                                value="{{ getSetting('web_logo') }}" />
                            <i>Upload ảnh lên <a href="https://imgur.com/upload"
                                    target="_blank">https://imgur.com/upload</a> sau đó dán vào đây</i>
                        </div>
                        <div class="form-group">
                            <label>Tên website <span class="help"></span></label>
                            <input type="text" name="website_name" class="form-control form-control-line"
                                value="{{ getSetting('website_name') }}" />
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề website</label>
                            <input type="text" name="website_title" class="form-control form-control-line"
                                value="{{ getSetting('website_title') }}" />
                        </div>
                        <div class="form-group">
                            <label>Mô tả website</label>
                            <textarea name="website_description" class="form-control" rows="5">{{ getSetting('website_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="example-email">Admin Email <span class="help"></span></label>
                            <input type="email" id="admin_email" name="admin_email" class="form-control"
                                value="{{ getSetting('admin_email') }}" />
                        </div>
                        <div class="form-group">
                            <label>Hoa hồng người giới thiệu nhận được (%) <span class="help"></span></label>
                            <input type="text" name="aff_rate" class="form-control form-control-line"
                                value="{{ getSetting('aff_rate') }}" placeholder="Mặc định: 15" />
                        </div>
                        <div class="form-group">
                            <label>Khuyến mãi nạp tiền (%) <span class="help"></span></label>
                            <input type="number" name="sale_rate" class="form-control form-control-line"
                                value="{{ getSetting('sale_rate') }}" placeholder="Mặc định 0" />
                        </div>
                        <div class="form-group">
                            <label>Min nạp để được hưởng khuyến mãi<span class="help"></span></label>
                            <input type="number" name="min_amount_sale_rate" class="form-control form-control-line"
                                value="{{ getSetting('min_amount_sale_rate') }}" placeholder="Mặc định 0" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <hr>
                                <label class="text-danger">Cấu hình API VCB </label>
                                <div class="alert alert-danger" role="alert">
                                    <h5>Lưu ý đối với Vietcombank</h4>
                                        <p>Bước 1: Mở app Vietcombank tìm mục Cài đặt -> Cài đặt chung -> Quản lý đăng nhập
                                            kênh<br>Bước 2:</p>
                                        <ul>
                                            <li>Bật "Cài đặt đăng nhập VCB Digibank trên Web"</li>
                                            <li>Tắt "Xác thực đăng nhập VCB Digibank trên Web"</li>
                                        </ul>
                                </div>
                                @if ($result_vcb && $result_vcb->msg)
                                    <div class="alert alert-primary" role="alert">
                                        {!! $result_vcb->msg !!}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="d-block">Bật/tắt auto VCB</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffvcb1"
                                            name="flag_auto_vcb" value=""
                                            {{ old('flag_auto_vcb', getSetting('flag_auto_vcb')) == '' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffvcb1">Tắt</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffvcb2"
                                            name="flag_auto_vcb" value="on"
                                            {{ old('flag_auto_vcb', getSetting('flag_auto_vcb')) == 'on' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffvcb2">Bật</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Số Tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_account" class="form-control form-control-line"
                                        value="{{ getSetting('bank_account') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Tên tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_holder" class="form-control form-control-line"
                                        value="{{ getSetting('bank_holder') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Username VCBDigibank<span class="help"></span></label>
                                    <input type="text" name="bank_user" class="form-control form-control-line"
                                        value="{{ getSetting('bank_user') }}" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Password VCBDigibank<span class="help"></span></label>
                                    <input type="password" name="bank_pass" class="form-control form-control-line"
                                        value="{{ getSetting('bank_pass') }}" autocomplete="off" />
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <hr>
                                <label class="text-danger">Cấu hình API MB Bank</label>
                                @if ($result_mb && $result_mb->msg)
                                    <div class="alert alert-primary" role="alert">
                                        {!! $result_mb->msg !!}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="d-block">Bật/tắt auto MB</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffmb1"
                                            name="flag_auto_mb" value=""
                                            {{ old('flag_auto_mb', getSetting('flag_auto_mb')) == '' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffmb1">Tắt</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffmb2"
                                            name="flag_auto_mb" value="on"
                                            {{ old('flag_auto_mb', getSetting('flag_auto_mb')) == 'on' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffmb2">Bật</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_name_mb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_name_mb') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Số Tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_account_mb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_account_mb') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Tên tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_holder_mb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_holder_mb') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Username đăng nhập app MBBANK</label>
                                    <input type="text" name="bank_user_mb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_user_mb') }}" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Password đăng nhập app MBBANK</label>
                                    <input type="password" name="bank_pass_mb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_pass_mb') }}" autocomplete="off" />
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <hr>
                                <label class="text-danger">Cấu hình API ACB</label>
                                @if ($result_acb && $result_acb->msg)
                                    <div class="alert alert-primary" role="alert">
                                        {!! $result_acb->msg !!}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="d-block">Bật/tắt auto ACB</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffacb1"
                                            name="flag_auto_acb" value=""
                                            {{ old('flag_auto_acb', getSetting('flag_auto_acb')) == '' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffacb1">Tắt</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffacb2"
                                            name="flag_auto_acb" value="on"
                                            {{ old('flag_auto_acb', getSetting('flag_auto_acb')) == 'on' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffacb2">Bật</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Số Tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_account_acb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_account_acb') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Tên tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_holder_acb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_holder_acb') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Username ACB APP<span class="help"></span></label>
                                    <input type="text" name="bank_user_acb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_user_acb') }}" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Password ACB APP<span class="help"></span></label>
                                    <input type="password" name="bank_pass_acb" class="form-control form-control-line"
                                        value="{{ getSetting('bank_pass_acb') }}" autocomplete="off" />
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <hr>
                                <label class="text-danger">Cấu hình API Vietinbank</label>
                                @if ($result_vtb && $result_vtb->msg)
                                    <div class="alert alert-primary" role="alert">
                                        {!! $result_vtb->msg !!}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="d-block">Bật/tắt auto Vietinbank</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffvtb1"
                                            name="flag_auto_vietinbank" value=""
                                            {{ old('flag_auto_vietinbank', getSetting('flag_auto_vietinbank')) == '' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffvtb1">Tắt</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                        <input type="radio" class="custom-control-input" id="onoffvtb2"
                                            name="flag_auto_vietinbank" value="on"
                                            {{ old('flag_auto_vietinbank', getSetting('flag_auto_vietinbank')) == 'on' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="onoffvtb2">Bật</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Số Tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_account_vietinbank"
                                        class="form-control form-control-line"
                                        value="{{ getSetting('bank_account_vietinbank') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Tên tài khoản ngân hàng <span class="help"></span></label>
                                    <input type="text" name="bank_holder_vietinbank"
                                        class="form-control form-control-line"
                                        value="{{ getSetting('bank_holder_vietinbank') }}" />
                                </div>
                                <div class="form-group">
                                    <label>Username Vietinbank APP<span class="help"></span></label>
                                    <input type="text" name="bank_user_vietinbank"
                                        class="form-control form-control-line"
                                        value="{{ getSetting('bank_user_vietinbank') }}" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <label>Password Vietinbank APP<span class="help"></span></label>
                                    <input type="password" name="bank_pass_vietinbank"
                                        class="form-control form-control-line"
                                        value="{{ getSetting('bank_pass_vietinbank') }}" autocomplete="off" />
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Cú pháp chuyển khoản <span class="help"></span></label>
                            <input type="text" name="bank_syntax" class="form-control form-control-line"
                                value="{{ getSetting('bank_syntax') }}" />
                        </div>
                        <div class="form-group">
                            <label>Zalo hỗ trợ <span class="help"></span></label>
                            <input type="text" name="zalo_support" class="form-control form-control-line"
                                value="{{ getSetting('zalo_support') }}" />
                        </div>
                        <div class="form-group">
                            <label>Thông báo chạy chữ <span class="help"></span></label>
                            <input type="text" name="header_noti_marquee" class="form-control form-control-line"
                                value="{{ getSetting('header_noti_marquee') }}" />
                        </div>
                        <div class="form-group">
                            <label>Thông báo đầu trang</label>
                            <textarea id="js-ckeditor" name="header_notices">{{ getSetting('header_notices') }}</textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label>Token BM ( Sử dụng cho tool check bm )</label>
                            <input type="text" name="token_bm" class="form-control form-control-line"
                                value="{{ getSetting('token_bm') }}" />
                        </div> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Chính sách bảo hành</label>
                                    <textarea id="js-ckeditor2" name="baohanh_accept">{{ getSetting('baohanh_accept') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Từ chối bảo hành</label>
                                    <textarea id="js-ckeditor3" name="baohanh_noaccept">{{ getSetting('baohanh_noaccept') }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label>Mã Google Analytics</label>
                            <textarea name="gg_analytics" class="form-control" rows="5">{{ getSetting('gg_analytics') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Paypal Client ID</label>
                            <input type="text" class="form-control" name="paypal_client_id"
                                value="{{ getSetting('paypal_client_id') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Paypal Secret</label>
                            <input type="text" class="form-control" name="paypal_secret"
                                value="{{ getSetting('paypal_secret') }}" autocomplete="off">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Nowpayment API KEY</label>
                            <input type="text" class="form-control" name="nowpayment_apikey"
                                value="{{ getSetting('nowpayment_apikey') }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Nowpayment IPN</label>
                            <input type="text" class="form-control" name="nowpayment_ipn"
                                value="{{ getSetting('nowpayment_ipn') }}" autocomplete="off">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Perfect Money Account</label>
                            <input type="text" class="form-control" name="perfectmoney_id"
                                value="{{ getSetting('perfectmoney_id') }}" autocomplete="off"
                                placeholder="example: U12345678">
                        </div>
                        <div class="form-group">
                            <label>Perfect Money Alternate PassPhrase</label>
                            <input type="text" class="form-control" name="perfectmoney_pass"
                                value="{{ getSetting('perfectmoney_pass') }}" autocomplete="off"
                                placeholder="Alternate PassPhrase can be found and set under Settings section in your PM account">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Paypal Tỉ giá ( mặc định : 1 USD = 24.000 VNĐ )</label>
                            <input type="number" class="form-control" name="paypal_rate"
                                value="{{ getSetting('paypal_rate') }}" autocomplete="off" placeholder="24000">
                        </div> --}}
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Lưu cấu
                            hình</button>
                    </form>
                </div>
            </div>

        </div>

    </main>
    <!-- END Main Container -->
@endsection
