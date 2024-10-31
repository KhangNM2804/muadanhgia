@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-gd-dusk">
                <h3 class="block-title">Thêm mới tài khoản momo</h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <form method="POST" action="" class="form-material m-t-40">
                    @csrf
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-alt" name="username" id="username" value="{{ $phone ?? ""}}" autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-dark" id="btn_get_otp">Lấy OTP</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mã OTP</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-alt" name="otp" placeholder="" id="otp" autocomplete="off" disabled>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-dark" id="btn_check_otp" disabled>Kiểm tra</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email">Mật khẩu đăng nhập</label>
                        <input type="password" name="password" class="form-control" value="" id="password" disabled/>
                    </div>
                    
                    <button type="button" class="btn btn-primary waves-effect waves-light m-r-10 mb-2" id="btn_login" disabled>Login</button>
                    <a href="{{route('momo.index')}}" class="btn btn-primary waves-effect waves-light m-r-10 mb-2">Quay lại danh sách</a>
                </form>
            </div>
        </div>

    </div>

</main>
<!-- END Main Container -->
@endsection
@push('custom-scripts')
    <script src="{{asset('assets/js/momo.js?v='.time())}}"></script>
@endpush
