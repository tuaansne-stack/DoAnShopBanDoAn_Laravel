@extends('admin.layouts.app')

@section('title', 'Quản lý món ăn')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý món ăn</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-pink">
        <i class="fas fa-plus me-1"></i> Thêm món ăn mới
    </a>
</div>

<!-- Search & Filter -->
<div class="card">
    <div class="card-body py-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" name="search" class="form-control" placeholder="Tên món ăn..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Danh mục</label>
                <select name="category" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->ten_danhmuc }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-pink w-100">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header">
        <span>Danh sách món ăn</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">STT</th>
                        <th style="width: 70px;">Hình Ảnh</th>
                        <th>Tên Món</th>
                        <th>Danh Mục</th>
                        <th>Giá (đ)</th>
                        <th style="width: 120px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $products->firstItem() + $index }}</td>
                            <td>
                                @if($product->display_image)
                                    <img src="/storage/uploads/{{ $product->display_image }}" alt="{{ $product->tenmon }}" class="product-img">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->tenmon }}</td>
                            <td>{{ $product->category->ten_danhmuc ?? 'N/A' }}</td>
                            <td>{{ number_format($product->gia, 0, ',', '.') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-action-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-action-view" target="_blank" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa món ăn này?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action-delete" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Không có món ăn nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
        <div class="card-footer bg-white">
            {{ $products->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection
