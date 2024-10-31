@extends("layouts.master")
@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-detached">
                <div class="content-body">
                    <!-- Blog Detail -->
                    <div class="blog-detail-wrapper">
                        <div class="row">
                            <!-- Blog -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">{{$post->title}}</h4>
                                        <div class="media">
                                            <div class="avatar mr-50">
                                                <img src="{{ asset('vuexy/app-assets/images/portrait/small/avatar-s-11.jpg') }}" alt="Avatar" width="24" height="24">
                                            </div>
                                            <div class="media-body">
                                                <small class="text-muted mr-25">by</small>
                                                <small><a href="javascript:void(0);" class="text-body">{{getSetting('website_name')}}</a></small>

                                            </div>
                                        </div>
                                        <p class="card-text mb-2 mt-2">
                                            @if ($post->is_comment)
                                                @if($post->hasCommentsFromUser(auth()->user()->id))
                                                    {!! $post->body !!}
                                                @else
                                                    Bài viết này yêu cầu bạn bình luận phía dưới mới có thể xem nội dung!
                                                @endif
                                            @elseif($post->coin_flg)
                                                @if(auth()->user()->coin >= $post->valid_coin)
                                                    {!! $post->body !!}
                                                @else
                                                    Bài viết này yêu cầu bạn phải có số dư trên {{ number_format($post->valid_coin) }} mới được xem
                                                @endif
                                            @else
                                                {!! $post->body !!}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--/ Blog -->
                            <!-- Leave a Blog Comment -->
                            <div class="col-12 mt-1">
                                <h6 class="section-label mt-25">Để lại bình luận</h6>
                                <div class="card">
                                    <div class="card-body">
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
                                        <form action="{{route('posts.comment')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type=hidden name=post_id value="{{ $post->id }}" />
                                                    <textarea class="form-control mb-2" rows="4" name="body" placeholder="Nhập bình luận..."></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Post Comment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ Leave a Blog Comment -->
                            <!-- Blog Comment -->
                            <div class="col-12 mt-1" id="blogComment">
                                <h6 class="section-label mt-25">{{count($post->comments)}} Bình luận</h6>
                                @if (count($post->comments) > 0)
                                    @foreach($post->comments as $comment)
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="avatar mr-75">
                                                        <img src="{{ asset('vuexy/app-assets/images/portrait/small/avatar-s-11.jpg') }}" width="38" height="38" alt="Avatar">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="font-weight-bolder mb-25">{{ $comment->user->username }} @if($comment->user->role == 1) <i class="text-primary" data-feather='check-circle'></i> @endif</h6>
                                                        <p class="card-text">{{time_elapsed_string($comment->created_at)}}</p>
                                                        <p class="card-text">
                                                            {{ $comment->body }}
                                                        </p>
                                                        @can('admin_role')
                                                            <a class="badge badge-danger" href="{{route('comment.delete', ['id' => $comment->id])}}">Xoá</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    Chưa có bình luận nào!
                                @endif

                            </div>
                            <!--/ Blog Comment -->
                        </div>
                    </div>
                    <!--/ Blog Detail -->

                </div>
            </div>
        </div>
    </div>
@endsection
