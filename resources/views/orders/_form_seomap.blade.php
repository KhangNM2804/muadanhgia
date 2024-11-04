<div class="row">
    <div class="col-8">
        <form class="pb-3" action="#" method="POST">
            <!-- Link chia sẻ bản đồ -->
            <div class="form-group">
                <label for="map_link" class="text-primary font-weight-bold">Điền link chia sẻ bản đồ</label>
                <input type="url" id="map_link" name="map_link" class="form-control form-control-sm "
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..." required>
            </div>

            <!-- Danh sách từ khoá -->
            <div class="form-group">
                <label for="keyword_list" class="text-primary font-weight-bold">Danh sách từ khoá</label>
                <textarea id="keyword_list" name="keyword_list" class="form-control form-control-sm " rows="4"
                    placeholder="Nhập danh sách từ khoá tìm kiếm (hãy xuống dòng để ngăn cách các từ khoá)" required></textarea>
                <small class="form-text text-muted">Số lượng từ khoá: <span id="keyword_count">0</span></small>
            </div>

            <!-- Chú ý -->
            <div class="text-center">
                <span class="badge badge-warning">Số lượng từ khoá: <span id="keyword_count_display">0</span></span>
                <p class="text-danger font-weight-bold mt-2">Chú ý từ khoá trên khi tìm kiếm cần xuất hiện Maps của bạn
                </p>
                <p class="text-danger">Hệ thống phân bổ lượt truy cập rải đều lên danh sách từ khoá trên để tạo sự tự
                    nhiên cho Maps của bạn</p>
            </div>

            <!-- Tổng số lượt cần chạy -->
            <div class="form-group">
                <label for="total_runs" class="text-primary font-weight-bold">Tổng số lượt cần chạy (đề xuất
                    1000):</label>
                <input type="number" id="total_runs" name="total_runs" class="form-control form-control-sm "
                    value="1000" min="1" required>
            </div>

            <!-- Số ngày chạy -->
            <div class="form-group">
                <label for="days_run" class="text-primary font-weight-bold">Chạy trong bao nhiêu ngày (đề xuất
                    30):</label>
                <input type="number" id="days_run" name="days_run" class="form-control form-control-sm "
                    value="30" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Tạo đơn</button>
        </form>
    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>

<script>
    // JavaScript to update keyword count
    document.getElementById('keyword_list').addEventListener('input', function() {
        let keywordCount = this.value.split('\n').filter(line => line.trim() !== "").length;
        document.getElementById('keyword_count').textContent = keywordCount;
        document.getElementById('keyword_count_display').textContent = keywordCount;
    });
</script>
