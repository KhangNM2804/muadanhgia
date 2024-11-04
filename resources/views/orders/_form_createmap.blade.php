<div class="col-8">
    <form action="{{ route('orders.store', ['path' => $type[0]->path]) }}" method="POST">
        @csrf
        <div class="form-group-sm">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group-sm">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control form-control-sm" type="text" placeholder=".form-control-sm">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<div class="col-4">
    @include('orders._note_order.blade', ['type' => $type])
</div>
