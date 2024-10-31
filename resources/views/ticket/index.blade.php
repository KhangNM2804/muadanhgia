@extends("layouts.master")
@section("content")
<main id="main-container">
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="block block-rounded block-themed block-fx-pop">
                    <div class="block-header bg-info">
                        <h3 class="block-title">Danh sách tickets</h3>
                    </div>
                    <div class="block-content">
                        @cannot('admin_role')
                        <a href="{{ route('ticket.post.create') }}" class="btn btn-alt-primary mb-5">
                            <i class="fa fa-fw fa-check mr-1"></i> Gửi ticket mới
                        </a>
                        @endcannot
                        
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full2 mt-5">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th style="width: 33%;">Tiêu đề</th>
                                    <th  class="text-center">Mức độ ưu tiên</th>
                                    <th  class="text-center">Trạng thái</th>
                                    <th class="d-none d-xl-table-cell">Ngày tạo</th>
                                    <th class="d-none d-xl-table-cell">Ngày cập nhật gần nhất</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tickets)
                                    @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <a href="{{route('ticket.show', ['ticket_id' => $ticket->id])}}">
                                            {{$ticket->id}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('ticket.show', ['ticket_id' => $ticket->id])}}">
                                                {{$ticket->title}}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {!! get_priority_ticket($ticket->priority) !!}
                                        </td>
                                        <td class="text-center">
                                            {!! get_status_ticket($ticket->status) !!}
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{$ticket->created_at}}
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            {{$ticket->updated_at}}
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- END Main Container -->
@endsection