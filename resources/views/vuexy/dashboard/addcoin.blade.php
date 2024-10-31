@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{route('post_addcoin')}}" class="form-material m-t-40">
                        @csrf
                        <div class="form-group">
                            <label>Khách hàng <span class="help"></span></label>
                            <select class="form-control select2" name="user_id" style="width: 100%;" data-placeholder="Chọn user">
                                <option></option>
                                @if (!empty($allUser))
                                    @foreach ($allUser as $item)
                                        <option value="{{$item->id}}">ID: {{$item->id}} - {{$item->username}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Số tiền</label>
                            <input type="number" name="coin" class="form-control form-control-line" value="" />
                        </div>
                        <div class="form-group">
                            <label>Mã giao dịch</label>
                            <input type="text" name="trans_id" class="form-control form-control-line" value="{{ rand() }}" />
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <input type="text" name="memo" class="form-control form-control-line" value="Admin cộng tiền" />
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Tạo giao dịch</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
