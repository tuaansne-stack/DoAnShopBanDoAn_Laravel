@extends('admin.layouts.app')

@section('title', 'Chi tiết danh mục')

@push('styles')
<style>
    .category-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        color: #fff;
        padding: 25px;
        margin-bottom: 20px;
    }
    
    .category-header-card .category-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }
    
    .category-header-card h2 {
        margin: 0;
        font-weight: 700;
    }
    
    .category-stats {
        display: flex;
        gap: 30px;
        margin-top: 15px;
    }
    
    .category-stats .stat-item {
        text-align: center;
    }
    
    .category-stats .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .category-stats .stat-label {
        font-size: 0.8rem;
        opacity: 0.8;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 15px;
    }
    
    .product-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.12);
    }
    
    .product-card .product-image {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: #f5f5f5;
    }
    
    .product-card .product-placeholder {
        width: 100%;
        height: 140px;
        background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ccc;
        font-size: 2rem;
    }
    
    .product-card .product-body {
        padding: 15px;
    }
    
    .product-card .product-name {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 8px;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-card .product-price {
        color: var(--primary-pink);
        font-weight: 700;
        font-size: 1rem;
    }
    
    .product-card .product-price .old-price {
        color: #999;
        text-decoration: line-through;
        font-size: 0.8rem;
        font-weight: 400;
        margin-left: 5px;
    }
    
    .product-card .product-footer {
        padding: 10px 15px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .product-card .product-status {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
    }
    
    .product-card .product-status.active {
        background: #e8f5e9;
        color: #388e3c;
    }
    
    .product-card .product-status.inactive {
        background: #ffebee;
        color: #e53935;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #888;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    
    .empty-state h5 {
        color: #666;
        margin-bottom: 10px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .category-header-card {
            padding: 20px;
        }
        
        .category-header-card .d-flex {
            flex-direction: column;
            text-align: center;
        }
        
        .category-header-card .category-icon {
            margin: 0 auto 15px;
        }
        
        .category-stats {
            justify-content: center;
        }
        
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 10px;
        }
        
        .product-card .product-image,
        .product-card .product-placeholder {
            height: 100px;
        }
        
        .product-card .product-body {
            padding: 10px;
        }
        
        .product-card .product-name {
            font-size: 0.85rem;
        }
        
        .product-card .product-price {
            font-size: 0.9rem;
        }
        
        .product-card .product-footer {
            padding: 8px 10px;
            flex-direction: column;
            gap: 8px;
        }
    }
    
    @media (max-width: 576px) {
        .category-header-card h2 {
            font-size: 1.3rem;
        }
        
        .category-stats {
            gap: 20px;
        }
        
        .category-stats .stat-value {
            font-size: 1.2rem;
        }
        
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Chi tiết danh mục: {{ $category->ten_danhmuc }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-pink">
            <i class="fas fa-edit me-1"></i> Chỉnh sửa
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-pink">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>
</div>

<!-- Products Section -->
<div class="card">
    <div class="card-header">
        <span><i class="fas fa-utensils me-2"></i>Danh sách món ăn ({{ $category->products->count() }})</span>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-pink">
            <i class="fas fa-plus me-1"></i> Thêm món
        </a>
    </div>
    <div class="card-body">
        @if($category->products->count() > 0)
            <div class="product-grid">
                @foreach($category->products as $product)
                    <div class="product-card">
                        @if($product->display_image)
                            <img src="{{ asset('storage/uploads/' . $product->display_image) }}" 
                                 alt="{{ $product->tenmon }}" 
                                 class="product-image">
                        @else
                            <div class="product-placeholder">
                                <i class="fas fa-utensils"></i>
                            </div>
                        @endif
                        
                        <div class="product-body">
                            <div class="product-name">{{ $product->tenmon }}</div>
                            <div class="product-price">
                                {{ number_format($product->gia, 0, ',', '.') }}đ
                                @if($product->giacu && $product->giacu > $product->gia)
                                    <span class="old-price">{{ number_format($product->giacu, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="product-footer">
                            <span class="product-status {{ $product->trangthai == 'Đang bán' ? 'active' : 'inactive' }}">
                                {{ $product->trangthai }}
                            </span>
                            <div class="action-btns">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-action-edit" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-action-view" target="_blank" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h5>Chưa có món ăn nào</h5>
                <p class="mb-3">Danh mục này chưa có món ăn. Hãy thêm món ăn mới!</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-pink">
                    <i class="fas fa-plus me-1"></i> Thêm món ăn đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
