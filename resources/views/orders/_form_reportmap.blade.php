<div class="row ">
    <div class="col-8 ">
        <form action="#" method="POST">
            <!-- Link chia sẻ bài đánh giá -->
            <div class="form-group">
                <label for="report_link" class="text-primary font-weight-bold">Điền link chia sẻ bài đánh giá muốn tố
                    cáo:</label>
                <input type="url" id="report_link" name="report_link" class="form-control form-control-sm"
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..." required>
            </div>

            <!-- Tổng số lượt tố cáo cần chạy -->
            <div class="form-group">
                <label for="report_count" class="text-primary font-weight-bold">Tổng số lượt tố cáo cần chạy:</label>
                <input type="number" id="report_count" name="report_count" class="form-control form-control-sm"
                    placeholder="Nhập số đánh giá mỗi ngày" min="1" required>
            </div>

            <!-- Lý do báo cáo -->
            <div class="form-group">
                <label class="text-primary font-weight-bold">Lý do báo cáo:</label>
                <div class="d-flex flex-wrap">
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason1" name="report_reason" value="Lạc đề"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason1">Lạc đề</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason2" name="report_reason" value="Spam"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason2">Spam</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason3" name="report_reason" value="Xung đột lợi ích"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason3">Xung đột lợi ích</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason4" name="report_reason" value="Thô tục - Chửi thề"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason4">Thô tục - Chửi thề</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason5" name="report_reason" value="Bắt nạt hoặc quấy rối"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason5">Bắt nạt hoặc quấy rối</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason6" name="report_reason"
                            value="Lời nói phân biệt đối xử hoặc căm thù" class="custom-control-input" required>
                        <label class="custom-control-label" for="reason6">Lời nói phân biệt đối xử hoặc căm thù</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason7" name="report_reason" value="Thông tin cá nhân"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason7">Thông tin cá nhân</label>
                    </div>
                    <div class="custom-control custom-radio m-2" style="flex-basis: 30%;">
                        <input type="radio" id="reason8" name="report_reason" value="Không hữu ích"
                            class="custom-control-input" required>
                        <label class="custom-control-label" for="reason8">Không hữu ích</label>
                    </div>
                </div>
            </div>

            <!-- Ghi chú -->
            <div class="form-group">
                <label for="note" class="text-primary font-weight-bold">Ghi chú:</label>
                <textarea id="note" name="note" class="form-control form-control-sm" rows="2"
                    placeholder="Nhập ghi chú (không bắt buộc)"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block font-weight-bold">Gửi tố cáo</button>
        </form>

    </div>
    <div class="col-4">
        @include('orders._note_order', ['description' => $type[0]->description])
    </div>
</div>
