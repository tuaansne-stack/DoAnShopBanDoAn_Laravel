@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<!-- Hero Section - Slider -->
<section class="hero-section mb-5">
    <div class="container">
        <div class="card">
            <div class="card-body p-0">
                <div class="slide-gioi-thieu">
                    <div class="slide-item">
                        <img src="{{ asset('assets/images/slider/slide1.png') }}" alt="Ẩm thực đỉnh cao tại Food Shop" class="w-100 rounded-3">
                    </div>
                    <div class="slide-item">
                        <img src="{{ asset('assets/images/slider/slide2.png') }}" alt="Ưu đãi đặc biệt tại Food Shop" class="w-100 rounded-3">
                    </div>
                    <div class="slide-item">
                        <img src="{{ asset('assets/images/slider/slide3.png') }}" alt="Miễn phí giao hàng tại Food Shop" class="w-100 rounded-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sản phẩm theo Danh mục -->
@foreach($categoriesWithProducts as $category)
    @if($category->products->count() > 0)
    <section class="category-products-section py-4">
        <div class="container">
            <!-- Category Header -->
            <div class="category-section-header d-flex justify-content-between align-items-center mb-4">
                <h3 class="category-section-title mb-0">{{ $category->ten_danhmuc }}</h3>
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="view-more-link">
                    Xem thêm <i class="fas fa-chevron-right ms-1"></i>
                </a>
            </div>
            
            <!-- Products Grid -->
            <div class="row g-3 g-md-4">
                @foreach($category->products as $product)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2">
                        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                            <div class="card card-food h-100">
                                <img src="{{ asset('storage/uploads/' . ($product->display_image ?: 'default-food.png')) }}" 
                                    class="card-img-top" 
                                    alt="{{ $product->tenmon }}"
                                    loading="lazy"
                                    decoding="async">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $product->tenmon }}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price">{{ format_currency($product->gia) }}</span>
                                        @if(!empty($product->giacu))
                                            <span class="old-price small">{{ format_currency($product->giacu) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 pt-0">
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
                                    <button class="btn btn-sm btn-gradient w-100 open-topping-sheet" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->tenmon }}"
                                            data-product-price="{{ $product->gia }}"
                                            data-product-price-formatted="{{ format_currency($product->gia) }}"
                                            data-product-image="{{ asset('storage/uploads/' . ($product->display_image ?: 'default-food.png')) }}"
                                            data-product-toppings="{{ $toppingsJson->toJson() }}"
                                            onclick="event.preventDefault(); event.stopPropagation();">
                                        <i class="fas fa-cart-plus me-1"></i> Đặt hàng
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-gradient w-100 add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();">
                                        <i class="fas fa-cart-plus me-1"></i> Đặt hàng
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach

<!-- Thông tin dịch vụ -->
<section class="services-section py-5">
    <div class="container">
        <div class="row g-2 g-md-3">
            <div class="col-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-2 mb-md-3">
                        <i class="fas fa-truck fa-3x text-gradient"></i>
                    </div>
                    <h4>Giao Hàng Nhanh Chóng</h4>
                    <p class="text-muted">Giao hàng trong vòng 30 phút với khu vực nội thành.</p>
                </div>
            </div>
            <div class="col-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-2 mb-md-3">
                        <i class="fas fa-credit-card fa-3x text-gradient"></i>
                    </div>
                    <h4>Thanh Toán An Toàn</h4>
                    <p class="text-muted">Nhiều phương thức thanh toán, bảo mật thông tin.</p>
                </div>
            </div>
            <div class="col-4">
                <div class="service-item text-center">
                    <div class="service-icon mb-2 mb-md-3">
                        <i class="fas fa-headset fa-3x text-gradient"></i>
                    </div>
                    <h4>Hỗ Trợ 24/7</h4>
                    <p class="text-muted">Đội ngũ tư vấn viên luôn sẵn sàng hỗ trợ bạn.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .category-section-header {
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--primary-color, #ff5c8d);
    }
    
    .category-section-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #333;
    }
    
    .view-more-link {
        color: var(--primary-color, #ff5c8d);
        font-weight: 500;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .view-more-link:hover {
        color: var(--gradient-end, #ff92b7);
    }
    
    .category-products-section {
        border-bottom: 1px solid #eee;
    }
    
    .category-products-section:last-of-type {
        border-bottom: none;
    }
    
    /* Smaller product cards for 6-column layout */
    .category-products-section .card-food .card-title {
        font-size: 0.9rem;
        line-height: 1.3;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .category-products-section .card-food .card-body {
        padding: 0.75rem;
    }
    
    .category-products-section .card-food .card-footer {
        padding: 0 0.75rem 0.75rem;
    }
    
    .category-products-section .card-food .price {
        font-size: 0.95rem;
    }
    
    .category-products-section .card-food .old-price {
        font-size: 0.75rem;
    }
    
    .category-products-section .card-food .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endpush
@endsection
