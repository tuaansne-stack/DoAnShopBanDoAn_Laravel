@extends('layouts.app')

@section('title', $product->tenmon)

@section('content')
<section class="product-detail py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <!-- Image -->
                    <div class="col-md-5 mb-3 mb-md-0">
                        <div class="product-image-wrap">
                            @php
                                $images = $product->images;
                                $displayImage = $product->display_image ?: 'default-food.jpg';
                            @endphp
                            
                            <img id="mainImage" src="{{ asset('storage/uploads/' . $displayImage) }}" alt="{{ $product->tenmon }}">
                            
                            @if($images->count() > 1)
                                <div class="thumb-row">
                                    @foreach($images as $index => $image)
                                        <div class="thumb-item {{ $index == 0 ? 'active' : '' }}" 
                                             onclick="selectImage({{ $index }}, '{{ asset('storage/uploads/' . $image->hinhanh) }}')">
                                            <img src="{{ asset('storage/uploads/' . $image->hinhanh) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="col-md-7">
                        <div class="product-info-box">
                            <span class="cat-badge">{{ $product->category->ten_danhmuc ?? 'Món ăn' }}</span>
                            <h1 class="prd-name">{{ $product->tenmon }}</h1>
                            
                            <div class="prd-price">
                                <span class="price-now">{{ format_currency($product->gia) }}</span>
                                @if(!empty($product->giacu))
                                    <span class="price-old">{{ format_currency($product->giacu) }}</span>
                                    <span class="price-off">-{{ round((($product->giacu - $product->gia) / $product->giacu) * 100) }}%</span>
                                @endif
                            </div>
                            
                            @if($product->toppings->count() > 0)
                            @php
                                $toppingsJson = $product->toppings->map(function($t) {
                                    return [
                                        'id' => $t->id,
                                        'name' => $t->tentopping,
                                        'price' => $t->gia,
                                        'image' => $t->hinhanh ? '/storage/uploads/' . $t->hinhanh : null
                                    ];
                                });
                            @endphp
                            <button class="btn-cart open-topping-sheet" 
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->tenmon }}"
                                    data-product-price="{{ $product->gia }}"
                                    data-product-price-formatted="{{ format_currency($product->gia) }}"
                                    data-product-image="{{ asset('storage/uploads/' . ($product->display_image ?: 'default-food.png')) }}"
                                    data-product-toppings="{{ $toppingsJson->toJson() }}">
                                <i class="fas fa-cart-plus"></i> Chọn topping & Đặt hàng
                            </button>
                            @else
                            <button class="btn-cart add-to-cart-btn" data-product-id="{{ $product->id }}" data-base-price="{{ $product->gia }}">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Tabs: Mô tả & Đánh giá -->
                <div class="prd-tabs mt-4">
                    <div class="tab-header">
                        <button class="tab-btn active" data-tab="desc">MÔ TẢ</button>
                        <button class="tab-btn" data-tab="reviews">ĐÁNH GIÁ ({{ $product->approvedComments->count() }})</button>
                    </div>
                    
                    <div class="tab-content" id="tab-desc">
                        <div class="desc-text">
                            @if($product->mota)
                                {!! $product->mota !!}
                            @else
                                <p class="text-muted">Chưa có mô tả cho sản phẩm này.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="tab-content" id="tab-reviews" style="display:none;">
                        @if($product->approvedComments->count() > 0)
                            @foreach($product->approvedComments as $review)
                                <div class="review-card">
                                    <div class="review-head">
                                        <div class="rv-avatar">{{ strtoupper(substr($review->user->hoten ?? 'U', 0, 1)) }}</div>
                                        <div class="rv-info">
                                            <span class="rv-name">{{ $review->user->hoten }}</span>
                                            <span class="rv-date">{{ $review->ngaytao->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="rv-stars ms-auto">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->danhgia ? 'on' : '' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="rv-content">
                                        <p class="rv-text">{{ $review->noidung }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Chưa có đánh giá nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related -->
        @if($relatedProducts->count() > 0)
        <div class="related-wrap mt-5">
            <h4 class="rel-title">Món ăn liên quan</h4>
            <div class="row g-3">
                @foreach($relatedProducts->take(4) as $rel)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('products.show', $rel->id) }}" class="rel-card">
                            <img src="{{ asset('storage/uploads/' . ($rel->display_image ?: 'default-food.png')) }}" alt="">
                            <h5>{{ $rel->tenmon }}</h5>
                            <span>{{ format_currency($rel->gia) }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.product-image-wrap {
    background: #f8f8f8;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
}
.product-image-wrap > img {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
    border-radius: 8px;
}
.thumb-row {
    display: flex;
    gap: 6px;
    margin-top: 10px;
    justify-content: center;
}
.thumb-item {
    width: 50px;
    height: 50px;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    opacity: 0.6;
}
.thumb-item.active {
    border-color: var(--primary-color, #ff5c8d);
    opacity: 1;
}
.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info-box {
    padding: 0 0 0 1rem;
}
.cat-badge {
    display: inline-block;
    font-size: 0.75rem;
    color: #666;
    background: #f0f0f0;
    padding: 3px 10px;
    border-radius: 15px;
    margin-bottom: 6px;
}
.prd-name {
    font-size: 1.4rem;
    font-weight: 600;
    color: #222;
    margin-bottom: 10px;
}
.prd-price {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.price-now {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-color, #ff5c8d);
}
.price-old {
    font-size: 0.9rem;
    color: #999;
    text-decoration: line-through;
}
.price-off {
    font-size: 0.7rem;
    font-weight: 600;
    color: #fff;
    background: #e53935;
    padding: 2px 6px;
    border-radius: 3px;
}

.qty-box {
    display: inline-flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 12px;
}
.qty-btn {
    width: 34px;
    height: 34px;
    border: none;
    background: #f5f5f5;
    font-size: 1rem;
    cursor: pointer;
}
.qty-num {
    width: 40px;
    height: 34px;
    border: none;
    text-align: center;
    font-size: 0.9rem;
}
.qty-num:focus { outline: none; }

.btn-cart {
    display: block;
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, var(--gradient-start, #ff5c8d), var(--gradient-end, #ff92b7));
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
}

/* Tabs */
.prd-tabs {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
}
.tab-header {
    display: flex;
    border-bottom: 1px solid #eee;
}
.tab-btn {
    flex: 1;
    padding: 12px;
    background: none;
    border: none;
    font-size: 0.85rem;
    font-weight: 500;
    color: #666;
    cursor: pointer;
    border-bottom: 2px solid transparent;
}
.tab-btn.active {
    color: var(--primary-color, #ff5c8d);
    border-bottom-color: var(--primary-color, #ff5c8d);
}
.tab-content {
    padding: 1rem;
}
.desc-text {
    font-size: 0.9rem;
    line-height: 1.7;
    color: #444;
}
.desc-text p { margin-bottom: 0.5rem; }

/* Reviews */
.review-card {
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}
.review-card:last-child { border-bottom: none; }
.review-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.rv-avatar {
    width: 36px;
    height: 36px;
    background: #e0e0e0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 600;
    color: #666;
    flex-shrink: 0;
}
.rv-info { flex: 1; }
.rv-name {
    font-size: 0.9rem;
    font-weight: 500;
    color: #333;
    display: block;
}
.rv-date {
    font-size: 0.75rem;
    color: #999;
}
.rv-stars {
    flex-shrink: 0;
}
.rv-stars i {
    font-size: 0.8rem;
    color: #ddd;
}
.rv-stars i.on { color: #ffc107; }
.rv-content {
    margin-left: 46px;
}
.rv-text {
    font-size: 0.85rem;
    color: #555;
    margin: 0;
}

/* Related */
.related-wrap {
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}
.rel-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}
.rel-card {
    display: block;
    text-decoration: none;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
}
.rel-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.rel-card img {
    width: 100%;
    height: 130px;
    object-fit: cover;
}
.rel-card h5 {
    font-size: 0.85rem;
    color: #333;
    margin: 10px 10px 6px;
    line-height: 1.35;
    height: 2.3em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.rel-card span {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--primary-color, #ff5c8d);
    margin: 0 10px 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .product-info-box { padding: 1rem 0 0; }
    .prd-name { font-size: 1.2rem; }
    .price-now { font-size: 1.15rem; }
    .rel-card img { height: 100px; }
    .rel-card h5 { font-size: 0.8rem; margin: 8px 8px 4px; }
    .rel-card span { font-size: 0.85rem; margin: 0 8px 8px; }
    .topping-item { padding: 6px 8px; }
    .topping-img { width: 28px; height: 28px; }
}

/* Topping Styles */
.topping-section {
    margin: 1rem 0;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
}
.topping-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}
.topping-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.topping-item {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    background: #fff;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.topping-item:has(.topping-checkbox:checked) {
    border-color: var(--primary-color, #ff5c8d);
    background: #fff0f5;
}
.topping-checkbox {
    width: 16px;
    height: 16px;
    accent-color: var(--primary-color, #ff5c8d);
}
.topping-img {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    object-fit: cover;
}
.topping-name {
    font-size: 0.85rem;
    color: #333;
}
.topping-price {
    font-size: 0.75rem;
    color: var(--primary-color, #ff5c8d);
    font-weight: 600;
}
.total-price-display {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px dashed #ddd;
}
.total-amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-color, #ff5c8d);
}
</style>
@endpush
@endsection

@push('scripts')
<script>
function selectImage(index, src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumb-item').forEach((t, i) => {
        t.classList.toggle('active', i === index);
    });
}

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        document.getElementById('tab-' + this.dataset.tab).style.display = 'block';
    });
});

// Bottom sheet trigger for products with toppings
document.querySelectorAll('.open-topping-sheet').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const product = {
            id: this.dataset.productId,
            name: this.dataset.productName,
            price: parseInt(this.dataset.productPrice),
            priceFormatted: this.dataset.productPriceFormatted,
            image: this.dataset.productImage,
            toppings: JSON.parse(this.dataset.productToppings || '[]')
        };
        
        if (typeof window.openToppingSheet === 'function') {
            window.openToppingSheet(product);
        }
    });
});
</script>
@endpush
