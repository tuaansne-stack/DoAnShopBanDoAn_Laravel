@extends('admin.layouts.app')

@section('title', 'Quản lý món ăn')

@push('styles')
<style>
    /* Image gallery styles */
    .image-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .image-item {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #ddd;
        transition: all 0.3s;
    }
    
    .image-item.is-main {
        border-color: var(--primary-pink);
        box-shadow: 0 0 0 2px rgba(233, 30, 99, 0.3);
    }
    
    .image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-item .image-actions {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .image-item:hover .image-actions {
        opacity: 1;
    }
    
    .image-actions .btn {
        width: 28px;
        height: 28px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
    
    .main-badge {
        position: absolute;
        bottom: 5px;
        left: 5px;
        background: var(--primary-pink);
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
    }
    
    /* Preview images for new uploads */
    .preview-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .preview-item {
        position: relative;
        width: 80px;
        height: 80px;
        border-radius: 6px;
        overflow: hidden;
        border: 2px solid #e0e0e0;
    }
    
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .preview-item .remove-preview {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 20px;
        height: 20px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $product ? 'Chỉnh sửa món ăn' : 'Thêm món ăn mới' }}</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-pink">
        <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<form method="POST" action="{{ $product ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
    @csrf
    @if($product)
        @method('PUT')
    @endif
    
    <div class="card">
        <div class="card-header">
            <span>{{ $product ? 'Chỉnh sửa thông tin món ăn' : 'Thông tin món ăn mới' }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="tenmon" class="form-label">Tên món ăn <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tenmon') is-invalid @enderror" 
                               id="tenmon" name="tenmon" value="{{ old('tenmon', $product->tenmon ?? '') }}" required>
                        @error('tenmon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gia" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('gia') is-invalid @enderror" 
                                       id="gia" name="gia" value="{{ old('gia', $product->gia ?? '') }}" min="0" required>
                                @error('gia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="giacu" class="form-label">Giá cũ (VNĐ)</label>
                                <input type="number" class="form-control" id="giacu" name="giacu" 
                                       value="{{ old('giacu', $product->giacu ?? '') }}" min="0">
                                <small class="text-muted">Để trống nếu không có giảm giá</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="danhmuc_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('danhmuc_id') is-invalid @enderror" id="danhmuc_id" name="danhmuc_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('danhmuc_id', $product->danhmuc_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->ten_danhmuc }}
                                </option>
                            @endforeach
                        </select>
                        @error('danhmuc_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Topping Selection -->
                    @if(isset($toppings) && $toppings->count() > 0)
                    <div class="mb-3">
                        <label class="form-label">Topping <small class="text-muted">(chọn các topping áp dụng cho món này)</small></label>
                        <div class="row">
                            @php
                                $selectedToppings = old('toppings', $product ? $product->toppings->pluck('id')->toArray() : []);
                            @endphp
                            @foreach($toppings as $topping)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check topping-item">
                                        <input class="form-check-input" type="checkbox" 
                                               name="toppings[]" 
                                               value="{{ $topping->id }}" 
                                               id="topping_{{ $topping->id }}"
                                               {{ in_array($topping->id, $selectedToppings) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center" for="topping_{{ $topping->id }}">
                                            @if($topping->hinhanh)
                                                <img src="/storage/uploads/{{ $topping->hinhanh }}" alt="" 
                                                     style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px; margin-right: 8px;">
                                            @endif
                                            <span>{{ $topping->tentopping }} <small class="text-danger">(+{{ number_format($topping->gia) }}đ)</small></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="mota" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mota') is-invalid @enderror" 
                                  id="mota" name="mota" rows="10">{{ old('mota', $product->mota ?? '') }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Multiple Images Upload -->
                    <div class="mb-4">
                        <label class="form-label">Hình ảnh sản phẩm</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                               id="images" name="images[]" accept="image/*" multiple>
                        <small class="text-muted d-block mt-1">Có thể chọn nhiều ảnh cùng lúc (Ctrl+Click)</small>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview new images -->
                        <div id="previewGallery" class="preview-gallery"></div>
                    </div>
                    
                    <!-- Existing Images -->
                    @if($product && $product->images->count() > 0)
                        <div class="mb-4">
                            <label class="form-label">Hình ảnh hiện tại</label>
                            <div class="image-gallery">
                                @foreach($product->images as $image)
                                    <div class="image-item {{ $image->is_main ? 'is-main' : '' }}" data-id="{{ $image->id }}">
                                        <img src="/storage/uploads/{{ $image->hinhanh }}" alt="Product Image">
                                        @if($image->is_main)
                                            <span class="main-badge">Chính</span>
                                        @endif
                                        <div class="image-actions">
                                            <button type="button" class="btn btn-light btn-sm set-main-btn" 
                                                    data-id="{{ $image->id }}" title="Đặt làm ảnh chính">
                                                <i class="fas fa-star"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-image-btn" 
                                                    data-id="{{ $image->id }}" title="Xóa ảnh">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="main_image_id" id="mainImageId" value="{{ $product->images->where('is_main', true)->first()->id ?? '' }}">
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="trangthai" class="form-label">Trạng thái</label>
                        <select class="form-select" id="trangthai" name="trangthai">
                            <option value="Đang bán" {{ old('trangthai', $product->trangthai ?? 'Đang bán') == 'Đang bán' ? 'selected' : '' }}>Đang bán</option>
                            <option value="Ngừng bán" {{ old('trangthai', $product->trangthai ?? '') == 'Ngừng bán' ? 'selected' : '' }}>Ngừng bán</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="noibat" name="noibat" 
                                   {{ old('noibat', $product->noibat ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="noibat">
                                <i class="fas fa-star text-warning me-1"></i> Sản phẩm nổi bật
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">
                <i class="fas fa-redo me-1"></i> Reset
            </button>
            <button type="submit" class="btn btn-pink">
                <i class="fas fa-save me-1"></i> {{ $product ? 'Cập nhật' : 'Lưu' }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/3x1u6zvyi6kvo582cfkmjx31d2yy48cbgkyr6mfk0lttmwfq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '#mota',
        height: 350,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic forecolor backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family: Nunito, sans-serif; font-size: 14px; }',
        language: 'vi',
        branding: false,
        promotion: false
    });
    
    // Preview new images before upload
    document.getElementById('images').addEventListener('change', function(e) {
        const previewGallery = document.getElementById('previewGallery');
        previewGallery.innerHTML = '';
        
        if (this.files) {
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                    `;
                    previewGallery.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        }
    });
    
    // Set main image
    document.querySelectorAll('.set-main-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const imageId = this.dataset.id;
            
            // Update visual state
            document.querySelectorAll('.image-item').forEach(item => {
                item.classList.remove('is-main');
                item.querySelector('.main-badge')?.remove();
            });
            
            const imageItem = this.closest('.image-item');
            imageItem.classList.add('is-main');
            const badge = document.createElement('span');
            badge.className = 'main-badge';
            badge.textContent = 'Chính';
            imageItem.appendChild(badge);
            
            // Update hidden input
            document.getElementById('mainImageId').value = imageId;
        });
    });
    
    // Delete image
    document.querySelectorAll('.delete-image-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const imageId = this.dataset.id;
            const imageItem = this.closest('.image-item');
            
            showConfirm('Bạn có chắc muốn xóa hình ảnh này?', function() {
                fetch(`{{ url('/admin/products/images') }}/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        imageItem.remove();
                    } else {
                        showToast('Có lỗi xảy ra khi xóa hình ảnh', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra khi xóa hình ảnh', 'error');
                });
            });
        });
    });
    
    // Sync TinyMCE content before form submit
    document.getElementById('productForm').addEventListener('submit', function() {
        tinymce.triggerSave();
    });
</script>
@endpush
