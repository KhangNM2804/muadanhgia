@extends("auth.master_auth.master")
@section('content')

    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="row no-gutters justify-content-center bg-primary-dark-op">
                <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                    <!-- Sign Up Block -->
                    <div class="block block-rounded block-transparent w-100 mb-0 overflow-hidden bg-image">
                        <div class="row no-gutters">
                            <div class="col-md-12 order-md-1 bg-white">
                                <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                                    <!-- Header -->
                                    <div class="mb-2 text-center">
                                        <a class="link-fx text-primary font-w700 font-size-h1"
                                            href="{{ route('dashboard') }}">
                                            <span class="text-dark">{{ getSetting('website_name') }}</span><span
                                                class="text-primary"></span>
                                        </a>
                                        <p class="text-uppercase font-w700 font-size-sm text-muted"><?= __('labels.2fa_authen') ?></p>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach
                                        </div>
                                    @endif
                                    <form role="form" method="post" action="{{ route('two_face.verify') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="control-label" for="otp">
                                                <b>Authentication code</b>
                                            </label>
                                            <input type="text" name="code" class="form-control" placeholder="123456"
                                                autocomplete="off" maxlength="6" id="otp">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success col-md-12"><?= __('labels.login') ?></button>
                                        </div>
                                        <p class="text-muted">
                                            <?= __('labels.disable_2fa_note') ?>
                                        </p>
                                    </form>
                                    <div class="font-w600 font-size-sm py-1 text-center">
                                        <a href="{{ route('logout') }}"><?= __('labels.logout') ?></a>
                                    </div>
                                    <!-- END Sign Up Form -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- END Sign Up Block -->
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
@endsection
