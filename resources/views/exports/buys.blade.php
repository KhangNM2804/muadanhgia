<table>
    <thead>
    <tr>
        <th rowspan="2">ID</th>
        <th rowspan="2">Username</th>
        <th rowspan="2">Email</th>
        <th rowspan="2">Phone</th>
        <th rowspan="2">Tổng tiền mua</th>
        <th colspan="2">Lịch sử mua</th>
    </tr>
    <tr>
        <th>Ngày giao dịch</th>
        <th>Đơn hàng</th>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá tiền 1 sản phẩm</th>
        <th>Tổng tiền đơn hàng</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        @php ($first = true) @endphp
        @foreach($user->historybuy as $historybuy)
            <tr>
            @if($first == true)
                <td rowspan="{{$user->historybuy->count()}}"> {{$user->id}} </td>
                <td rowspan="{{$user->historybuy->count()}}"> {{$user->username}} </td>
                <td rowspan="{{$user->historybuy->count()}}"> {{$user->email}} </td>
                <td rowspan="{{$user->historybuy->count()}}"> {{$user->phone}} </td>
                <td rowspan="{{$user->historybuy->count()}}"> {{$user->historybuy->sum('total_price')}} </td>
                @php ($first = false) @endphp
            @endif
                <td> {{ $historybuy->created_at->format("H:i:s d/m/Y") }} </td>
                <td> {{ $historybuy->id }} </td>
                <td> {{ optional($historybuy->gettype)->name }} </td>
                <td> {{ $historybuy->quantity }} </td>
                <td> {{ $historybuy->price }} </td>
                <td> {{ $historybuy->total_price }} </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>