@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="bg-image" style="background-image: url('/assets/media/photos/photo22@2x.jpg');">
        <div class="bg-black-75">
            <div class="content content-top content-full text-center">
                <h1 class="font-w700 text-white mt-5 mb-3 invisible" data-toggle="appear">
                    {{$post->title}}
                </h1>
                <p class="invisible" data-toggle="appear" data-timeout="400">
                    <a class="badge badge-pill badge-primary font-size-base px-3 py-2 mr-2 m-1" href="javascript:void(0)">
                        <i class="fa fa-user-circle mr-1"></i> by {{getSetting('website_name')}}
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="content content-full">
        <div class="row justify-content-center">
            <div class="col-sm-8 py-5 bg-white">
                <article class="js-gallery story" style="word-break: break-word;">
                    @if ($post->is_comment)
                        @if($post->hasCommentsFromUser(auth()->user()->id))
                        {!! $post->body !!}
                        @else
                        <?= __('labels.required_comment_view_post') ?>
                        @endif
                    @elseif($post->coin_flg)
                        @if(auth()->user()->coin >= $post->valid_coin)
                            {!! $post->body !!}
                        @else
                            <?= sprintf(__('labels.required_view_post'), number_format($post->valid_coin)) ?>
                            {{-- Bài viết này yêu cầu bạn phải có số dư trên {{ number_format($post->valid_coin) }} mới được xem --}}
                        @endif
                    @else
                    {!! $post->body !!}
                    @endif
                </article>
                <div class="mt-5 d-flex justify-content-between push">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light" data-toggle="tooltip" title="<?= __('labels.comment') ?>">
                            <i class="fa fa-comments text-danger"></i> {{count($post->comments)}} <?= __('labels.comment') ?>
                        </button>
                    </div>
                </div>
                <div class="px-4 pt-4 rounded bg-white">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <p class="mb-0">
                                @foreach ($errors->all() as $error)
                                    {{$error}} <br>
                                @endforeach
                            </p>

                        </div>
                    @endif
                    <form action="{{route('posts.comment')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="body" placeholder="<?= __('labels.enter_comment') ?>">
                                <input type=hidden name=post_id value="{{ $post->id }}" />
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-comments mr-1"></i> <?= __('labels.comment') ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="pt-3 font-size-sm">
                        @if (count($post->comments) > 0)
                            @foreach($post->comments as $comment)
                            <div class="media">
                                <a class="img-link mr-2" href="javascript:void(0)">
                                    <img class="img-avatar img-avatar32 img-avatar-thumb" src="{{ asset('assets/media/avatars/avatar3.jpg') }}" alt="">
                                </a>
                                <div class="media-body">
                                    <p class="mb-1">
                                        <a class="font-w600" href="javascript:void(0)">{{ $comment->user->username }}</a> @if($comment->user->role == 1) <i class="fa fa-check-circle mr-1 text-primary"></i> @endif
                                        {{ $comment->body }}
                                        <span class="badge badge-primary">{{time_elapsed_string($comment->created_at)}}</span>
                                        @can('admin_role')
                                        <a class="badge badge-danger" href="{{route('comment.delete', ['id' => $comment->id])}}">Xoá</a>
                                        @endcan
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        @else
                        Chưa có bình luận nào!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
@endsection
