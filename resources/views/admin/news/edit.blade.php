@extends('admin.layouts.app')

@section('title', $news ? 'Sửa tin tức' : 'Thêm tin tức')

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
    
    /* Two Column Layout */
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
    
    /* Responsive */
    @media (max-width: 992px) {
        .row-flex {
            flex-direction: column;
        }
        
        .col-side {
            min-width: 100%;
        }
    }
    
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
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $news ? 'Sửa tin tức' : 'Thêm tin tức mới' }}</h1>
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-pink">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<form method="POST" action="{{ $news ? route('admin.news.update', $news->id) : route('admin.news.store') }}" enctype="multipart/form-data" id="newsForm">
    @csrf
    @if($news) @method('PUT') @endif

    <div class="form-card">
        <div class="form-body">
            <div class="row-flex">
                <!-- Main Content -->
                <div class="col-main">
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-edit me-2"></i>Nội dung tin tức
                        </div>
                        
                        <div class="form-group">
                            <label for="tieude">
                                Tiêu đề <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('tieude') is-invalid @enderror" 
                                   id="tieude" 
                                   name="tieude" 
                                   value="{{ old('tieude', $news->tieude ?? '') }}" 
                                   placeholder="Nhập tiêu đề bài viết..."
                                   required>
                            @error('tieude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tomtat">Tóm tắt</label>
                            <textarea class="form-control" 
                                      id="tomtat" 
                                      name="tomtat" 
                                      rows="3" 
                                      placeholder="Nhập tóm tắt ngắn gọn về bài viết...">{{ old('tomtat', $news->tomtat ?? '') }}</textarea>
                            <small class="text-muted">Tóm tắt sẽ hiển thị ở trang danh sách tin tức</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="noidung">
                                Nội dung <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('noidung') is-invalid @enderror" 
                                      id="noidung" 
                                      name="noidung" 
                                      rows="12" 
                                      placeholder="Nhập nội dung bài viết...">{{ old('noidung', $news->noidung ?? '') }}</textarea>
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
                            <label for="trangthai">Trạng thái</label>
                            <select class="form-select" id="trangthai" name="trangthai">
                                <option value="Công khai" {{ old('trangthai', $news->trangthai ?? 'Công khai') == 'Công khai' ? 'selected' : '' }}>
                                    ✓ Công khai
                                </option>
                                <option value="Bản nháp" {{ old('trangthai', $news->trangthai ?? '') == 'Bản nháp' ? 'selected' : '' }}>
                                    📝 Bản nháp
                                </option>
                                <option value="Ẩn" {{ old('trangthai', $news->trangthai ?? '') == 'Ẩn' ? 'selected' : '' }}>
                                    ✗ Ẩn
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="noibat" name="noibat" value="1"
                                       {{ old('noibat', $news->noibat ?? 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="noibat">
                                    <i class="fas fa-star text-warning me-1"></i> Tin nổi bật
                                </label>
                            </div>
                            <small class="text-muted">Tin nổi bật sẽ hiển thị ở vị trí ưu tiên</small>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="fas fa-image me-2"></i>Hình ảnh
                        </div>
                        
                        @if($news && $news->hinhanh)
                            <div class="current-image">
                                <p class="text-muted mb-2" style="font-size: 0.8rem;">Ảnh hiện tại:</p>
                                <img src="/storage/uploads/{{ $news->hinhanh }}" alt="{{ $news->tieude }}">
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
            <a href="{{ route('admin.news.index') }}" class="btn-cancel">
                <i class="fas fa-times me-1"></i> Hủy
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-1"></i> {{ $news ? 'Cập nhật' : 'Thêm mới' }}
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/3x1u6zvyi6kvo582cfkmjx31d2yy48cbgkyr6mfk0lttmwfq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize TinyMCE
    tinymce.init({
        selector: '#noidung',
        height: 400,
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
        branding: false,
        promotion: false,
        setup: function(editor) {
            editor.on('change', function() {
                editor.save(); // Auto-sync on change
            });
        }
    });
    
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
    
    // Form validation before submit - sync TinyMCE first
    var form = document.getElementById('newsForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Sync TinyMCE content to textarea first
            if (typeof tinymce !== 'undefined' && tinymce.get('noidung')) {
                tinymce.get('noidung').save();
            }
            
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
                if (typeof tinymce !== 'undefined' && tinymce.get('noidung')) {
                    tinymce.get('noidung').focus();
                }
                return false;
            }
            
            // Form is valid, allow submission
            return true;
        });
    }
});
</script>
@endpush
