<table>
    <thead>
    <tr>
        <th rowspan="2">ID</th>
        <th rowspan="2">Username</th>
        <th rowspan="2">Email</th>
        <th rowspan="2">Phone</th>
        <th rowspan="2">Tổng nạp</th>
        <th colspan="2">Lịch sử nạp</th>
    </tr>
    <tr>
        <th>Ngày giao dịch</th>
        <th>Mã giao dịch</th>
        <th>Số tiền</th>
        <th>Nội dung</th>
        <th>Phương thức nạp tiền</th>
        <th>Admin xử lý giao dịch</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        @php ($first = true) @endphp
        @foreach($user->historybank as $historybank)
            <tr>
            @if($first == true)
                <td rowspan="{{$user->historybank->count()}}"> {{$user->id}} </td>
                <td rowspan="{{$user->historybank->count()}}"> {{$user->username}} </td>
                <td rowspan="{{$user->historybank->count()}}"> {{$user->email}} </td>
                <td rowspan="{{$user->historybank->count()}}"> {{$user->phone}} </td>
                <td rowspan="{{$user->historybank->count()}}"> {{$user->historybank->sum('coin')}} </td>
                @php ($first = false) @endphp
            @endif
                <td> {{ $historybank->created_at->format("H:i:s d/m/Y") }} </td>
                <td> {{ $historybank->trans_id }} </td>
                <td> {{ $historybank->coin }} </td>
                <td> {{ $historybank->memo }} </td>
                <td> {{ $historybank->type }} </td>
                <td> {{ optional($historybank->getadmin)->username }} </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>