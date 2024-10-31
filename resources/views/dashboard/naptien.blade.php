@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">
    <div class="content">
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

        @if (!empty(getSetting('paypal_client_id')) && !empty(getSetting('paypal_secret')))
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title"><?= __('labels.pay_with_paypal') ?></h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-settings"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="form-group">
                    <label><?= __('labels.deposit_amount') ?> ( USD - <?= __('labels.rate') ?> {{ number_format(getSetting('paypal_rate')) }} ):</label>
                    <div class="input-group" style="width:200px">
                        <input type="number" class="form-control" id="amount_paypal" placeholder="USD" value="10">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary">
                                $
                            </button>
                        </div>
                    </div>
                </div>
                <div id="paypal-button-container" style="width:100px"></div>
            </div>
        </div>
        @endif

        @if (!empty(getSetting('nowpayment_apikey')) && !empty(getSetting('nowpayment_ipn')))
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title">Payment with Crypto</h3>
            </div>
            <div class="block-content">
                <img src="{{ asset('assets/list_coin.png') }}" alt="">
                <form action="{{ route('nowpayment.create') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label><?= __('labels.deposit_amount') ?> ( USD - <?= __('labels.rate') ?> {{ number_format(getSetting('paypal_rate')) }} ):</label>
                        <div class="input-group" style="width:200px">
                            <input type="number" class="form-control" name="amount" placeholder="USD" value="{{ old('amount',12) }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary">
                                    $
                                </button>
                            </div>
                        </div>
                        @if ($errors->has('amount'))
                            <label class="text-danger">{{ $errors->first('amount') }}</label>
                        @endif
                    </div>
                    <button class="btn btn-primary mb-5" type="submit"><i class="fas fa-coins"></i> Create Payment</button>
                </form>
            </div>
        </div>
        @endif
        @if (!empty(getSetting('perfectmoney_id')) && !empty(getSetting('perfectmoney_pass')))
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title"> <img src="https://iconape.com/wp-content/png_logo_vector/perfect-money-logo.png" alt="" width="32px"> Payment with Perfect Money</h3>
            </div>
            <div class="block-content">
                <form action="https://perfectmoney.com/api/step1.asp" method="post">
                    <div class="form-group">
                        <label><?= __('labels.deposit_amount') ?> ( USD - <?= __('labels.rate') ?> {{ number_format(getSetting('paypal_rate')) }} ):</label>
                        <div class="input-group" style="width:200px">
                            <input type="hidden" name="PAYEE_ACCOUNT" value="{{ getSetting('perfectmoney_id') }}">
                            <input type="hidden" name="PAYEE_NAME" value="{{ env('APP_NAME') }}">
                            <input type="hidden" name="PAYMENT_ID" value="{{ env('APP_NAME').'-'.auth()->user()->id.'-order-'.time() }}">
                            <input type="hidden" name="PAYMENT_UNITS" value="USD">
                            <input type="hidden" name="STATUS_URL" value="{{ route('perfectmoney_callback') }}">
                            <input type="hidden" name="PAYMENT_URL" value="{{ route('naptien') }}">
                            <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
                            <input type="hidden" name="NOPAYMENT_URL" value="{{ route('naptien') }}">
                            <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
                            <input type="hidden" name="SUGGESTED_MEMO" value="">
                            <input type="hidden" name="BAGGAGE_FIELDS" value="">
                            <input type="text" class="form-control" name="PAYMENT_AMOUNT" placeholder="USD" value="{{ old('amount',10) }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary">
                                    $
                                </button>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mb-5" type="submit"><i class="fas fa-coins"></i> Create Payment</button>
                </form>
            </div>
        </div>
        @endif

        <div class="block-rounded block-bordered">
            <div class="row row-deck">
                @if (!empty(getSetting('flag_auto_vcb')))
                <div class="col-md-6 col-sm-12 mt-2">
                    <div class="body-qr p-2 bg-white">
                        <div class="item-left">
                           <h3>THÔNG TIN NẠP TIỀN</h3>
                           <div>
                              <p>Ngân hàng: <span>Vietcombank</span></p>
                              <p>Chủ tài khoản: <br><span>{{getSetting('bank_holder')}}</span> </p>
                              <p>Số tài khoản: <br><span>{{getSetting('bank_account')}}</span> <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_account')}}" data-original-title="Copy">
                                <i class="fa fa-copy"></i>
                            </a></p>
                              <p>Nội dung chuyển khoản: <br><span>{{getSetting('bank_syntax')}} {{ Auth::user()->id}}</span>
                                <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_syntax')}} {{ Auth::user()->id}}" data-original-title="Copy"><i class="fa fa-copy"></i></a>
                              </p>
                           </div>
                           <p class="content-sub">Hệ thống sẽ tự động cộng tiền vào tài khoản của bạn sau khoảng 1-5 phút. Nếu quá 2 tiếng tiền chưa được cộng vui lòng liên hệ admin để được hỗ trợ. <br>
                        <span class="text-bold">Lưu ý đối với Vietcombank: Giao dịch sẽ bị delay lúc 22h~3h sáng hàng ngày, khách hàng không nạp qua VCB vào khoảng thời gian này</span></p>
                        </div>
                        <div class="item-right">
                           <h3>Quét mã QR để thanh toán</h3>
                           <p>Sử dụng <span>App Internet Banking</span> hoặc ứng dụng camera hỗ trợ QR code để quét mã</p>
                           <div class="img-item"><img alt="" src="https://qr.ecaptcha.vn/api/generate/vcb/{{getSetting('bank_account')}}/{{getSetting('bank_holder')}}?memo={{getSetting('bank_syntax')}} {{ Auth::user()->id}}&is_mask=0&bg=16"></div>
                        </div>
                     </div>
                </div>
                @endif
                @if (!empty(getSetting('flag_auto_mb')))
                <div class="col-md-6 col-sm-12 mt-2">
                    <div class="body-qr p-2 bg-white">
                        <div class="item-left">
                           <h3>THÔNG TIN NẠP TIỀN</h3>
                           <div>
                              <p>Ngân hàng: <span>MB Bank</span></p>
                              <p>Chủ tài khoản: <br><span>{{getSetting('bank_holder_mb')}}</span> </p>
                              <p>Số tài khoản: <br><span>{{getSetting('bank_account_mb')}}</span> <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_account_mb')}}" data-original-title="Copy">
                                <i class="fa fa-copy"></i>
                            </a></p>
                              <p>Nội dung chuyển khoản: <br><span>{{getSetting('bank_syntax')}} {{ Auth::user()->id}}</span>
                                <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_syntax')}} {{ Auth::user()->id}}" data-original-title="Copy"><i class="fa fa-copy"></i></a>
                              </p>
                           </div>
                           <p class="content-sub">Hệ thống sẽ tự động cộng tiền vào tài khoản của bạn sau khoảng 1-5 phút. Nếu quá 2 tiếng tiền chưa được cộng vui lòng liên hệ admin để được hỗ trợ. </p>
                        </div>
                        <div class="item-right">
                           <h3>Quét mã QR để thanh toán</h3>
                           <p>Sử dụng <span>App Internet Banking</span> hoặc ứng dụng camera hỗ trợ QR code để quét mã</p>
                           <div class="img-item"><img alt="" src="https://qr.ecaptcha.vn/api/generate/mb/{{getSetting('bank_account_mb')}}/{{getSetting('bank_holder_mb')}}?memo={{getSetting('bank_syntax')}} {{ Auth::user()->id}}&is_mask=0&bg=16"></div>
                        </div>
                     </div>
                </div>
                @endif
                @if (!empty(getSetting('flag_auto_acb')))
                    <div class="col-md-6 col-sm-12 mt-2">
                        <div class="body-qr p-2 bg-white">
                            <div class="item-left">
                               <h3>THÔNG TIN NẠP TIỀN</h3>
                               <div>
                                  <p>Ngân hàng: <span>ACB - Á châu</span></p>
                                  <p>Chủ tài khoản: <br><span>{{getSetting('bank_holder_acb')}}</span> </p>
                                  <p>Số tài khoản: <br><span>{{getSetting('bank_account_acb')}}</span> <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_account_acb')}}" data-original-title="Copy">
                                    <i class="fa fa-copy"></i>
                                </a></p>
                                  <p>Nội dung chuyển khoản: <br><span>{{$random}} {{getSetting('bank_syntax')}} {{ Auth::user()->id}}</span>
                                    <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{$random}} {{getSetting('bank_syntax')}} {{ Auth::user()->id}}" data-original-title="Copy"><i class="fa fa-copy"></i></a>
                                  </p>
                               </div>
                               <p class="content-sub">Hệ thống sẽ tự động cộng tiền vào tài khoản của bạn sau khoảng 1-5 phút. Nếu quá 2 tiếng tiền chưa được cộng vui lòng liên hệ admin để được hỗ trợ. </p>
                            </div>
                            <div class="item-right">
                               <h3>Quét mã QR để thanh toán</h3>
                               <p>Sử dụng <span>App Internet Banking</span> hoặc ứng dụng camera hỗ trợ QR code để quét mã</p>
                               <div class="img-item"><img alt="" src="https://qr.ecaptcha.vn/api/generate/acb/{{getSetting('bank_account_acb')}}/{{getSetting('bank_holder_acb')}}?memo={{$random}} {{getSetting('bank_syntax')}} {{ Auth::user()->id}}&is_mask=0&bg=16"></div>
                            </div>
                         </div>
                    </div>
                @endif
                @if (!empty(getSetting('flag_auto_vietinbank')))
                <div class="col-md-6 col-sm-12 mt-2">
                    <div class="body-qr p-2 bg-white">
                        <div class="item-left">
                           <h3>THÔNG TIN NẠP TIỀN</h3>
                           <div>
                              <p>Ngân hàng: <span>Vietinbank</span></p>
                              <p>Chủ tài khoản: <br><span>{{getSetting('bank_holder_vietinbank')}}</span> </p>
                              <p>Số tài khoản: <br><span>{{getSetting('bank_account_vietinbank')}}</span> <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_account_vietinbank')}}" data-original-title="Copy">
                                <i class="fa fa-copy"></i>
                            </a></p>
                              <p>Nội dung chuyển khoản: <br><span>{{getSetting('bank_syntax')}} {{ Auth::user()->id}}</span>
                                <a href="javascript:;" class="btn-copy js-tooltip-enabled text-white" data-toggle="tooltip" data-placement="top" title="" data-clipboard-text="{{getSetting('bank_syntax')}} {{ Auth::user()->id}}" data-original-title="Copy"><i class="fa fa-copy"></i></a>
                              </p>
                           </div>
                           <p class="content-sub">Hệ thống sẽ tự động cộng tiền vào tài khoản của bạn sau khoảng 1-5 phút. Nếu quá 2 tiếng tiền chưa được cộng vui lòng liên hệ admin để được hỗ trợ. </p>
                        </div>
                        <div class="item-right">
                           <h3>Quét mã QR để thanh toán</h3>
                           <p>Sử dụng <span>App Internet Banking</span> hoặc ứng dụng camera hỗ trợ QR code để quét mã</p>
                           <div class="img-item"><img alt="" src="https://qr.ecaptcha.vn/api/generate/icb/{{getSetting('bank_account_vietinbank')}}/{{getSetting('bank_holder_vietinbank')}}?memo={{getSetting('bank_syntax')}} {{ Auth::user()->id}}&is_mask=0&bg=16"></div>
                        </div>
                     </div>
                </div>
                @endif
            </div>

        </div>
    </div>

</main>
<!-- END Main Container -->
@endsection
@push('custom-scripts')
<script src="https://www.paypal.com/sdk/js?client-id={{getSetting('paypal_client_id')}}&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    $(document).ready(function(){
        var urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('crypto_status')) {
            Swal.fire('Success','Deposit to wallet from crypto completed! Please waiting...','success');
        }
    });
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'pay',

        },

        createOrder: function(data, actions) {
          var value = $("#amount_paypal").val();
          return actions.order.create({
            purchase_units: [{"amount":{"currency_code":"USD","value": value}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            HoldOn.open({
                theme:"custom",
                content:'<img style="width:200px;" src="https://help.iubenda.com/wp-content/uploads/2020/05/paypal.png" class="center-block">',
                message:'Payment processing...',
            });
              $.ajax({
                    type: 'POST',
                    url: '/paypal/callback',
                    data: {
                        order_id: details.id,
                    },
                    success: function(res) {
                        if(res.status){
                            $("#top_balance").html(res.coin)
                            Swal.fire('Success',res.msg,'success');
                        }else{
                            Swal.fire('Error',res.msg,'error');
                        }
                        HoldOn.close();
                    },
                });
          });
        },

        onError: function(err) {
          console.log(err);
          HoldOn.close();
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>
@endpush
