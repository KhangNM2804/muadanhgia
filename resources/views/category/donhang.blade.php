@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header">
                <h3 class="block-title">
                    <a href="{{route('history_buy')}}" class="text-white"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?= __('labels.back') ?></a>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?= __('labels.order_detail') ?> <em class="opacity-75">#{{$getHistoryBuy->id}}</em>
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="row mb-4">
                            <div class="col-3 text-right"><?= __('labels.order_no') ?> :</div>
                            <div class="col-9">
                                <a href="javascript:;" class="btn-copy text-black link-fx font-weight-bold" data-clipboard-text="{{$getHistoryBuy->id}}">{{$getHistoryBuy->id}}</a>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-3 text-right"><?= __('labels.type') ?>:</div>
                            <div class="col-9 font-weight-bold">{{$getHistoryBuy->gettype->name}}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 text-right"><?= __('labels.time') ?> :</div>
                            <div class="col-9 font-weight-bold">{{format_time($getHistoryBuy->created_at,"d/m/Y H:i:s")}}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row mb-4">
                            <div class="col-3 text-right"><?= __('labels.quantity') ?> :</div>
                            <div class="col-9 font-weight-bold">{{$getHistoryBuy->quantity}}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-3 text-right"><?= __('labels.total_amount') ?> :</div>
                            <div class="col-9 font-weight-bold">{{number_format($getHistoryBuy->total_price)}}đ</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 text-right"><?= __('labels.order_status') ?> :</div>
                            <div class="col-9 font-weight-bold">
                                <span class="text-success"><?= __('labels.completed') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-gd-dusk">
                <h3 class="block-title"><?= __('labels.product_desc') ?></h3>
                <div class="block-options">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-success" href="{{ route('export_txt', ['id' => $getHistoryBuy->id]) }}"><i class="fa fa-file-alt fa-2x" aria-hidden="true"></i> Download (.txt)</a>
                        {{-- <a class="btn btn-success" href="{{ route('download_zip_backup', ['id' => $getHistoryBuy->id]) }}"><i class="far fa-file-archive fa-2x" aria-hidden="true"></i> Download all backup</a> --}}
                    </div>
                    
                </div>
            </div>
            <div class="block-content block-content-full border-bottom">
                <div style="margin-top: 15px;">
                    <div class="react-bootstrap-table table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th class="text-center">UID</th>
                                    <th class="text-center">Info</th>
                                    {{-- <th class="text-center">Backup</th> --}}
                                    <th class="text-center">Phôi via</th>
                                    <th class="d-sm-table-cell text-center" style="width: 80px;"><i class="far fa-question-circle"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getHistoryBuy->getSelled)
                                    @foreach ($getHistoryBuy->getSelled as $detail)
                                    <tr>
                                        <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                            <a class="btn-copy text-body-color link-fx" href="javascript:;" data-clipboard-text="{{$detail->uid}}">{{$detail->uid}}</a>
                                        </td>
                                        <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                            <span class="text-truncate d-block" style="width: 300px;">
                                                <a class="btn-copy text-body-color" href="javascript:;" data-clipboard-text="{{$detail->full_info}}">{{$detail->full_info}}</a>
                                            </span>
                                        </td>
                                        {{-- <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                            <a href="/download_backup/{{$getHistoryBuy->id}}/{{$detail->uid}}" data-toggle="tooltip" data-placement="top" title="" class="js-tooltip-enabled" data-original-title="Tải về file Backup">
                                                <i class="fa fa-download text-primary" aria-hidden="true"></i>
                                            </a>
                                        </td> --}}
                                        <td class="d-sm-table-cell text-center" style="white-space: nowrap;">
                                            <a href="/download_phoi/{{$getHistoryBuy->id}}/{{$detail->uid}}" data-toggle="tooltip" data-placement="top" title="" class="js-tooltip-enabled" data-original-title="Tải về phôi via">
                                                <i class="fa fa-download text-primary" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-outline-primary btn-copy js-click-ripple-enabled" data-clipboard-text="{{$detail->full_info}}"><i class="fa fa-clone"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                
                            </tbody>
                        </table>
                        {{ $getHistoryBuy->getSelled->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</main>
@endsection