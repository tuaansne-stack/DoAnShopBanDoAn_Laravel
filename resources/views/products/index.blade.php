@extends('layouts.app')

@section('title', 'Thực đơn')

@section('content')
<!-- Nội dung chính -->
<section class="menu-section py-5">
    <div class="container">
        <!-- Bộ lọc và Tìm kiếm -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">
                        <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end" id="filterForm">
                            <div class="col-md-4 col-lg-3">
                                <label for="category" class="form-label small text-muted mb-1">Danh mục</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->ten_danhmuc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 col-lg-4">
                                <label for="search" class="form-label small text-muted mb-1">Tìm kiếm</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Tìm kiếm món ăn..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="sort" class="form-label small text-muted mb-1">Sắp xếp</label>
                                <select name="sort" id="sort" class="form-select">
                                    <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Mặc định</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp → Cao</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao → Thấp</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i> Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        @if($products->count() > 0)
            <div class="row g-3 g-md-4">
                @foreach($products as $product)
                    <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                            <div class="card card-food h-100 position-relative">
                                @if($product->noibat)
                                    <span class="badge-featured">Nổi bật</span>
                                @endif
                                <img src="{{ asset('storage/uploads/' . ($product->display_image ?: 'default-food.png')) }}" 
                                    class="card-img-top" 
                                    alt="{{ $product->tenmon }}"
                                    loading="lazy"
                                    decoding="async">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->tenmon }}</h5>
                                    <p class="small text-muted">{{ $product->category->ten_danhmuc ?? '' }}</p>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="price">{{ format_currency($product->gia) }}</span>
                                        @if(!empty($product->giacu))
                                            <span class="old-price">{{ format_currency($product->giacu) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <button class="btn btn-sm btn-gradient w-100 add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();">
                                        <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Phân trang -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="{{ asset('assets/images/no-results.png') }}" alt="Không tìm thấy" class="mb-3" style="max-width: 200px;">
                <h4>Không tìm thấy món ăn nào</h4>
                <p class="text-muted">Vui lòng thử lại với từ khóa hoặc danh mục khác.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Xem tất cả món ăn</a>
            </div>
        @endif
    </div>
</section>

@endsection

