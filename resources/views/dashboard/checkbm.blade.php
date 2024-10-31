@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">Check BM Limit / Live</h3> 
                    </div>
                    <div class="block-content">
                            <div class="form-group">
                                <label for="example-textarea-input"><?= __('labels.list_bm_id') ?></label>
                                <textarea class="form-control" id="list-id" name="example-textarea-input" rows="10" placeholder="<?= __('labels.enter_list_bm_id') ?>"></textarea>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-hero-lg btn-rounded btn-hero-primary mr-1 mb-3" id="btn-submit">
                                    <i class="fa fa-rocket mr-1"></i>
                                    <?= __('labels.btn_check') ?></button>
                            </div>

                            <div class="text-center mb-3">
                                <span class="nav-main-link-badge badge badge-pill badge-info p-3 font-size-h5"><?= __('labels.total') ?>: <span id="check-count-total">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-success p-3 font-size-h5">Limit $350: <span id="check-count-350">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-warning p-3 font-size-h5">Limit $50: <span id="check-count-50">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-success p-3 font-size-h5"><?= __('labels.total_bm_live') ?>: <span id="check-count-live">0</span></span>
                                <span class="nav-main-link-badge badge badge-pill badge-danger p-3 font-size-h5"><?= __('labels.total_bm_error') ?>: <span id="check-count-error">0</span></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="example-textarea-input" class="text-success">Danh sách BM 350$</label>
                                        <textarea class="form-control" id="list-bm-350" name="example-textarea-input" rows="8" readonly=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="example-textarea-input" class="text-warning">Danh sách BM 50$</label>
                                        <textarea class="form-control" id="list-bm-50" name="example-textarea-input" rows="8" readonly=""></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="example-textarea-input" class="text-success">Danh sách BM Live</label>
                                        <textarea class="form-control" id="list-bm-red" name="example-textarea-input" rows="8" readonly=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="example-textarea-input" class="text-danger"><del>Danh sách Die</del></label>
                                        <textarea class="form-control" id="list-bm-error" name="example-textarea-input" rows="8" readonly=""></textarea>
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