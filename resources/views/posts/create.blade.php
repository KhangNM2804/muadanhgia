@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content content-full content-boxed">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-light" href="{{ route('posts') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Danh sách bài viết
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
                            <div class="form-group">
                                <label for="dm-post-add-title">Tiêu đề bài viết</label>
                                <input type="text" class="form-control" id="dm-post-add-title" name="title" value="{{old('title')}}" placeholder="Nhập tiêu đề bài viết...">
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea id="js-ckeditor" name="body">{!!old('body')!!}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Yêu cầu thành viên bình luận mới thấy được nội dung</label>
                                <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg1" name="is_comment" value="1" {{ (old('is_comment',0) == 1)?"checked":"" }}>
                                    <label class="custom-control-label" for="example-sw-custom-success-lg1"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Hiển thị</label>
                                <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg2" name="public" value="1" {{ (old('public',1) == 1)?"checked":"" }}>
                                    <label class="custom-control-label" for="example-sw-custom-success-lg2"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Ghim lên trang chủ</label>
                                <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg3" name="pin" value="1" {{ (old('pin',0) == 1)?"checked":"" }}>
                                    <label class="custom-control-label" for="example-sw-custom-success-lg3"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Yêu cầu số dư để xem bài</label>
                                <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg4" name="coin_flg" value="1" {{ (old('coin_flg',0) == 1)?"checked":"" }}>
                                    <label class="custom-control-label" for="example-sw-custom-success-lg4"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dm-post-add-title">Nhập số tiền yêu cầu</label>
                                <input type="number" class="form-control" id="dm-post-add-title" name="valid_coin" value="{{old('valid_coin', 0)}}" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content bg-body-light">
                    <div class="row justify-content-center push">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-fw fa-check mr-1"></i> Tạo bài viết
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
