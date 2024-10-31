@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">2FA TOOL</h3>
                        <div class="block-options">
                        </div>
                    </div>
                    <div class="block-content">
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
    </div>
</main>

<!-- END Main Container -->
@endsection
@push('custom-scripts')
    <script src="{{asset('assets/2fatool/buffer.js')}}"></script>
    <script src="{{asset('assets/2fatool/index.js')}}"></script>
    <script src="{{asset('assets/2fatool/2fa_tool.js')}}"></script>
@endpush