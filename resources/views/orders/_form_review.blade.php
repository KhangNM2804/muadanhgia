<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-review-5s-tab" data-toggle="pill" href="#pills-review-5s" role="tab"
            aria-controls="pills-review-5s" aria-selected="true">Đánh giá 5 sao</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-review-images-tab" data-toggle="pill" href="#pills-review-images" role="tab"
            aria-controls="pills-review-images" aria-selected="false">Đánh giá kèm ảnh</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-review-5s" role="tabpanel" aria-labelledby="pills-review-5s-tab">
        @include('orders._form_review_5s')
    </div>
    <div class="tab-pane fade" id="pills-review-images" role="tabpanel" aria-labelledby="pills-review-images-tab">
        @include('orders._form_review_images')
    </div>
</div>
