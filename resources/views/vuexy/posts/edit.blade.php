@extends("layouts.master")
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('posts.postEdit', ['id' => $post->id]) }}" method="POST">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="alert-body">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="dm-post-add-title">Tiêu đề bài viết</label>
                                    <input type="text" class="form-control" id="dm-post-add-title" name="title" value="{{old('title', $post->title)}}" placeholder="Nhập tiêu đề bài viết...">
                                </div>
                                <div class="form-group">
                                    <label>Nội dung</label>
                                    <textarea id="js-ckeditor" name="body">{!!old('title', $post->body)!!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Yêu cầu thành viên bình luận mới thấy được nội dung</label>
                                    <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg1" name="is_comment" value="1" {{ (old('is_comment',$post->is_comment) == 1)?"checked":"" }}>
                                        <label class="custom-control-label" for="example-sw-custom-success-lg1"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Hiển thị</label>
                                    <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg2" name="public" value="1" {{ (old('public',$post->public) == 1)?"checked":"" }}>
                                        <label class="custom-control-label" for="example-sw-custom-success-lg2"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Ghim lên trang chủ</label>
                                    <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg3" name="pin" value="1" {{ (old('pin',$post->pin) == 1)?"checked":"" }}>
                                        <label class="custom-control-label" for="example-sw-custom-success-lg3"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Yêu cầu số dư để xem bài</label>
                                    <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg4" name="coin_flg" value="1" {{ (old('coin_flg',$post->coin_flg) == 1)?"checked":"" }}>
                                        <label class="custom-control-label" for="example-sw-custom-success-lg4"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dm-post-add-title">Nhập số tiền yêu cầu</label>
                                    <input type="number" class="form-control" id="dm-post-add-title" name="valid_coin" value="{{old('valid_coin', $post->valid_coin)}}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather='plus-circle'></i> Chỉnh sửa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            if (jQuery('#js-ckeditor:not(.js-ckeditor-enabled)').length) {
                CKEDITOR.replace('js-ckeditor');
            }

        })

    </script>
@endpush
