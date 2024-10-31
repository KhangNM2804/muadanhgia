@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default border-bottom bg-gd-dusk"><h3 class="block-title" style="color: white;"><?= __('labels.transaction_history') ?></h3></div>
            <div class="block-content">
                <div style="margin-top: 15px;">
                    <div class="react-bootstrap-table table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th><?= __('labels.transaction_date') ?></th>
                                    <th><?= __('labels.transaction_code') ?></th>
                                    <th><?= __('labels.amount') ?></th>
                                    <th><?= __('labels.memo') ?></th>
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
    
    
</main>
<!-- END Main Container -->
@endsection