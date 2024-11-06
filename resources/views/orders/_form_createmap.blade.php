<div class="row">
    <div class="col-8">
        <button type="submit" class="btn btn-primary">Vui lòng liên hệ admin</button>

    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>
