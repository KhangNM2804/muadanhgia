@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="block block-themed">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">Tạo thể loại mới</h3>
                    </div>
                    
                    <form action="{{ route('post_create_cate') }}" method="post">
                    @csrf
                    <div class="block-content">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h3 class="alert-heading font-size-h4 my-2">Có lỗi</h3>
                                <p class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        {{$error}} <br>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                        
                        <div class="row py-sm-3 py-md-5">
                            
                            <div class="col-sm-10 col-md-8">
                                <div class="form-group">
                                    <label for="block-form-username">Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name" placeholder="" value="{{ old('name','') }}">
                                </div>
                                <div class="form-group">
                                    <label for="block-form-password">Mô tả ngắn</label>
                                    <input type="text" class="form-control" name="desc" placeholder="" value="{{ old('desc','') }}">
                                </div>
                                <div class="form-group">
                                    <label for="block-form-password">Mô tả chi tiết</label>
                                    <textarea name="long_desc" class="form-control" rows="5">{{ old('long_desc','') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="block-form-password">Giá</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="price" placeholder="" value="{{ old('price','') }}">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary">
                                                <i class="fab fa-facebook-f"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="block-form-password">Số lượng mua tối thiếu / lần (để trống là không limit)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="min_can_buy" placeholder="" value="{{ old('min_can_buy','') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Chọn loại</label>
                                    @if (!empty($types))
                                        @foreach ($types as $item)
                                        <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                            <input type="radio" class="custom-control-input" id="example-radio-custom-inline{{$item->id}}" name="type" value="{{$item->id}}" {{ (old('type',1) == $item->id)?"checked":"" }}>
                                            <label class="custom-control-label" for="example-radio-custom-inline{{$item->id}}">{{$item->name}}</label>
                                        </div>
                                        @endforeach
                                    @endif
                                    
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Hiển thị</label>
                                    <div class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-success-lg2" name="display" value="1" {{ (old('display',1) == 1)?"checked":"" }}>
                                        <label class="custom-control-label" for="example-sw-custom-success-lg2"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Thứ tự</label>
                                    <select name="sort_num" class="form-control">
                                        @for ($i = 1; $i < 200; $i++)
                                            <option value="{{$i}}" {{ (old('sort_num',1) == $i)?"selected":"" }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fa fa-check"></i> Tạo sản phẩm
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
</main>
@endsection