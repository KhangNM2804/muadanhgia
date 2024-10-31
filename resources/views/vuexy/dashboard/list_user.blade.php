@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    Tìm kiếm
                    <form class="form-inline mb-4" action="" method="GET">
                        <label class="sr-only" for="example-if-email">Tài khoản</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email" name="username" placeholder="theo tài khoản" value="{{request()->username}}">
                        <label class="sr-only" for="example-if-password">Số điện thoại</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password" name="phone" placeholder="theo số điện thoại" value="{{request()->phone}}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <div style="margin-top: 15px;">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#ID</th>
                                        <th>Tài khoản</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>COIN</th>
                                        <th>Quyền</th>
                                        <th>Ngày đăng ký</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users)
                                        @foreach ($users as $user)
                                        <tr>
                                            <th class="text-center" scope="row">{{$user->id}}</th>
                                            <td class="font-w600">
                                                {{$user->username}}
                                            </td>
                                            <td>
                                                {{$user->email}}
                                            </td>
                                            <td>
                                                {{$user->phone}}
                                            </td>
                                            <td>
                                                {{number_format($user->coin)}}
                                            </td>
                                            <td>
                                                @if ($user->role == 1)
                                                    Admin
                                                @else
                                                    Member
                                                @endif
                                            </td>
                                            <td>
                                                {{format_time($user->created_at,"d-m-Y H:i:s")}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $users->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
