@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">

    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-themed">
            <div class="block-header bg-gd-dusk">
                <h3 class="block-title">Danh sách đang bán</h3>
                
            </div>
            <div class="block-content">
                Tìm kiếm
                <form class="form-inline mb-4" action="" method="GET">
                    <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-if-email" name="uid" placeholder="theo uid" value="{{request()->uid}}">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <p class="mb-0">
                            {{Session::get('success')}}
                        </p>
                        
                    </div>
                @endif
                <table class="table table-vcenter mt-2">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#ID</th>
                            <th>info</th>
                            <th>Loại</th>
                            <th>Ngày up</th>
                            <th>Update lần cuối</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($listsell)
                            @foreach ($listsell as $sell)
                            <tr>
                                <th class="text-center" scope="row">{{$sell->id}}</th>
                                <td class="font-w600">
                                    {{$sell->full_info}}
                                </td>
                                <td>
                                    {{ $sell->category->name }}
                                </td>
                                <td>
                                    {{format_time($sell->created_at,"d-m-Y H:i:s")}}
                                </td>
                                <td>
                                    {{format_time($sell->updated_at,"d-m-Y H:i:s")}}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('get_listviasell_update', ['id' =>$sell->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-toggle="tooltip" title="Xoá" data-sell_id="{{$sell->id}}">
                                            Xoá
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $listsell->links('vendor.pagination.custom') }}
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
@push('custom-scripts')
<script>
    $(document).ready(function () {
        $(".delete-btn").click(function (t) {
            var n = $(this).data("sell_id");
            Swal.fire({
                title: "Xác nhận xoá dữ liệu này?",
                confirmButtonText: '<i class="fa fa-trash"></i> Xoá',
                cancelButtonText: "Close",
                showCancelButton: !0,
                showLoaderOnConfirm: !0,
                preConfirm: function (t) {
                    return $.ajax({
                        type: 'GET',
                        url: '/listsell/delete/' + n,
                        success: function(res) {
                            Swal.fire("Success","Xoá thành công!","success");
                            location.reload();
                        },
                    });
                },
                allowOutsideClick: function () {
                    return !Swal.isLoading();
                },
            }).then(function (t) {
            });
        });
    });
</script>
    
@endpush