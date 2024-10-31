@extends("layouts.master")
@section("content")
<!-- Main Container -->
<main id="main-container">
    <div class="content">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default border-bottom bg-gd-dusk"><h3 class="block-title" style="color: white;">Login history</h3></div>
            <div class="block-content">
                <div style="margin-top: 15px;">
                    <div class="react-bootstrap-table table-responsive">
                        <table class="table table-bordered table-striped table-vcenter" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Device</th>
                                    <th>IP Address</th>
                                    <th>Last Logged At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($logins)
                                    @foreach ($logins as $history_login)
                                    <tr>
                                        <td>{{ $history_login->user->username }}</td>
                                        <td>{{ $history_login->device->platform }} {{ $history_login->device->platform_version }}<br>
                                            {{ $history_login->device->browser }} ({{ $history_login->device->browser_version }})
                                        </td>
                                        <td>{{ $history_login->ip_address }}</td>
                                        <td>{{ $history_login->created_at->format('d-m-Y H:i:s') }}</td>
                                        <td>@if ($history_login->type == 'auth')
                                            <span class="badge badge-pill badge-success">Succeeded</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Failed</span>
                                        @endif</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $logins->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</main>
<!-- END Main Container -->
@endsection