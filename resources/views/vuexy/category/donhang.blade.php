@extends("layouts.master")
@section("content")
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="invoice-preview-wrapper">
                <div class="row invoice-preview">
                    <!-- Invoice -->
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="card invoice-preview-card">
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="">UID</th>
                                            <th class="">Info</th>
                                            <th class="">Backup</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($getHistoryBuy->getSelled)
                                            @foreach ($getHistoryBuy->getSelled as $detail)
                                            <tr>
                                                <td class="" style="white-space: nowrap;">
                                                    <a class="btn-copy text-body-color link-fx" href="javascript:;" data-clipboard-text="{{$detail->uid}}">{{$detail->uid}}</a>
                                                </td>
                                                <td class="" style="white-space: nowrap;">
                                                    <span class="text-truncate d-block" style="width: 300px;">
                                                        <a class="btn-copy text-body-color" href="javascript:;" data-clipboard-text="{{$detail->full_info}}">{{$detail->full_info}}</a>
                                                    </span>
                                                </td>
                                                <td class="" style="white-space: nowrap;">
                                                    <a href="/download_backup/{{$getHistoryBuy->id}}/{{$detail->uid}}" data-toggle="tooltip" data-placement="top" title="" class="js-tooltip-enabled" data-original-title="Tải về file Backup">
                                                        <i data-feather='download-cloud'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- Invoice Description ends -->

                            

                            <!-- Invoice Note starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="font-weight-bold">Note:</span>
                                        <span>Thank You!</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Note ends -->
                        </div>
                    </div>
                    <!-- /Invoice -->

                    <!-- Invoice Actions -->
                    <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="">
                                    Hoá đơn số
                                    <span class="invoice-number">#{{$getHistoryBuy->id}}</span>
                                </h4>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Ngày mua:</p>
                                    <p class="invoice-date">{{format_time($getHistoryBuy->created_at,"d/m/Y H:i:s")}}</p>
                                </div>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Thể loại:</p>
                                    <p class="invoice-date">{{$getHistoryBuy->gettype->name}}</p>
                                </div>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Số lượng :</p>
                                    <p class="invoice-date">{{$getHistoryBuy->quantity}}</p>
                                </div>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Tổng tiền :</p>
                                    <p class="invoice-date">{{number_format($getHistoryBuy->total_price)}}đ</p>
                                </div>
                                <a class="btn btn-primary btn-block mb-75 mt-2" href="{{ route('export_txt', ['id' => $getHistoryBuy->id]) }}"><i data-feather='file-text'></i> Download (.txt)</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Invoice Actions -->
                </div>
            </section>


        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
