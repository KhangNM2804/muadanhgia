<div class="row ">
    <div class="col-8 ">
        <form action="{{ route('orders.store', ['path' => $type[0]->path]) }}" method="POST">
            @csrf
            <!-- Link chia sẻ bài đánh giá -->
            <div class="form-group">
                <label for="link" class="text-primary font-weight-bold">Điền link chia sẻ bài đánh giá muốn tố
                    cáo:</label>
                <input type="url" id="link" name="link" class="form-control form-control-sm"
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..."
                    value="{{ old('link', '') }}">
                @error('link')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tổng số lượt tố cáo cần chạy -->
            <div class="form-group">
                <label for="total_quantity" class="text-primary font-weight-bold">Tổng số lượt tố cáo cần chạy:</label>
                <input type="number" id="total_quantity" name="total_quantity" class="form-control form-control-sm"
                    placeholder="Nhập số đánh giá mỗi ngày" min="1" value="{{ old('total_quantity', 1) }}">
                @error('total_quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Lý do báo cáo -->
            <div class="form-group">
                <label class="text-primary font-weight-bold">Lý do báo cáo:</label>
                <div class="d-flex flex-wrap">
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason1" name="content" value="Lạc đề" class="custom-control-input"
                            {{ old('content') == 'Lạc đề' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason1">Lạc đề</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason2" name="content" value="Spam" class="custom-control-input"
                            {{ old('content') == 'Spam' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason2">Spam</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason3" name="content" value="Xung đột lợi ích"
                            class="custom-control-input" {{ old('content') == 'Xung đột lợi ích' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason3">Xung đột lợi ích</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason4" name="content" value="Thô tục - Chửi thề"
                            class="custom-control-input" {{ old('content') == 'Thô tục - Chửi thề' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason4">Thô tục - Chửi thề</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason5" name="content" value="Bắt nạt hoặc quấy rối"
                            class="custom-control-input"
                            {{ old('content') == 'Bắt nạt hoặc quấy rối' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason5">Bắt nạt hoặc quấy rối</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason6" name="content"
                            value="Lời nói phân biệt đối xử hoặc căm thù" class="custom-control-input"
                            {{ old('content') == 'Lời nói phân biệt đối xử hoặc căm thù' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason6">Lời nói phân biệt đối xử hoặc căm thù</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason7" name="content" value="Thông tin cá nhân"
                            class="custom-control-input" {{ old('content') == 'Thông tin cá nhân' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason7">Thông tin cá nhân</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason8" name="content" value="Không hữu ích"
                            class="custom-control-input" {{ old('content') == 'Không hữu ích' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="reason8">Không hữu ích</label>
                    </div>
                </div>
                @error('content')
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
            <!-- Ghi chú -->
            <div class="form-group">
                <label for="note" class="text-primary font-weight-bold">Ghi chú:</label>
                <textarea id="note" name="note" class="form-control form-control-sm" rows="2"
                    placeholder="Nhập ghi chú (không bắt buộc)"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Tạo đơn</button>
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
