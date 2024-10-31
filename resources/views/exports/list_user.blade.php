<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Chiếu khấu</th>
        <th>Số dư hiện tại</th>
        <th>Quyền</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td > {{$user->id}} </td>
            <td > {{$user->username}} </td>
            <td > {{$user->email}} </td>
            <td > {{$user->phone}} </td>
            <td > {{$user->chietkhau}} %</td>
            <td > {{$user->coin}}</td>
            <td >@if ($user->role == 1)
                Admin
            @elseif($user->role == 2)
                Nhân viên
            @else
                Member
            @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>