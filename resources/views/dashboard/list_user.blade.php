@extends('layouts.master')
@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <!-- Table -->
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Danh sách khách hàng</h3>

                </div>
                <div class="block-content">
                    Tìm kiếm
                    <form class="form-inline mb-4" action="" method="GET">
                        <label class="sr-only" for="example-if-email">Tài khoản</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email"
                            name="username" placeholder="theo tài khoản" value="{{ request()->username }}">
                        <label class="sr-only" for="example-if-password">Số điện thoại</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password"
                            name="phone" placeholder="theo số điện thoại" value="{{ request()->phone }}">
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-password"
                            name="ip" placeholder="theo IP" value="{{ request()->ip }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <a href="{{ route('user_export_excel') }}" class="btn btn-danger ml-2">Xuất excel</a>
                    </form>
                    <table class="table table-vcenter" style="">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#ID</th>
                                <th>Tài khoản</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>COIN</th>
                                <th>Tổng nạp</th>
                                <th>Quyền</th>
                                <th>2FA</th>
                                <th>Login fail</th>
                                <th>Hoạt động</th>
                                <th>Chiết khấu</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users)
                                @foreach ($users as $user)
                                    <tr>
                                        <th class="text-center" scope="row">{{ $user->id }}</th>
                                        <td class="font-w600">
                                            {{ $user->username }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->phone }}
                                        </td>
                                        <td>
                                            {{ number_format($user->coin) }}
                                        </td>
                                        <td>
                                            {{ number_format($user->total_coin) }}
                                        </td>
                                        <td>
                                            @if ($user->role == 1)
                                                <span class="badge badge-danger badge-pill">admin</span>
                                            @elseif($user->role == 2)
                                                <span class="badge badge-warning badge-pill">nhân viên</span>
                                            @else
                                                <span class="badge badge-primary badge-pill">member</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->secret_code)
                                                <span class="badge badge-success badge-pill">Bật</span>
                                            @else
                                                <span class="badge badge-danger badge-pill">Tắt</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $user->fail_login }}
                                        </td>
                                        <td>
                                            <div
                                                class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                                <input type="checkbox" class="custom-control-input switch_band"
                                                    id="switch_band{{ $user->id }}" name="public" value="1"
                                                    {{ $user->is_band == 1 ? '' : 'checked' }}
                                                    data-user_id="{{ $user->id }}">
                                                <label class="custom-control-label"
                                                    for="switch_band{{ $user->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $user->chietkhau }}%
                                        </td>
                                        {{-- <td>
                                            {{ $user->last_ip }}
                                        </td>
                                        <td>
                                            {{ format_time($user->created_at, 'd-m-Y H:i:s') }}
                                        </td>
                                        <td>
                                            {{ format_time($user->updated_at, 'd-m-Y H:i:s') }}
                                        </td> --}}
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('edit_user', ['id' => $user->id]) }}"
                                                    class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $users->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            </div>
            <!-- END Table -->
        </div>
        <!-- END Page Content -->
        <div class="content">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Danh sách khách hàng giới thiệu</h3>
                </div>
                <div class="block-content">
                    <ul class="timeline timeline-alt">
                        @if (!empty($users_aff))
                            @foreach ($users_aff as $user_aff)
                                <li class="timeline-event">
                                    <div class="timeline-event-icon bg-default">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <div class="timeline-event-block block block-rounded js-appear-enabled animated fadeIn"
                                        data-toggle="appear">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">{{ $user_aff->username }}</h3>
                                        </div>
                                        <div class="block-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @php
                                                        $getChild = getChild($user_aff->id);
                                                    @endphp
                                                    @if (count($getChild) > 0)
                                                        <ul class="nav-items push">
                                                            @foreach ($getChild as $child)
                                                                <li>
                                                                    <a class="media py-2" href="javascript:void(0)">
                                                                        <div class="media-body">
                                                                            <div class="font-w600">{{ $child->username }}
                                                                            </div>
                                                                            <div class="font-size-sm text-muted">Last IP:
                                                                                {{ $child->last_ip }} | Ngày đăng kí:
                                                                                {{ format_time($child->created_at, 'd-m-Y H:i:s') }}
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        Chưa giới thiệu được
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <!-- END Main Container -->
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $(".switch_band").change(function(event) {
                var checked = event.target.checked

                var _this = $(this)
                var user_id = _this.data('user_id')
                console.log(_this, checked, user_id)
                Dashmix.layout('header_loader_on');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('bulk_update_user') }}',
                    data: {
                        user_id: user_id,
                        checked: checked,
                    },
                    success: function(res) {
                        Dashmix.layout('header_loader_off');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            })
        });
    </script>
@endpush
