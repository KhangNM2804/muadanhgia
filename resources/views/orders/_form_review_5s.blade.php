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
                <input type="number" id="total_quantity" name="total_quantity" class="form-control form-control-sm"
                    value="{{ old('total_quantity', 3) }}">
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

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-block">Tạo đơn</button>
        </form>
    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>
<script>
    // JavaScript to update content count
    document.getElementById('content').addEventListener('input', function() {
        let contentCount = this.value.split('\n').filter(line => line.trim() !== "").length;
        document.getElementById('content_count').textContent = contentCount;
    });
</script>
