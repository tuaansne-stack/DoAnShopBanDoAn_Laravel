@extends('admin.layouts.app')

@section('title', $about ? 'Sửa giới thiệu' : 'Thêm giới thiệu')

@push('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .form-header {
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .form-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }
    
    .form-body {
        padding: 25px;
    }
    
    .form-section {
        margin-bottom: 25px;
    }
    
    .form-section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
    }
    
    .form-group label .required {
        color: #e91e63;
    }
    
    .form-control, .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #e91e63;
        box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 5px;
    }
    
    .editor-container {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .editor-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 10px;
        background: #f8f8f8;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .editor-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #555;
        transition: all 0.2s;
    }
    
    .editor-btn:hover {
        background: #e91e63;
        color: #fff;
    }
    
    .editor-textarea {
        width: 100%;
        min-height: 300px;
        padding: 15px;
        border: none;
        font-size: 0.9rem;
        resize: vertical;
    }
    
    .editor-textarea:focus {
        outline: none;
    }
    
    .image-upload-box {
        border: 2px dashed #e0e0e0;
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.2s;
        cursor: pointer;
        background: #fafafa;
    }
    
    .image-upload-box:hover {
        border-color: #e91e63;
        background: #fff5f8;
    }
    
    .image-upload-box i {
        font-size: 2.5rem;
        color: #ccc;
        margin-bottom: 10px;
    }
    
    .image-upload-box p {
        margin: 0;
        font-size: 0.85rem;
        color: #888;
    }
    
    .image-upload-box input[type="file"] {
        display: none;
    }
    
    .current-image {
        margin-bottom: 15px;
    }
    
    .current-image img {
        max-width: 100%;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .preview-image {
        margin-top: 15px;
    }
    
    .preview-image img {
        max-width: 100%;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .form-footer {
        padding: 20px 25px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .btn-cancel {
        padding: 10px 25px;
        border: 1px solid #ddd;
        background: #fff;
        color: #666;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-cancel:hover {
        background: #f5f5f5;
        color: #333;
    }
    
    .btn-save {
        padding: 10px 30px;
        border: none;
        background: linear-gradient(135deg, #e91e63, #c2185b);
        color: #fff;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-header {
            padding: 15px 20px;
        }
        
        .form-body {
            padding: 20px;
        }
        
        .form-footer {
            padding: 15px 20px;
            flex-direction: column;
        }
        
        .btn-cancel, .btn-save {
            width: 100%;
            text-align: center;
        }
        
        .row-flex {
            flex-direction: column;
        }
    }
    
    .row-flex {
        display: flex;
        gap: 25px;
    }
    
    .col-main {
        flex: 2;
    }
    
    .col-side {
        flex: 1;
        min-width: 280px;
    }
    
    @media (max-width: 992px) {
        .row-flex {
            flex-direction: column;
        }
        
        .col-side {
            min-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $about ? 'Sửa giới thiệu' : 'Thêm giới thiệu mới' }}</h1>
    <a href="{{ route('admin.about.index') }}" class="btn btn-outline-pink">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<form method="POST" action="{{ $about ? route('admin.about.update', $about->id) : route('admin.about.store') }}" enctype="multipart/form-data" id="aboutForm">
    @csrf
    @if($about) @method('PUT') @endif

    <div class="form-card">
        <div class="form-body">
            <div class="row-flex">
                <!-- Main Content -->
                <div class="col-main">
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-edit me-2"></i>Nội dung
                        </div>
                        
                        <div class="form-group">
                            <label for="tieude">
                                Tiêu đề <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('tieude') is-invalid @enderror" 
                                   id="tieude" 
                                   name="tieude" 
                                   value="{{ old('tieude', $about->tieude ?? '') }}" 
                                   placeholder="Nhập tiêu đề bài giới thiệu..."
                                   required>
                            @error('tieude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="noidung">
                                Nội dung <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('noidung') is-invalid @enderror" 
                                      id="noidung" 
                                      name="noidung" 
                                      rows="12" 
                                      placeholder="Nhập nội dung bài giới thiệu..."
                                      required>{{ old('noidung', $about->noidung ?? '') }}</textarea>
                            @error('noidung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-side">
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-cog me-2"></i>Cài đặt
                        </div>
                        
                        <div class="form-group">
                            <label for="thutu">Thứ tự hiển thị</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="thutu" 
                                   name="thutu" 
                                   value="{{ old('thutu', $about->thutu ?? 0) }}" 
                                   min="0"
                                   placeholder="0">
                            <small class="text-muted">Số nhỏ hiển thị trước</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="trangthai">Trạng thái</label>
                            <select class="form-select" id="trangthai" name="trangthai">
                                <option value="Hiện" {{ old('trangthai', $about->trangthai ?? 'Hiện') == 'Hiện' ? 'selected' : '' }}>
                                    ✓ Hiện
                                </option>
                                <option value="Ẩn" {{ old('trangthai', $about->trangthai ?? '') == 'Ẩn' ? 'selected' : '' }}>
                                    ✗ Ẩn
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-image me-2"></i>Hình ảnh
                        </div>
                        
                        @if($about && $about->hinhanh)
                            <div class="current-image">
                                <p class="text-muted mb-2" style="font-size: 0.8rem;">Ảnh hiện tại:</p>
                                <img src="/storage/uploads/{{ $about->hinhanh }}" alt="{{ $about->tieude }}">
                            </div>
                        @endif
                        
                        <label class="image-upload-box" for="hinhanh">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click để chọn ảnh</p>
                            <p style="font-size: 0.75rem; color: #aaa;">PNG, JPG tối đa 2MB</p>
                            <input type="file" id="hinhanh" name="hinhanh" accept="image/*">
                        </label>
                        
                        <div class="preview-image" id="imagePreview" style="display: none;">
                            <p class="text-muted mb-2" style="font-size: 0.8rem;">Ảnh mới:</p>
                            <img src="" alt="Preview" id="previewImg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-footer">
            <a href="{{ route('admin.about.index') }}" class="btn-cancel">
                <i class="fas fa-times me-1"></i> Hủy
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-1"></i> {{ $about ? 'Cập nhật' : 'Thêm mới' }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    var fileInput = document.getElementById('hinhanh');
    var previewContainer = document.getElementById('imagePreview');
    var previewImg = document.getElementById('previewImg');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Form validation before submit
    var form = document.getElementById('aboutForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            var tieude = document.getElementById('tieude').value.trim();
            var noidung = document.getElementById('noidung').value.trim();
            
            if (!tieude) {
                e.preventDefault();
                showToast('Vui lòng nhập tiêu đề!', 'error');
                document.getElementById('tieude').focus();
                return false;
            }
            
            if (!noidung) {
                e.preventDefault();
                showToast('Vui lòng nhập nội dung!', 'error');
                document.getElementById('noidung').focus();
                return false;
            }
        });
    }
});
</script>
@endpush
