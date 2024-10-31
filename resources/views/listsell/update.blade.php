@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="block block-themed">
                    <div class="block-header bg-gd-dusk">
                        <h3 class="block-title">Edit</h3>
                    </div>
                    
                    <form action="{{ route('post_listviasell_update', ['id' => $sell->id]) }}" method="post">
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
                                    <label>Chọn loại (nếu không thay đổi thì giữ nguyên)</label>
                                    <select class="js-select2 form-control" id="select_type" name="select_type" style="width: 100%;" data-placeholder="Chọn loại">
                                        <option></option>
                                        @if (!empty($categorys))
                                            @foreach ($categorys as $item)
                                                <option value="{{$item->id}}" {{ ($item->id == $sell->type)?"selected": ""}}>{{$item->name}} - {{number_format($item->price)}}đ</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nhập info</label>
                                    <textarea name="full_info" class="form-control" rows="5">{{ old('name',$sell->full_info) }}</textarea>
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
</main>
@endsection