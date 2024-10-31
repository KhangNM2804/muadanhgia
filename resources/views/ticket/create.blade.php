@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content content-full content-boxed">
        <form action="{{ route('ticket.post.create') }}" method="POST">
            @csrf
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-primary" href="{{ route('ticket.index') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Danh sách tickets
                    </a>
                </div>
                <div class="block-content">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <p class="mb-0">
                                @foreach ($errors->all() as $error)
                                    {{$error}} <br>
                                @endforeach
                            </p>

                        </div>
                    @endif
                    
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label>Tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" readonly value="{{ auth()->user()->username }}">
                                </div>
                                <div class="col-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" readonly value="{{ auth()->user()->email }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Đơn hàng liên quan</label>
                                    <select class="js-select2 form-control" id="select_type" name="buy_id" style="width: 100%;" data-placeholder="Để trống hoặc chọn đơn hàng liên quan">
                                        <option></option>
                                        @if (!empty($getHistoryBuy))
                                            @foreach ($getHistoryBuy as $item)
                                                <option value="{{$item->id}}" {{ (old('buy_id') == $item->id)?"selected":"" }}>Đơn hàng #{{$item->id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label>Độ ưu tiên <span class="text-danger">*</span></label>
                                    <select class="form-control" name="priority">
                                        <option value="1" {{ (old('priority') == 1)?"selected":"" }}>Cao</option>
                                        <option value="2" {{ (old('priority',2) == 2)?"selected":"" }}>Bình thường</option>
                                        <option value="3" {{ (old('priority') == 3)?"selected":"" }}>Thấp</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="dm-post-add-title">Tiêu đề <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="dm-post-add-title" name="title" value="{{old('title')}}" placeholder="Nhập tiêu đề bài viết...">
                            </div>
                            <div class="form-group">
                                <label>Nội dung <span class="text-danger">*</span></label>
                                <textarea id="js-ckeditor" name="content">{!!old('content')!!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-alt-success">
                                <i class="fa fa-fw fa-check mr-1"></i> Gửi ticket hỗ trợ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<!-- END Main Container -->
@endsection
