@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">Danh sách bài viết</h3>
                    </div>
                    <div class="block-content">
                        <a href="{{ route('posts.create') }}" class="btn btn-alt-primary">
                            <i class="fa fa-fw fa-check mr-1"></i> Tạo bài viết mới
                        </a>
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
                                            <a class="btn btn-sm btn-light" href="{{route('posts.getEdit',['id' => $post->id])}}">
                                                <i class="fa fa-fw fa-pencil-alt text-primary"></i>
                                            </a>
                                            <a class="btn btn-sm btn-light" href="{{route('posts.delete',['id' => $post->id])}}">
                                                <i class="fa fa-fw fa-times text-danger"></i>
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
    </div>
</main>
<!-- END Main Container -->
@endsection