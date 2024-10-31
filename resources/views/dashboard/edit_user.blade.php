@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">Edit user</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-settings"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-lg-8">
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        <p class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                {{$error}} <br>
                                            @endforeach
                                        </p>
                                        
                                    </div>
                                @endif
                                @if (Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        <p class="mb-0">
                                            {{Session::get('success')}}
                                        </p>
                                        
                                    </div>
                                @endif
                                <form class="mb-5" action="{{route('post_edit_user', ['id' => $user->id])}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="email" placeholder="Nhập email" value="{{old('email',$user->email)}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Quyền</label>
                                        <div class="col-sm-8">
                                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                                <input type="radio" class="custom-control-input" id="example-radio-custom-inline1" name="role" value="0" {{ (old('role',$user->role) == 0)?"checked":"" }}>
                                                <label class="custom-control-label" for="example-radio-custom-inline1">Member</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                                <input type="radio" class="custom-control-input" id="example-radio-custom-inline3" name="role" value="2" {{ (old('role',$user->role) == 2)?"checked":"" }}>
                                                <label class="custom-control-label" for="example-radio-custom-inline3">Nhân viên ( chỉ xem được lịch sử mua hàng toàn hệ thống )</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                                <input type="radio" class="custom-control-input" id="example-radio-custom-inline2" name="role" value="1" {{ (old('role',$user->role) == 1)?"checked":"" }}>
                                                <label class="custom-control-label" for="example-radio-custom-inline2">Admin</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Chiết khấu khi mua</label>
                                        <div class="input-group col-sm-8">
                                            <input type="number" class="form-control" name="chietkhau" placeholder="" value="{{old('chietkhau',$user->chietkhau)}}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary">
                                                    %
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4">Cấp quyền giới thiệu thành viên (aff) </label>
                                        <div class="col-sm-8">
                                            <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                                <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg4" name="aff_flg" value="1" {{ (old('aff_flg',$user->aff_flg) == 1)?"checked":"" }}>
                                                <label class="custom-control-label" for="example-sw-custom-success-lg4"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Mật khẩu mới</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" name="password" placeholder="Tạo mật khẩu" value="{{old('password','')}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Xác nhận mật khẩu</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" name="password_confirm" placeholder="Xác nhận mật khẩu" value="{{old('password_confirm','')}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                                            <button type="reset" class="btn btn-warning">
                                                <i class="fa fa-repeat"></i> Reset
                                            </button>
                                        </div>
                                        
                                    </div>
                                </form>
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