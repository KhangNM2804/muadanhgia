@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <div style="margin-top: 15px;">
                        <div class="react-bootstrap-table table-responsive">
                            <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#ID</th>
                                        <th>Tên thể loại</th>
                                        <th>Mô tả</th>
                                        <th>Loại</th>
                                        <th>Giá bán</th>
                                        <th>Hiển thị</th>
                                        <th>Thứ tự</th>
                                        <th>Ngày tạo</th>
                                        <th>Update lần cuối</th>
                                        <th class="text-center" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($categorys)
                                        @foreach ($categorys as $cate)
                                        <tr>
                                            <th class="text-center" scope="row">{{$cate->id}}</th>
                                            <td class="font-w600">
                                                {{$cate->name}}
                                            </td>
                                            <td>
                                                {{$cate->desc}}
                                            </td>
                                            <td>
                                                {{ get_type($cate->type) }}
                                            </td>
                                            <td>
                                                {{number_format($cate->price)}}
                                            </td>
                                            <td>
                                                {!! get_display($cate->display) !!}
                                            </td>
                                            <td>
                                                {{ $cate->sort_num }}
                                            </td>
                                            <td>
                                                {{format_time($cate->created_at,"d-m-Y H:i:s")}}
                                            </td>
                                            <td>
                                                {{format_time($cate->updated_at,"d-m-Y H:i:s")}}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('get_edit_cate', ['id' =>$cate->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                        <i data-feather='edit'></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
