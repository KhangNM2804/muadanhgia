<div class="row">
    <div class="col-8">
        <form class="pb-3" action="{{ route('orders.store', ['path' => 'review_images']) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- Link to Google Maps -->
            <div class="form-group">
                <label for="link" class="text-primary">Điền link chia sẻ bản đồ từ App Google Maps:</label>
                <input type="url" id="link" name="link" class="form-control form-control-sm"
                    placeholder="Điền link chia sẻ có, ví dụ: https://maps.app.goo.gl/..." value="{{ old('link') }}">
                @error('link')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Content List -->
            <div class="form-group">
                <label for="content" class="text-primary">Danh sách nội dung nhận xét địa điểm:</label>
                <textarea id="content" name="content" class="form-control form-control-sm" rows="4"
                    placeholder="Nhập danh sách nhận xét địa điểm - tối đa 500 kí tự (hãy xuống dòng để ngăn cách các nhận xét)">{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="text-center">
                <span class="badge badge-warning">Số lượng từ khoá: <span id="content_count">0</span></span>
                <p class="text-danger font-weight-bold mt-2">Chú ý từ khoá trên khi tìm kiếm cần xuất hiện Maps của bạn
                </p>
                <p class="text-danger">Hệ thống phân bổ lượt truy cập rải đều lên danh sách từ khoá trên để tạo sự tự
                    nhiên cho Maps của bạn</p>
            </div>
            <!-- Image Upload -->
            <div class="form-group">
                <label class="text-primary">Đính kèm ảnh:</label>
                <input type="file" id="images" name="images[]" class="form-control-file" accept="image/*" multiple
                    onchange="previewImages()">
                <div id="image-preview" class="d-flex flex-wrap mt-3"></div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="note" class="text-primary">Ghi chú:</label>
                <textarea id="note" name="note" class="form-control form-control-sm" rows="2"
                    placeholder="Nhập ghi chú (không bắt buộc)">{{ old('note') }}</textarea>
            </div>
            <div class="form-group">
                <input type="hidden" id="price" name="price" class="form-control form-control-sm"
                    value="{{ $type[1]->price }}">
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
        @include('orders._note_order', ['description' => $type[1]->description])
    </div>
</div>
<!-- JavaScript to Preview Images and Delete -->
<script>
    function previewImages() {
        const preview = $('#image-preview');
        preview.empty(); // Clear existing previews
        const files = $('#images')[0].files;
        $.each(files, (index, file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgContainer = $('<div>', {
                    class: 'm-2',
                    css: {
                        position: 'relative',
                        width: 'calc(25% - 16px)',
                        flexBasis: '25%'
                    }
                });

                const img = $('<img>', {
                    src: e.target.result,
                    class: 'img-thumbnail',
                    css: {
                        width: '100%',
                        height: 'auto'
                    }
                });

                const deleteBtn = $('<button>', {
                    text: 'X',
                    class: 'btn btn-danger btn-sm',
                    css: {
                        position: 'absolute',
                        top: '5px',
                        right: '5px'
                    },
                    click: function() {
                        imgContainer.remove();
                        updateFileList(file);
                    }
                });

                imgContainer.append(img).append(deleteBtn);
                preview.append(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }

    function updateFileList(fileToRemove) {
        const input = $('#images')[0];
        const files = Array.from(input.files);

        // Create a new DataTransfer object
        const dataTransfer = new DataTransfer();

        // Add all files except the one to remove
        files.forEach(file => {
            if (file !== fileToRemove) {
                dataTransfer.items.add(file);
            }
        });

        // Update the input with the new FileList
        input.files = dataTransfer.files;
    }

    function updateContentAndTotalPrice() {
        // Count non-empty lines in content textarea
        let contentCount = $('#content').val().split('\n').filter(line => $.trim(line) !== "").length;
        console.log(contentCount);
        $('#content_count').text(contentCount);
        // Calculate total price
        let price = parseFloat($('#price').val()) || 0;
        let totalMoney = price * contentCount;
        $('#total_money').val(totalMoney);
        $('#total_price').text(totalMoney >= 0 ? totalMoney.toLocaleString('vi-VN') + 'đ' : 'Không hợp lệ');
    }

    $(document).ready(function() {
        // Run the update function once on page load
        updateContentAndTotalPrice();
        // Attach the function to input events
        $('#content').on('input', updateContentAndTotalPrice);
    });
</script>
