<div class="row">
    <div class="col-8">
        <form class="pb-3" action="{{ route('orders.store', ['path' => $type[0]->path]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="link" class="text-primary">Điền link chia sẻ bản đồ từ App Google Maps:</label>
                <input type="url" id="link" name="link" class="form-control form-control-sm"
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..." value="{{ old('link') }}">
                @error('link')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Total Reviews Needed -->
            <div class="form-group">
                <label for="total_quantity" class="text-primary">Tổng số review cần chạy:</label>
                <input min="1" type="number" id="total_quantity" name="total_quantity"
                    class="form-control form-control-sm" value="{{ old('total_quantity', 3) }}">
                @error('total_quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Reviews Per Day -->
            <div class="form-group">
                <label for="quantity_run" class="text-primary">Review cần chạy mỗi ngày (Tối thiểu 3):</label>
                <input type="number" id="quantity_run" name="quantity_run" class="form-control form-control-sm"
                    value="{{ old('quantity_run', 3) }}">
                @error('quantity_run')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Review Content List -->
            <div class="form-group">
                <label for="content" class="text-primary">Danh sách nội dung nhận xét địa điểm:</label>
                <textarea id="content" name="content" class="form-control form-control-sm" rows="4"
                    placeholder="Nhập danh sách nhận xét địa điểm - tối đa 250 kí tự (hãy xuống dòng để ngăn cách các nhận xét)">{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Số lượng nội dung: <span id="content_count">0</span></small>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="note" class="text-primary">Ghi chú:</label>
                <textarea id="note" name="note" class="form-control form-control-sm" rows="2"
                    placeholder="Nhập ghi chú (không bắt buộc)">{{ old('note') }}</textarea>
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
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-block">Tạo đơn</button>
        </form>
    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateContentAndTotalPrice() {
        // Count non-empty lines in content textarea
        let contentCount = $('#content').val().split('\n').filter(line => $.trim(line) !== "").length;
        $('#content_count').text(contentCount);
        // Calculate total price
        let price = parseFloat($('#price').val()) || 0;
        let totalQuantity = parseInt($('#total_quantity').val()) || 0;
        let totalMoney = price * totalQuantity;
        $('#total_money').val(totalMoney);
        $('#total_price').text(totalMoney > 0 ? totalMoney.toLocaleString('vi-VN') + 'đ' : 'Không hợp lệ');
    }

    $(document).ready(function() {
        // Run the update function once on page load
        updateContentAndTotalPrice();

        // Attach the function to input events
        $('#content, #total_quantity').on('input', updateContentAndTotalPrice);
    });
</script>
