@extends("layouts.master")
@section("content")
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Lịch sử mua hàng</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 33%;">Tiêu đề</th>
                            <th class="d-none d-xl-table-cell">Ngày tạo</th>
                            <th class="d-none d-xl-table-cell">Ngày chỉnh sửa gần nhất</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($posts)
                            @foreach ($posts as $post)
                                <tr>
                                    <td>
                                        <a href="{{route('posts.show', ['slug' => $post->slug])}}">
                                            <i class="far fa fa-file-alt"></i> {{$post->title}}
                                        </a>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        {{$post->created_at}}
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        {{$post->updated_at}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            Chưa có đơn hàng nào!
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
