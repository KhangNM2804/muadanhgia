@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-4 text-center">
                            <div class="card card-profile">
                                <img src="{{asset('vuexy/app-assets/images/banner_support.jpeg')}}" class="img-fluid card-img-top" alt="Profile Cover Photo" style="height: 300px">
                                <div class="card-body">
                                    <div class="profile-image-wrapper">
                                        <div class="profile-image">
                                            <div class="avatar">
                                                <img src="{{asset('vuexy/app-assets/images/portrait/small/avatar-s-9.jpg')}}" alt="Profile Picture">
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Admin</h3>
                                    <div class="badge badge-light-primary profile-badge">Pro Level</div>
                                    <a class="btn btn-sm btn-light" href="tel:{{getSetting('zalo_support')}}"> <i data-feather='phone-call'></i> {{getSetting('zalo_support')}}</a>
                                    <hr class="mb-2">
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <h2 class="content-heading">Chính sách bảo hành</h2>
            <div class="row row-deck">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Bảo hành 24h</h4>
                            <p class="card-text">
                                {!!getSetting('baohanh_accept')!!}
                            </p>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Từ chối bảo hành</h4>
                            <p class="card-text">
                                {!!getSetting('baohanh_noaccept')!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection