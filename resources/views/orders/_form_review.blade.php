<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a href="{{ route('orders.create', ['path' => 'review']) }}"
            class="nav-link {{ (request()->path ?? '') == 'review' ? 'active' : '' }}" id="pills-review-images-tab"
            aria-selected="{{ (request()->path ?? '') == 'review' }}">Đánh giá 5 sao</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('orders.create', ['path' => 'review_images']) }}"
            class="nav-link {{ (request()->path ?? '') == 'review_images' ? 'active' : '' }}"
            id="pills-review-images-tab" aria-selected="{{ (request()->path ?? '') == 'review_images' }}">Đánh
            giá kèm ảnh</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active">
        @if (request()->path == 'review')
            @include('orders._form_review_5s')
        @elseif(request()->path == 'review_images')
            @include('orders._form_review_images')
        @endif
    </div>
</div>
