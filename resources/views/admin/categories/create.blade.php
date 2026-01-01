@extends('admin.layouts.app')

@section('title', 'Thêm danh mục mới')

@section('content')
<div class="page-header">
    <h1 class="page-title">Thêm danh mục mới</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
    </a>
</div>

<div class="card">
    <div class="card-header">
        <span>Thông tin danh mục mới</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label text-pink">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('ten_danhmuc') is-invalid @enderror" name="ten_danhmuc" value="{{ old('ten_danhmuc') }}" required placeholder="Nhập tên danh mục">
                @error('ten_danhmuc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">

            <div class="text-end">
                <button type="reset" class="btn btn-secondary me-2">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </button>
                <button type="submit" class="btn btn-pink">
                    <i class="fas fa-save me-1"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-pink {
        color: #ff69b4;
    }
    .btn-pink {
        background: linear-gradient(135deg, #ff69b4, #ff1493);
        border: none;
        color: #fff;
    }
    .btn-pink:hover {
        background: linear-gradient(135deg, #ff1493, #ff69b4);
        color: #fff;
    }
</style>
@endpush
