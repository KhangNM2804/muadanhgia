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
                                        <th>Ngày giao dịch</th>
                                        <th>Mã giao dịch</th>
                                        <th>Số tiền</th>
                                        <th>Mô tả</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($gethistory))
                                        @foreach ($gethistory as $item)
                                        <tr>
                                            <td>{{ format_time($item->created_at,"d/m/Y H:i:s")}}</td>
                                            <td>{{$item->trans_id}}</td>
                                            <td>{{number_format($item->coin)}}đ</td>
            
                                            <td><em>{{$item->memo}} </em></td>
                                        </tr>
                                        @endforeach
                                    @else
                                    Chưa có giao dịch nạp tiền!
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
