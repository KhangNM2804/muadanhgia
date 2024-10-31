@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-4 offset-md-2 offset-xl-3 col-form-label col-form-label-lg text-right" for="secret">Secret </label>
                        <div class="col-md-4 col-6">
                            <input type="text" class="form-control form-control-lg font-weight-bold" id="secret" name="secret" placeholder="Nhập mã bảo mật của bạn vào đây" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-4 offset-md-2 offset-xl-3 col-form-label col-form-label-lg text-right" for="code">Code <span id="time-remaining" class="">26s</span></label>
                        <div class="col-md-4 col-6">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control form-control-lg form-control-alt font-weight-bold" id="code" name="code" placeholder="Code" readonly="readonly" value="">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-4 offset-md-2 offset-xl-3 col-form-label col-form-label-lg text-right"></label>
                        <div class="col-md-4 col-6">
                            <img id="qr-code" src="" style="display:none" alt="2FA QR Code">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('custom-scripts')
    <script src="{{asset('assets/2fatool/buffer.js')}}"></script>
    <script src="{{asset('assets/2fatool/index.js')}}"></script>
    <script src="{{asset('assets/2fatool/2fa_tool.js')}}"></script>
@endpush