<div class="bg-body-light mb-2">
    <div class="content">
     <div class="row justify-content-center gutters-tiny push js-appear-enabled animated fadeIn" data-toggle="appear">
      <div class="col-6 col-md-4 col-xl-2">
       <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="javascript:void(0)">
        <div class="block-content block-content-full bg-gd-sublime-op aspect-ratio-16-9 d-flex justify-content-center align-items-center py-0">
         <div>
          <i class="fa fa-2x fa-coins text-white"></i>
          <div class="font-w600 mt-3 text-uppercase text-white">Số dư: <b class="counter">{{ number_format(Auth::user()->coin) }}</b></div>
         </div>
        </div>
       </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
       <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('naptien')}}">
        <div class="block-content block-content-full bg-gd-aqua-op aspect-ratio-16-9 d-flex justify-content-center align-items-center py-0">
         <div>
           <i class="fab fa-2x fa-amazon-pay"></i>
          <div class="font-w600 mt-3 text-uppercase text-white">Nạp Tiền</div>
         </div>
        </div>
       </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
       <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('history_buy')}}">
        <div class="block-content block-content-full bg-gd-sea-op aspect-ratio-16-9 d-flex justify-content-center align-items-center py-0">
         <div>
          <i class="fa fa-2x fa-briefcase text-white"></i>
          <div class="font-w600 mt-3 text-uppercase text-white">Lịch sử mua</div>
         </div>
        </div>
       </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
       <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('lichsunap')}}">
        <div class="block-content block-content-full bg-gd-sea-op aspect-ratio-16-9 d-flex justify-content-center align-items-center py-0">
         <div>
          <i class="fa fa-2x fa-briefcase text-white"></i>
          <div class="font-w600 mt-3 text-uppercase text-white">Lịch sử GD</div>
         </div>
        </div>
       </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
       <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('account')}}">
        <div class="block-content block-content-full bg-gd-dusk-op aspect-ratio-16-9 d-flex justify-content-center align-items-center py-0">
         <div>
          <i class="fa fa-2x fa-user text-white"></i>
          <div class="font-w600 mt-3 text-uppercase text-white">Account</div>
         </div>
        </div>
       </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
       <a class="block block-rounded text-center bg-image" style="background-image: url('img/login.png');" href="{{route('logout')}}">
        <div class="block-content block-content-full bg-gd-sun-op aspect-ratio-16-9 d-flex justify-content-center align-items-center py-0">
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