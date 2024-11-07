<div class="row ">
    <div class="col-8">
        <form class="pb-4" action="{{ route('orders.store', ['path' => $type[0]->path]) }}" method="POST">
            @csrf
            <!-- Thông báo giá và lượt tối đa -->
            <div class="text-center mb-3">
                <p class="text-danger font-weight-bold">
                    500 VNĐ mua 1 like, bạn có thể tạo tối đa 0 lượt với 0 VNĐ hiện tại
                </p>
            </div>

            <!-- Link chia sẻ bài đánh giá -->
            <div class="form-group">
                <label for="link" class="text-primary font-weight-bold">Điền link chia sẻ bài đánh giá</label>
                <input type="url" id="link" name="link" class="form-control form-control-sm"
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..." value={{ old('link', '') }}>
                @error('link')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Lượt like cần chạy -->
            <div class="form-group">
                <label for="total_quantity" class="text-primary font-weight-bold">Lượt like cần chạy:</label>
                <input type="number" id="total_quantity" name="total_quantity" class="form-control form-control-sm"
                    placeholder="Nhập số lượng" min="1" value="{{ old('total_quantity', 1) }}">
                @error('total_quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="hidden" id="price" name="price" class="form-control form-control-sm"
                    value="{{ $type[0]->price }}">
            </div>
            <div class="form-group">
                <input type="hidden" id="total_money" name="total_money" class="form-control form-control-sm">
            </div>
            <div class="form-group">
                <div class="alert alert-success text-center" role="alert">
                    <span>Tổng tiền: </span><strong id="total_price">0</strong>
                </div>
            </div>
            <!-- Nút tạo đơn -->
            <button type="submit" class="btn btn-primary btn-block">Tạo đơn</button>
        </form>
    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>
<script>
    function updateTotalPrice() {
        let price = parseFloat($('#price').val()) || 0;
        let totalQuantity = parseInt($('#total_quantity').val()) || 0;
        let totalMoney = price * totalQuantity;
        $('#total_money').val(totalMoney);
        $('#total_price').text(totalMoney >= 0 ? totalMoney.toLocaleString('vi-VN') + 'đ' : 'Không hợp lệ');
    }
    $(document).ready(function() {
        // Run the update function once on page load
        updateTotalPrice();
        // Attach the function to input events
        $('#total_quantity').on('input', updateTotalPrice);
    });
</script>
