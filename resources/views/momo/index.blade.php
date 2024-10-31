@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">

    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Danh sách tài khoản momo</h3>
                
            </div>
            <div class="block-content">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#ID</th>
                            <th>Số điện thoại</th>
                            <th>Status</th>
                            <th>Số dư</th>
                            <th>Set chạy auto</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($momos)
                            @foreach ($momos as $momo)
                            <tr>
                                <th class="text-center" scope="row">{{$momo->id}}</th>
                                <td class="font-w600">
                                    {{$momo->username}}
                                </td>
                                <td>
                                    @if($momo->status == 1)
                                    <span class="badge badge-success  badge-pill">Hoạt động</span>
                                    @else
                                    <span class="badge badge-danger  badge-pill">Chờ login</span>
                                    @endif
                                </td>
                                <td>
                                    {{number_format($momo->balance)}}
                                </td>
                                <td>
                                    <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                        <input type="checkbox" class="custom-control-input set-auto" id="example-sw-custom-success-lg{{$momo->id}}" data-idmomo="{{$momo->id}}" value="1" {{ ($momo->flag_auto == 1)?"checked":""}}>
                                        <label class="custom-control-label" for="example-sw-custom-success-lg{{$momo->id}}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" id="btn_relogin" data-username="{{$momo->username}}">
                                            reLogin
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{route('momo.add', ['phone' => $momo->username])}}" class="btn btn-sm btn-danger" data-toggle="tooltip">
                                            get OTP
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <a href="{{route('momo.add')}}" class="btn btn-success waves-effect waves-light m-r-10 mb-2" >Thêm tài khoản mới</a>
                <a href="{{route('momo.chuyentien')}}" class="btn btn-primary waves-effect waves-light m-r-10 mb-2" >Chuyển tiền</a>
                <br>
                <span class="badge badge-pill badge-danger">Sau khi thêm tài khoản auto Momo vui lòng config cronjob đến endpoint sau để chạy auto: wget -q -O - {{route('autoMomo')}} >/dev/null 2>&1</span>
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
@push('custom-scripts')
    <script src="{{asset('assets/js/momo.js?v='.time())}}"></script>
@endpush