@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">

    <!-- Page Content -->
    <div class="content">
        <!-- Table -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Lịch sử giải captcha</h3>
                <p>Tổng {{ $historys->total() }} captchas</p>
            </div>
            <div class="block-content">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#ID</th>
                            <th>Captcha</th>
                            <th>Text</th>
                            <th>Status</th>
                            <th>Create at</th>
                            <th class="text-center" style="width: 100px;">Coin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($historys)
                            @foreach ($historys as $history)
                            <tr>
                                <th class="text-center" scope="row">{{$history->id}}</th>
                                <td class="font-w600">
                                    <img src="{{ URL::asset('storage/uploads/captcha/'.$history->filename) }}" width="100px" />
                                </td>
                                <td>
                                    {{$history->captcha}}
                                </td>
                                <td>
                                    @if ($history->status == "true")
                                        <span class="badge badge-success">{{$history->status}}</span>
                                    @else
                                        <span class="badge badge-danger">{{$history->status}}</span>
                                    @endif
                                </td>
                                <td>
                                    {{format_time($history->created_at,"d-m-Y H:i:s")}}
                                </td>
                                <td class="text-center">
                                    -{{$history->coin}}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $historys->links() }}
            </div>
        </div>
        <!-- END Table -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection