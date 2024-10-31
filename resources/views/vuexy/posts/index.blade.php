@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-body">
                    <a type="button" href="{{ route('posts.create') }}" class="btn btn-primary waves-effect waves-float waves-light">Tạo bài viết mới</a>
                    <table class="table table-striped table-borderless table-vcenter mt-5">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th style="width: 33%;">Tiêu đề</th>
                                <th class="d-none d-xl-table-cell">Ngày tạo</th>
                                <th class="d-none d-xl-table-cell">Ngày chỉnh sửa gần nhất</th>
                                <th  class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($posts)
                                @foreach ($posts as $post)
                                <tr>
                                    <td>
                                        {{$post->id}}
                                    </td>
                                    <td>
                                        <i class="fa fa-eye {{ ($post->public)?"text-success":"text-danger" }} mr-1"></i>
                                        <a href="{{route('posts.show', ['slug' => $post->slug])}}">
                                            {{$post->title}}
                                        </a>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        {{$post->created_at}}
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        {{$post->updated_at}}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="{{route('posts.getEdit',['id' => $post->id])}}">
                                            <i data-feather='edit'></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" href="{{route('posts.delete',['id' => $post->id])}}">
                                            <i data-feather='delete'></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $posts->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
