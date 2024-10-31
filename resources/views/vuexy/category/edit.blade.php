@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post_edit_cate', ['id' => $getCate->id]) }}" method="post">
                        @csrf
                        <div class="block-content">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="alert-body">
                                        @foreach ($errors->all() as $error)
                                            {{$error}} <br>
                                        @endforeach
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            <div class="row py-sm-3 py-md-5">
                                
                                <div class="col-sm-10 col-md-8">
                                    <div class="form-group">
                                        <label for="block-form-username">Tên sản phẩm</label>
                                        <input type="text" class="form-control" name="name" placeholder="" value="{{ old('name',$getCate->name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="block-form-password">Mô tả chi tiết</label>
                                        <input type="text" class="form-control" name="desc" placeholder="" value="{{ old('desc',$getCate->desc) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="block-form-password">Giá</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="price" placeholder="" value="{{ old('price',$getCate->price) }}">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary">
                                                    <i data-feather='dollar-sign'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="d-block">Chọn loại</label>
                                        <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                            <input type="radio" class="custom-control-input" id="example-radio-custom-inline1" name="type" value="1" {{ (old('type',$getCate->type) == 1)?"checked":"" }}>
                                            <label class="custom-control-label" for="example-radio-custom-inline1">Via</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                            <input type="radio" class="custom-control-input" id="example-radio-custom-inline2" name="type" value="2" {{ (old('type',$getCate->type) == 2)?"checked":"" }}>
                                            <label class="custom-control-label" for="example-radio-custom-inline2">Clone</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                            <input type="radio" class="custom-control-input"  id="example-radio-custom-inline3" name="type" value="3" {{ (old('type',$getCate->type) == 3)?"checked":"" }}>
                                            <label class="custom-control-label" for="example-radio-custom-inline3">BM</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                            <input type="radio" class="custom-control-input"  id="example-radio-custom-inline4" name="type" value="4" {{ (old('type',$getCate->type) == 4)?"checked":"" }}>
                                            <label class="custom-control-label" for="example-radio-custom-inline4">Mail</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="d-block">Hiển thị</label>
                                        <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                            <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg2" name="display" value="1" {{ (old('display',$getCate->display) == 1)?"checked":"" }}>
                                            <label class="custom-control-label" for="example-sw-custom-success-lg2"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="d-block">Thứ tự</label>
                                        <select name="sort_num" class="form-control">
                                            @for ($i = 1; $i < 200; $i++)
                                                <option value="{{$i}}" {{ (old('sort_num',$getCate->sort_num) == $i)?"selected":"" }}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i> Lưu thay đổi
                            </button>
                            <button type="reset" class="btn btn-sm btn-warning">
                                <i class="fa fa-repeat"></i> Reset
                            </button>
                        </div>
                        </form>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END: Content-->
@endsection
