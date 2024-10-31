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
                        <h2 class="content-heading">Thông tin tài khoản</h2>
                        <div class="row">
                            <div class="offset-2 col-lg-8">
                                <div class="form-group row">
                                    <label class="col-sm-4">Ngày tạo:</label>
                                    <div class="col-sm-8">
                                        <span>{{ format_time($user->created_at,"d/m/Y H:i:s") }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Tài khoản:</label>
                                    <div class="col-sm-8">
                                        <span>{{$user->username}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Email:</label>
                                    <div class="col-sm-8">
                                        <span>{{$user->email}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Số dư:</label>
                                    <div class="col-sm-8">
                                        <span><strong>{{number_format($user->coin)}}</strong> VNĐ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <h2 class="content-heading">Đổi mật khẩu</h2>
                        <div class="row">
                            <div class="offset-2 col-lg-8">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            @foreach ($errors->all() as $error)
                                                {{$error}} <br>
                                            @endforeach
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        <p class="mb-0">
                                            {{Session::get('success')}}
                                        </p>
                                        
                                    </div>
                                @endif
                                <form class="mb-5" action="{{route('doimatkhau')}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Mật khẩu hiện tại</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" name="current_password" placeholder="Mật khẩu"  value="{{old('current_password','')}}"/>
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
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" value="{{old('password_confirmation','')}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">Lưu lại</button>
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
    <!-- END: Content-->
@endsection
