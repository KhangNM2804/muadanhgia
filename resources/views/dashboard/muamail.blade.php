@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h4 class="block-title">Thông Báo</h4>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                </div>
            </div>
            <div class="block-content">
                <div class="font-w600 animated fadeIn bg-body-light border-2x px-3 py-1 mb-3 shadow-sm mw-100 border-left border-success rounded-right">
                    {{getSetting('header_notices')}}
                </div>
            </div>
        </div>
    </div>
    <div class="bg-body-light mb-2">
        <div class="content">
         <div class="row justify-content-center gutters-tiny push js-appear-enabled animated fadeIn" data-toggle="appear">
          <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="javascript:void(0)">
            <div class="block-content block-content-full bg-gd-sublime-op aspect-ratio-16-9 d-flex justify-content-center align-items-center">
             <div>
              <i class="fa fa-2x fa-coins text-white"></i>
              <div class="font-w600 mt-3 text-uppercase text-white">Số dư: <b class="counter">{{ number_format(Auth::user()->coin) }}</b></div>
             </div>
            </div>
           </a>
          </div>
          <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('naptien')}}">
            <div class="block-content block-content-full bg-gd-aqua-op aspect-ratio-16-9 d-flex justify-content-center align-items-center">
             <div>
               <i class="fab fa-2x fa-amazon-pay"></i>
              <div class="font-w600 mt-3 text-uppercase text-white">Nạp Tiền</div>
             </div>
            </div>
           </a>
          </div>
          <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('history_buy')}}">
            <div class="block-content block-content-full bg-gd-sea-op aspect-ratio-16-9 d-flex justify-content-center align-items-center">
             <div>
              <i class="fa fa-2x fa-briefcase text-white"></i>
              <div class="font-w600 mt-3 text-uppercase text-white">Lịch sử mua</div>
             </div>
            </div>
           </a>
          </div>
          <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('lichsunap')}}">
            <div class="block-content block-content-full bg-gd-sea-op aspect-ratio-16-9 d-flex justify-content-center align-items-center">
             <div>
              <i class="fa fa-2x fa-briefcase text-white"></i>
              <div class="font-w600 mt-3 text-uppercase text-white">Lịch sử GD</div>
             </div>
            </div>
           </a>
          </div>
          <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('account')}}">
            <div class="block-content block-content-full bg-gd-dusk-op aspect-ratio-16-9 d-flex justify-content-center align-items-center">
             <div>
              <i class="fa fa-2x fa-user text-white"></i>
              <div class="font-w600 mt-3 text-uppercase text-white">Account</div>
             </div>
            </div>
           </a>
          </div>
          <div class="col-6 col-md-4 col-xl-2">
           <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('logout')}}">
            <div class="block-content block-content-full bg-gd-sun-op aspect-ratio-16-9 d-flex justify-content-center align-items-center">
             <div>
              <i class="fa fa-2x fa-sign-out-alt text-white"></i>
              <div class="font-w600 mt-3 text-uppercase text-white">Đăng xuất</div>
             </div>
            </div>
           </a>
          </div>
         </div>
        </div>
    </div>

    <div class="content">
        @if (count($listMail) > 0)
		<div class="block block-themed">
			<div class="block-header bg-gd-dusk">
				<h3 class="block-title">Danh sách Mail</h3>
			</div>
			<div class="block-content block-content-full border-bottom">
				<div class="row row-deck">
						@foreach ($listMail as $item)
						<div class="col-md-6 col-xl-3">
							<a class="block block-rounded block-bordered block-link-pop block-themed text-center clone-item" href="javascript:void(0)">
								<div class="block-header">
									<span class="flex-fill font-size-h6 font-w400 js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="{{$item->name}}">{{$item->name}}</span>
								</div>
								<div class="block-content bg-body-light pt-2">
									<div class="py-2">
										<p class="h4 font-w700 mb-2 text-muted">
											<i class="font-w400" style="font-size: 0.77rem;"></i> <strong class="text-danger">» {{number_format($item->price)}}đ</strong>
										</p>
										<p class="h6 text-muted mb-1">Còn lại: <strong class="badge badge-primary badge-pill font-size-h6 pl-2 pr-2">{{$item->sell->count()}}</strong></p>
									</div>
								</div>
								<div class="block-content block-content-full pricing_block">
									<ul class="list-unstyled text-left">
										<li><i class="fa fa-check text-success"></i> {{$item->desc}}</li>
									</ul>
								</div>
								<div class="block-content block-content-full bg-body-light">
									<button class="btn btn-hero-primary px-4 buy-btn" data-type-id="{{$item->id}}" data-name="{{$item->name}}" data-price="{{$item->price}}" data-available="{{$item->sell->count()}}"><i class="fa fa-cart-plus mr-1"></i> MUA</button>
								</div>
							</a>
						</div>
						@endforeach
				</div>				
			</div>
		</div>
        @endif
	</div>
	
    <!-- Page Content -->
    <div class="content">
        

        <!-- Users and Purchases -->
        <div class="row row-deck">
            <div class="col-xl-6 invisible" data-toggle="appear">
                <!-- Users -->
                <div class="block block-themed">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">Lịch sử mua hàng gần nhất</h3>
                    </div>
                    <div class="block-content">
                        @if ($getHistoryBuy)
                            @foreach ($getHistoryBuy as $item)
                            <div class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                <b>
                                    <font color="green"> <i class="fa fa-bell"></i> {{substr($item->getuser->username,0,strlen($item->getuser->username)-3)}}***</font>:
                                    <font color="red">Đã mua {{$item->quantity}} {{$item->gettype->name}} - {{number_format($item->gettype->price)}} VNĐ</font>
                                </b>
                                <span style="float: right;">
                                    <span class="badge badge-info js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="2021-02-20 17:45:52">
                                        <em> {{time_elapsed_string($item->created_at)}}</em>
                                    </span>
                                </span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- END Users -->
            </div>
            <div class="col-xl-6 invisible" data-toggle="appear" data-timeout="200">
                <!-- Purchases -->
                <div class="block block-themed">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">Lịch sử nạp tiền</h3>
                    </div>
                    <div class="block-content">
                        @if ($getHistoryBank)
                            @foreach ($getHistoryBank as $item)
                            <div class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                <b>
                                    <font color="green"> <i class="fa fa-bell"></i> {{substr($item->getuser->username,0,strlen($item->getuser->username)-3)}}***</font>:
                                    <font color="red">Đã nạp {{number_format($item->coin)}} VNĐ - {{$item->type}}</font>
                                </b>
                                <span style="float: right;">
                                    <span class="badge badge-info js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="2021-02-20 17:45:52">
                                        <em> {{time_elapsed_string($item->created_at)}}</em>
                                    </span>
                                </span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- END Purchases -->
            </div>
        </div>
        <!-- END Users and Purchases -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection