@extends('layouts.master')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="block block-themed">
                        <div class="block-header bg-gd-dusk">
                            <h3 class="block-title">Tạo website đấu api</h3>
                        </div>

                        <form action="{{ route('post_api_add_site') }}" method="post">
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
                                @if (Session::has('add_fail'))
                                    <div class="alert alert-danger" role="alert">
                                        <p class="mb-0">
                                            {{ Session::get('add_fail') }}
                                        </p>

                                    </div>
                                @endif

                                <div class="row py-sm-3 py-md-5">

                                    <div class="col-sm-10 col-md-8">
                                        <div class="form-group">
                                            <label for="block-form-username">Chọn hệ thống</label>
                                            <select class="form-control" id="select_system" name="system">
                                                @foreach ($system_api as $key => $item)
                                                    <option value="{{ $key }}"
                                                        @if (old('system', 1) == $key) selected @endif>
                                                        {{ $item }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="block-form-username">Domain</label>
                                            <input type="text" class="form-control" name="domain"
                                                placeholder="https://demo.com" value="{{ old('domain', '') }}">
                                        </div>
                                        <div id="system_normal"
                                            class="form-group {{ old('system', 1) != 3 ? 'd-block' : 'd-none' }}">
                                            <label for="block-form-username">API_KEY</label>
                                            <input type="text" class="form-control" name="api_key"
                                                placeholder="45645645654xxxx" value="{{ old('api_key', '') }}">
                                        </div>
                                        <div id="system_cmsnt" class="{{ old('system', 1) == 3 ? 'd-block' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="block-form-username">Username</label>
                                                <input type="text" class="form-control" name="username" placeholder="abc"
                                                    value="{{ old('username', '') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="block-form-username">Password</label>
                                                <input type="text" class="form-control" name="password"
                                                    placeholder="xxxx" value="{{ old('password', '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fa fa-check"></i> Thêm
                                </button>
                                <button type="reset" class="btn btn-sm btn-warning">
                                    <i class="fa fa-repeat"></i> Reset
                                </button>
                                <a href="{{ route('list_api_connect') }}" class="btn btn-sm btn-alt-primary">
                                    Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $("#select_system").change(function(event) {
                if (event.target.value == 3) {
                    $("#system_normal").removeClass('d-block').addClass('d-none');
                    $("#system_cmsnt").removeClass('d-none').addClass('d-block');
                } else {
                    $("#system_cmsnt").removeClass('d-block').addClass('d-none');
                    $("#system_normal").removeClass('d-none').addClass('d-block');
                }
            })
        })
    </script>
@endpush
