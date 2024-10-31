@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                        <div class="kanban-container">
                            <div data-id="_working" class="kanban-board" style="margin-left: 0px; margin-right: 0px; width: 100%;">
                                <main style="padding: 10px; background-color: rgba(218, 255, 249, 1); color: black;">
                                    - Quý khách ghi đúng thông tin nạp tiền thì tài khoản sẽ được cộng tự động sau khi giao dịch thành công.<br />
                                    - Khuyến cáo nạp qua bank, vì nạp Momo đôi lúc giao dịch bị delay. Nạp bank thì 3s - 3p tiền lên.<br />
                                    - Nếu quý khách muốn nạp bằng phương thức khác, hoặc cần hỗ trợ vui lòng liên hệ Phone/Zalo : {{getSetting('zalo_support')}}
                                </main>
                            </div>
                        </div>
                        <p></p>
                        <div class="block-rounded block-bordered">
                            <div class="row row-deck">
                                
                                <!--Vietcombank-->
                                <div class="col-md-6">
                                    <div class="block block-rounded text-center">
                                        <div class="block-content block-content-full">
                                            <div style="text-align: center; padding-top: 2%;">
                                                <img src="https://file4.batdongsan.com.vn/crop/600x315/2020/09/08/20200908090341-1429_wm.jpg" style="width: 250px;" />
                                            </div>
                    
                                            <div style="text-align: left; padding-top: 2%;">
                                                <div class="kt-section__desc">
                                                    <div class="row mb-1">
                                                        <div class="col-6 text-right">Tên tài khoản:</div>
                                                        <div class="col-6 text-primary-dark"><strong class="text-danger">{{getSetting('bank_holder')}}</strong></div>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <div class="col-6 text-right">Số tài khoản:</div>
                                                        <div class="col-6 text-primary-dark">
                                                            <strong class="text-danger">{{getSetting('bank_account')}}</strong>
                                                            <a href="javascript:;" class="btn-copy js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_account')}}" data-original-title="Copy">
                                                                <i class="fa fa-copy"></i>
                                                            </a>
                                                            <br />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-6 text-right">Nội dung:</div>
                                                        <div class="col-6 text-primary-dark font-weight-bold">
                                                            <strong class="text-danger"><span class="text-danger">{{getSetting('bank_syntax')}} {{ Auth::user()->id}}</span></strong>
                                                            <a href="javascript:;" class="btn-copy js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_syntax')}} {{ Auth::user()->id}}" data-original-title="Copy"><i class="fa fa-copy"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Vietcombank-->
                    
                                <!--momo-->
                            </div>
                    
                        </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
