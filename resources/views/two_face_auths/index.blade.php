@extends("layouts.master")
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="block block-rounded block-themed block-fx-pop">
                        <div class="block-header bg-info">
                            <h3 class="block-title"><?= __('labels.enable_disable_2fa') ?></h3>
                            <div class="block-options">
                            </div>
                        </div>
                        <div class="block-content">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger" role="alert">
                                    <p class="mb-0">
                                        {{ Session::get('error') }}
                                    </p>

                                </div>
                            @endif
                            @if ($user->secret_code)
                            <form role="form" method="post" action="{{ route('disable_2fa_setting') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label" for="otp">
                                        <b>Authentication code</b>
                                    </label>
                                    <input type="text" name="code" class="form-control" placeholder="123456"
                                        autocomplete="off" maxlength="6" id="otp">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success"><?= __('labels.disable_2fa') ?></button>
                                </div>
                                <p class="text-muted">
                                    <?= __('labels.disable_2fa_note') ?>
                                </p>
                            </form>
                            @else
                            <form role="form" method="post" action="{{ route('enable_2fa_setting') }}">
                                {{ csrf_field() }}
                                <h2><?= __('labels.scan_qrcode') ?></h2>
                                <p class="text-muted">
                                    <?= __('labels.scan_qrcode_note') ?>
                                </p>
                                <p class="">
                                    <img src="{{ $qrCodeUrl }}" />
                                </p>
                                <h5><?= __('labels.enter_2fa') ?></h5>
                                <p class="text-muted">
                                    <?= __('labels.after_enter_2fa') ?>
                                </p>
                                <div class="form-group">
                                    <input type="text" name="code" class="form-control" placeholder="123456"
                                        autocomplete="off" maxlength="6">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success"><?= __('labels.enable_2fa') ?></button>
                                    <a href="{{ route('account') }}" class="btn btn-secondary"><?= __('labels.exit') ?></a>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- END Main Container -->
@endsection
