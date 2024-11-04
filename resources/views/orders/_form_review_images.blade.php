<div class="row">
    <div class="col-8">
        <form class="pb-3" action="{{ route('orders.store', ['path' => $type[1]->path]) }}" method="POST"
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
                <small class="form-text text-muted">Số lượng nội dung: <span id="content_count">0</span></small>
            </div>

            <!-- Image Upload -->
            <div class="form-group">
                <label class="text-primary">Đính kèm ảnh:</label>
                <input type="file" id="images" name="images" class="form-control-file" accept="image/*" multiple
                    onchange="previewImages()">
                <div id="image-preview" class="d-flex flex-wrap mt-3"></div>
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
        @include('orders._note_order', ['description' => $type[1]->description])
    </div>
</div>
<!-- JavaScript to Preview Images and Delete -->
<script>
    function previewImages() {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = ''; // Clear existing previews
        const files = document.getElementById('images').files;

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'm-2';
                imgContainer.style.position = 'relative';
                imgContainer.style.width = 'calc(25% - 16px)'; // Max 4 images per row
                imgContainer.style.flexBasis = '25%';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100%';
                img.style.height = 'auto';

                const deleteBtn = document.createElement('button');
                deleteBtn.textContent = 'X';
                deleteBtn.className = 'btn btn-danger btn-sm';
                deleteBtn.style.position = 'absolute';
                deleteBtn.style.top = '5px';
                deleteBtn.style.right = '5px';
                deleteBtn.onclick = function() {
                    imgContainer.remove();
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(deleteBtn);
                preview.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
