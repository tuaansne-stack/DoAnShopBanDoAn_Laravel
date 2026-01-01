@extends('layouts.app')

@section('title', 'Tìm kiếm: ' . $keyword)

@section('content')
<section class="search-results-section py-5">
    <div class="container">
        @if($products->count() > 0 || $news->count() > 0)
            @if($products->count() > 0)
                <h3 class="mb-4">Sản phẩm ({{ $products->total() }})</h3>
                <div class="row g-3 g-md-4 mb-5">
                    @foreach($products as $product)
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                                <div class="card card-food h-100">
                                    <img src="{{ asset('storage/uploads/' . ($product->display_image ?: 'default-food.png')) }}" 
                                        class="card-img-top" alt="{{ $product->tenmon }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->tenmon }}</h5>
                                        <p class="small text-muted">{{ $product->category->ten_danhmuc ?? '' }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="price">{{ format_currency($product->gia) }}</span>
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
                {{ $products->links() }}
            @endif

            @if($news->count() > 0)
                <h3 class="mb-4">Tin tức ({{ $news->total() }})</h3>
                <div class="row g-4">
                    @foreach($news as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                @if($item->hinhanh)
                                    <img src="{{ asset('storage/uploads/' . $item->hinhanh) }}" class="card-img-top" alt="{{ $item->tieude }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->tieude }}</h5>
                                    <p class="card-text text-muted small">{{ $item->tomtat ?? truncate_text(strip_tags($item->noidung), 100) }}</p>
                                </div>
                                <div class="card-footer bg-white">
                                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-sm btn-primary w-100">Đọc thêm</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $news->links() }}
            @endif
        @else
            <div class="text-center py-5">
                <img src="{{ asset('assets/images/no-results.png') }}" alt="Không tìm thấy" class="mb-3" style="max-width: 200px;">
                <h4>Không tìm thấy kết quả nào</h4>
                <p class="text-muted">Vui lòng thử lại với từ khóa khác.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
            </div>
        @endif
    </div>
</section>
@endsection

