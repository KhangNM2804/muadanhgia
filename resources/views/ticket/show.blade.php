@extends("layouts.master")
@section('content')
    <main id="main-container">
        <div class="content content-full content-boxed">
            <div class="block">
                <div class="block-header block-header-default">
                    <a class="btn btn-primary" href="{{ route('ticket.index') }}">
                        <i class="fa fa-arrow-left mr-1"></i> Danh sách tickets
                    </a>
                </div>
                <div class="block-content">
                    <div class="row push">
                        <div class="col-md-10">
                            <div class="row mb-2">
                                <div class="col-4">
                                    <label>Tài khoản: {{ $ticket->getuser->username }}</label>
                                </div>
                                <div class="col-4">
                                    <label>Email: {{ $ticket->getuser->email }}</label>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <label>Đơn hàng liên quan: @if($ticket->buy_id) <a href="{{ route('don_hang', ['id' => $ticket->buy_id]) }}">#{{$ticket->buy_id}}</a> @else Không @endif</label>
                                </div>
                                <div class="col-4">
                                    <label>Độ ưu tiên: {!! get_priority_ticket($ticket->priority) !!}</label>
                                </div>
                                <div class="col-4">
                                    <label>Trạng thái: {!! get_status_ticket($ticket->status) !!}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block block-rounded">
                <div class="block-content">
                    <table class="table table-borderless">
                        <tbody>
                            <tr class="table-active">
                                <td class="d-none d-sm-table-cell"></td>
                                <td class="font-size-sm text-muted">
                                    <span class="text-danger font-weight-bold">{{ $ticket->title }}</span> / on <span>{{ $ticket->created_at }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                    <div class="block-content block-content-full bg-primary">
                                        <img class="img-avatar img-avatar-thumb" src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                                    </div>
                                    <div class="block-content block-content-full block-content-sm bg-primary-light">
                                        <p class="font-w600 text-white mb-0">{{ $ticket->getuser->username }}</p>
                                        <p class="font-size-sm font-italic text-white-75 mb-0">
                                            @if ($ticket->getuser->role == 1)
                                        <span class="badge badge-pill badge-danger">Quản trị viên</span> <i class="fa fa-check-circle mr-1 text-white"></i>
                                    @else
                                        <span class="badge badge-danger badge-pill">Khách hàng</span>
                                    @endif
                                        </p>
                                    </div>
                                    {{-- <p>
                                        <a href="be_pages_generic_profile.html">
                                            <img class="img-avatar"
                                                src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                                        </a>
                                    </p>
                                    <p class="font-size-sm"><label class="badge badge-pill badge-info">{{ $ticket->getuser->username }}</label> @if ($ticket->getuser->role == 1)
                                        <span class="badge badge-pill badge-danger">Quản trị viên</span> <i class="fa fa-check-circle mr-1 text-primary"></i>
                                    @else
                                        <span class="badge badge-danger badge-pill">Khách hàng</span>
                                    @endif</p> --}}
                                </td>
                                <td>
                                    {!! $ticket->content !!}
                                    <hr>
                                    <p class="font-size-sm text-muted">IP Address: {{ $ticket->ip_address }}</p>
                                </td>
                            </tr>
                            @if ($ticket->comments)
                                @foreach ($ticket->comments as $ticket_comment)
                                <tr class="table-active">
                                    <td class="d-none d-sm-table-cell"></td>
                                    <td class="font-size-sm text-muted">
                                        <span>{{ $ticket_comment->getuser->username }} / {{ $ticket_comment->created_at }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                        <div class="block-content block-content-full bg-primary">
                                            <img class="img-avatar img-avatar-thumb" src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                                        </div>
                                        <div class="block-content block-content-full block-content-sm bg-primary-light">
                                            <p class="font-w600 text-white mb-0">{{ $ticket_comment->getuser->username }}</p>
                                            <p class="font-size-sm font-italic text-white-75 mb-0">
                                                @if ($ticket_comment->getuser->role == 1)
                                            <span class="badge badge-pill badge-danger">Quản trị viên</span> <i class="fa fa-check-circle mr-1 text-white"></i>
                                        @else
                                            <span class="badge badge-danger badge-pill">Khách hàng</span>
                                        @endif
                                            </p>
                                        </div>
                                        {{-- <p>
                                            <a href="be_pages_generic_profile.html">
                                                <img class="img-avatar"
                                                    src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                                            </a>
                                        </p>
                                        <p class="font-size-sm"><label class="badge badge-pill badge-info">{{ $ticket_comment->getuser->username }}</label> @if ($ticket_comment->getuser->role == 1)
                                            <span class="badge badge-pill badge-danger">Quản trị viên</span> <i class="fa fa-check-circle mr-1 text-primary"></i>
                                        @else
                                            <span class="badge badge-danger badge-pill">Khách hàng</span>
                                        @endif</p> --}}
                                    </td>
                                    <td>
                                        {!! $ticket_comment->content !!}
                                        <hr>
                                        <p class="font-size-sm text-muted">IP Address: {{ $ticket_comment->ip_address }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            <tr class="table-active" id="forum-reply-form">
                                <td class="d-none d-sm-table-cell"></td>
                                <td class="font-size-sm text-muted">
                                    Trả lời
                                </td>
                            </tr>
                            <tr>
                                <td class="d-none d-sm-table-cell text-center">
                                    <div class="block-content block-content-full bg-primary">
                                        <img class="img-avatar img-avatar-thumb" src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                                    </div>
                                    <div class="block-content block-content-full block-content-sm bg-primary-light">
                                        <p class="font-w600 text-white mb-0">{{ auth()->user()->username }}</p>
                                        <p class="font-size-sm font-italic text-white-75 mb-0">
                                            @if (Auth::user()->role == 1)
                                        <span class="badge badge-pill badge-danger">Quản trị viên</span> <i class="fa fa-check-circle mr-1 text-white"></i>
                                    @else
                                        <span class="badge badge-danger badge-pill">Khách hàng</span>
                                    @endif
                                        </p>
                                    </div>
                                    {{-- <p>
                                        <a href="be_pages_generic_profile.html">
                                            <img class="img-avatar" src="{{ asset('assets/media/avatars/boy-avatar-4-1129037.webp') }}" alt="">
                                        </a>
                                    </p>
                                    <p class="font-size-sm"><p class="font-size-sm"><label class="badge badge-pill badge-info">{{ auth()->user()->username }}</label>
                                    @if (Auth::user()->role == 1)
                                        <span class="badge badge-pill badge-danger">Quản trị viên</span> <i class="fa fa-check-circle mr-1 text-primary"></i>
                                    @else
                                        <span class="badge badge-danger badge-pill">Khách hàng</span>
                                    @endif</p></p> --}}
                                </td>
                                <td>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            <p class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }} <br>
                                                @endforeach
                                            </p>
                                        </div>
                                    @endif
                                    <form action="{{ route('ticket.post.comment', ['ticket_id' => $ticket->id]) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <textarea id="js-ckeditor" name="content">{!!old('content')!!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-hero-primary">
                                                <i class="fa fa-reply mr-1"></i> Reply
                                            </button>
                                            @if ($ticket->status != 4)
                                            <button type="button" class="btn btn-hero-primary" id="close_ticket" data-ticket_id="{{ $ticket->id }}">
                                                Close ticket
                                            </button>
                                            @endif
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- END Main Container -->
@endsection
