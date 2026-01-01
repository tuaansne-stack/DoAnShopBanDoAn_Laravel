@extends('admin.layouts.app')

@section('title', 'Sửa Topping')

@section('content')
<div class="page-header">
    <h1 class="page-title">Sửa Topping</h1>
    <a href="{{ route('admin.toppings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.toppings.update', $topping->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Tên topping <span class="text-danger">*</span></label>
                        <input type="text" name="tentopping" class="form-control @error('tentopping') is-invalid @enderror" 
                               value="{{ old('tentopping', $topping->tentopping) }}" placeholder="VD: Trân châu đen, Thạch dừa...">
                        @error('tentopping')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="gia" class="form-control @error('gia') is-invalid @enderror" 
                               value="{{ old('gia', $topping->gia) }}" min="0" step="1000">
                        @error('gia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="trangthai" id="trangthai" value="1" 
                                   {{ old('trangthai', $topping->trangthai) ? 'checked' : '' }}>
                            <label class="form-check-label" for="trangthai">Đang bán</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh</label>
                        @if($topping->hinhanh)
                            <div class="mb-2">
                                <img src="/storage/uploads/{{ $topping->hinhanh }}" alt="{{ $topping->tentopping }}" 
                                     style="max-width: 150px; border-radius: 8px;">
                                <p class="text-muted small mt-1">Ảnh hiện tại</p>
                            </div>
                        @endif
                        <input type="file" name="hinhanh" class="form-control @error('hinhanh') is-invalid @enderror" 
                               accept="image/*" onchange="previewImage(this)">
                        @error('hinhanh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2" id="imagePreview" style="display: none;">
                            <img src="" alt="Preview" style="max-width: 150px; border-radius: 8px;">
                            <p class="text-muted small mt-1">Ảnh mới</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-pink">
                <i class="fas fa-save me-1"></i> Cập nhật topping
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
