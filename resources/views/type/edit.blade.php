@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-themed">
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title">Edit danh mục</h3>
                        </div>
                        <form action="{{ route('post_edit_type', ['id' => $getType->id]) }}" method="post">
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
                                                {{ $error }} <br>
                                            @endforeach
                                        </p>
                                    </div>
                                @endif

                                <div class="row py-sm-3 py-md-5">

                                    <div class="col-sm-10 col-md-8">
                                        <div class="form-group">
                                            <label for="block-form-username">Tên danh mục</label>
                                            <input type="text" class="form-control" name="name" placeholder=""
                                                value="{{ old('name', $getType->name) }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Hiển thị</label>
                                            <div
                                                class="custom-control custom-switch custom-control-success custom-control-lg mb-2">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="example-sw-custom-success-lg2" name="display" value="1"
                                                    {{ old('display', $getType->display) == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="example-sw-custom-success-lg2"></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Thứ tự</label>
                                            <select name="sort_num" class="form-control">
                                                @for ($i = 1; $i < 200; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('sort_num', $getType->sort_num) == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block mb-2">Chọn icon</label>
                                            <div
                                                class="custom-control custom-radio custom-control-inline custom-control-primary mb-2">
                                                <input type="radio" class="custom-control-input"
                                                    id="example-radio-custom-inlinex" name="icon"
                                                    {{ old('icon', $getType->icon) == '' ? 'checked' : '' }} value="">
                                                <label class="custom-control-label" for="example-radio-custom-inlinex">Không
                                                    hiển thị icon</label>
                                            </div>
                                            @foreach ($files_icon as $key => $item)
                                                <div
                                                    class="custom-control custom-radio custom-control-inline custom-control-primary mb-2">
                                                    <input type="radio" class="custom-control-input"
                                                        id="example-radio-custom-inline{{ $key }}" name="icon"
                                                        {{ old('icon', $getType->icon) == $item->getFileName() ? 'checked' : '' }}
                                                        value="{{ $item->getFileName() }}">
                                                    <label class="custom-control-label"
                                                        for="example-radio-custom-inline{{ $key }}"><img
                                                            src="{{ asset('assets/media/country/' . $item->getFileName()) }}"
                                                            alt="" width="25px">
                                                        {{ $item->getFileName() }}</label>
                                                </div>
                                            @endforeach
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
