@extends("auth.master_auth.master")
@section('content')

        <div id="page-container">

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="row no-gutters justify-content-center bg-primary-dark-op">
                    <div class="hero-static col-sm-10 col-md-8 col-xl-6 d-flex align-items-center p-2 px-sm-0">
                        <!-- Sign Up Block -->
                        <div class="block block-rounded block-transparent w-100 mb-0 overflow-hidden bg-image">
                            <div class="row no-gutters">
                                <div class="col-md-12 order-md-1 bg-white">
                                    <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                                        <!-- Header -->
                                        <div class="mb-2 text-center">
                                            @if (!empty(getSetting('web_logo')))
                                                <img src="{{ getSetting('web_logo') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="mb-2 text-center">
                                            <a class="link-fx text-primary font-w700 font-size-h1" href="{{ route('dashboard') }}">
                                                <span class="text-dark">{{getSetting('website_name')}}</span><span class="text-primary"></span>
                                            </a>
                                            <p class="text-uppercase font-w700 font-size-sm text-muted"><?= __('labels.reset_password') ?></p>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger" role="alert">
                                                <p class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        {{$error}} <br>
                                                    @endforeach
                                                </p>

                                            </div>
                                        @endif
                                        @if (Session::has('status'))
                                            <div class="alert alert-success" role="alert">
                                                <p class="mb-0">
                                                    {{Session::get('status')}}
                                                </p>

                                            </div>
                                        @endif
                                        <form class="js-validation-signup" action=" {{route('password.email') }}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-alt" id="signup-email" name="email" placeholder="Email" value="{{ request()->old('email') ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-hero-primary">
                                                    <?= __('labels.send_mail') ?>
                                                </button>
                                            </div>
                                        </form>
                                        <div class="text-center">
                                            <a href="{{ route('change_lang', ['locale' => 'vi']) }}"><img src="{{ asset('assets/media/country/109-vietnam.png') }}" width="25px"></a>
                                            <a href="{{ route('change_lang', ['locale' => 'en']) }}"><img src="{{ asset('assets/media/country/110-united kingdom.png') }}" width="25px"></a>
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
