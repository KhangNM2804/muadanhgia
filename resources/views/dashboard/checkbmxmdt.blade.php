@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">Check BM XMDN</h3> 
                    </div>
                    <div class="block-content">
                            <div class="form-group">
                                <label for="example-textarea-input"><?= __('labels.list_bm_id') ?></label>
                                <textarea class="form-control" id="list-id" name="example-textarea-input" rows="10" placeholder="<?= __('labels.enter_list_bm_id') ?>"></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-hero-lg btn-rounded btn-hero-primary mr-1 mb-3" id="btn-submit-checkxmdn">
                                    <i class="fa fa-rocket mr-1"></i>
                                    <?= __('labels.btn_check') ?></button>
                            </div>

                            <div class="text-center mb-3">
                                <span class="nav-main-link-badge badge badge-pill badge-info p-3 font-size-h5"><?= __('labels.total') ?>: <span id="check-count-total">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-success p-3 font-size-h5">BM XMDN: <span id="check-count-bmxmdn">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-warning p-3 font-size-h5">BM chưa XMDN: <span id="check-count-bmchuaxmdn">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-danger p-3 font-size-h5"><?= __('labels.total_bm_error') ?>: <span id="check-count-error">0</span></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="example-textarea-input" class="text-success">Danh sách BM XMDN</label>
                                        <textarea class="form-control" id="list-bm-xmdn" name="example-textarea-input" rows="8" readonly=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="example-textarea-input" class="text-warning">Danh sách BM chưa XMDN</label>
                                        <textarea class="form-control" id="list-bm-chua-xmdn" name="example-textarea-input" rows="8" readonly=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
@endsection