@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-gd-dusk">
                <h3 class="block-title">Chuyển tiền</h3>
                <div class="block-options"></div>
            </div>
            <div class="block-content">
                <form method="POST" action="" class="form-material m-t-40">
                    @csrf
                    <div class="form-group">
                        <label for="example-select">Chọn tài khoản nguồn:</label>
                        <select class="form-control" id="id_from">
                            <option value="">Please select</option>
                            @if ($momos)
                                @foreach ($momos as $momo)
                                    <option value="{{$momo->id}}">{{$momo->username}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại người nhận</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-alt" name="sdt_to" placeholder="" id="sdt_to" autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-dark" id="btn_info">Kiểm tra</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email">Tên người nhận</label>
                        <input type="text" name="amount" class="form-control" value="" id="name_to" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="example-email">Số tiền</label>
                        <input type="number" name="amount" class="form-control" value="" id="amount" disabled/>
                    </div>
                    <div class="form-group">
                        <label for="example-email">Nội dung (nếu có)</label>
                        <input type="text" name="memo" class="form-control" value="" id="memo" disabled/>
                    </div>
                    
                    <button type="button" class="btn btn-success waves-effect waves-light m-r-10 mb-2" id="btn_pay" disabled>Chuyển tiền</button>
                    <button type="reset" class="btn btn-warning waves-effect waves-light m-r-10 mb-2">
                            <i class="fa fa-repeat"></i> Reset
                        </button>
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
