<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Reset Password - {{getSetting('website_name')}}</title>

        <meta name="description" content="{{getSetting('website_name')}}">
        <meta name="author" content="thanhtrungit.net">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="{{getSetting('website_title')}}">
        <meta property="og:site_name" content="{{getSetting('website_description')}}">
        <meta property="og:description" content="{{getSetting('website_description')}}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/media/favicons/favicon-192x192.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/media/favicons/apple-touch-icon-180x180.png')}}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{asset('assets/css/dashmix.min.css')}}">
        {!! getSetting('gg_analytics') !!}
    </head>
    <body>

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
                                            <a class="link-fx text-primary font-w700 font-size-h1" href="{{ route('dashboard') }}">
                                                <span class="text-dark">{{getSetting('website_name')}}</span><span class="text-primary"></span>
                                            </a>
                                            <p class="text-uppercase font-w700 font-size-sm text-muted">Reset Mật Khẩu</p>
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
                                        <form class="js-validation-signup" action=" {{route('password.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="token" value="{{$token}}">
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-alt" id="signup-email" name="email" placeholder="Email" value="{{$email}}">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-alt" id="signup-email" name="password" placeholder="Mật khẩu mới" value="{{ request()->old('password') ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-alt" id="signup-email" name="password_confirmation" placeholder="Nhập lại mật khẩu mới" value="{{ request()->old('password_confirmation') ?? '' }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-hero-primary">
                                                    Đổi mật khẩu
                                                </button>
                                            </div>
                                        </form>
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

        <!-- Terms Modal -->
        <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Terms &amp; Conditions</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                            <p>Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                        </div>
                        <div class="block-content block-content-full text-right bg-light">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/js/dashmix.core.min.js')}}"></script>
        <script src="{{asset('assets/js/dashmix.app.min.js')}}"></script>
    </body>
</html>
