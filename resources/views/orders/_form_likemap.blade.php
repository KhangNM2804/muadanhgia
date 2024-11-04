<div class="row ">
    <div class="col-8">
        <form class="pb-4" action="#" method="POST">
            <!-- Thông báo giá và lượt tối đa -->
            <div class="text-center mb-3">
                <p class="text-danger font-weight-bold">
                    500 VNĐ mua 1 like, bạn có thể tạo tối đa 0 lượt với 0 VNĐ hiện tại
                </p>
            </div>

            <!-- Link chia sẻ bài đánh giá -->
            <div class="form-group">
                <label for="review_link" class="text-primary font-weight-bold">Điền link chia sẻ bài đánh giá</label>
                <input type="url" id="review_link" name="review_link" class="form-control form-control-sm"
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..." required>
            </div>

            <!-- Lượt like cần chạy -->
            <div class="form-group">
                <label for="like_count" class="text-primary font-weight-bold">Lượt like cần chạy:</label>
                <input type="number" id="like_count" name="like_count" class="form-control form-control-sm"
                    placeholder="Nhập số lượng" min="1" required>
            </div>

            <!-- Nút tạo đơn -->
            <button type="submit" class="btn btn-primary btn-block">Tạo đơn</button>
        </form>
    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>
