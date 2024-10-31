@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title"><?= __('labels.support') ?></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option"></button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row mb-5">
                            <div class="col-md-6 col-xl-3 text-center">
                                <a class="block block-rounded bg-gd-sublime text-center" href="tel:{{getSetting('zalo_support')}}">
                                    <div class="block-content block-content-full">
                                        <img class="img-avatar img-avatar-thumb img-avatar-rounded" src="/images/support/avatar1.jpg" alt="" />
                                    </div>
                                    <div class="block-content block-content-full bg-black-10">
                                        <p class="font-w600 text-white mb-0">admin</p>
                                        <p class="font-size-sm font-italic text-white-75 mb-0">
                                            {{getSetting('zalo_support')}}
                                        </p>
                                    </div>
                                    <p class="font-size-sm text-white-75 mb-0">
                                        Chuyên gia Ads Facebook
                                    </p>
                                </a>
                                <a class="btn btn-sm btn-light" href="tel:{{getSetting('zalo_support')}}"> <i class="fas fa-phone-alt"></i><?= __('labels.call_now') ?>  </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <h2 class="content-heading"><?= __('labels.policy') ?></h2>
    
        <div class="row row-deck">
            <div class="col-md-6">
                <div class="block block-rounded text-center">
                    <div class="block-content bg-gd-primary">
                        <p class="text-white text-uppercase font-size-sm font-w700">
                            <?= __('labels.policy_accept') ?>
                        </p>
                    </div>
                    <div class="block-content block-content-full">
                        {!!getSetting('baohanh_accept')!!}
                    </div>
                </div>
            </div>
    
            <div class="col-md-6">
                <div class="block block-rounded text-center">
                    <div class="block-content bg-gd-fruit">
                        <p class="text-white text-uppercase font-size-sm font-w700">
                            <?= __('labels.policy_deny') ?>
                        </p>
                    </div>
                    <div class="block-content block-content-full">
                        {!!getSetting('baohanh_noaccept')!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</main>
<!-- END Main Container -->
@endsection