@extends('layouts.app')

@section('title', 'Tin tức')

@section('content')
<section class="news-section py-4 py-md-5">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header mb-4">
            <h2 class="section-title">Tin tức & Bài viết</h2>
            <p class="section-subtitle text-muted">Cập nhật những tin tức mới nhất từ chúng tôi</p>
        </div>

        @if($news->count() > 0)
            <div class="row g-3 g-md-4">
                @foreach($news as $item)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <article class="news-card h-100">
                            <a href="{{ route('news.show', $item->id) }}" class="text-decoration-none">
                                <div class="news-card-image">
                                    @if($item->hinhanh)
                                        <img src="{{ asset('storage/uploads/' . $item->hinhanh) }}" 
                                            alt="{{ $item->tieude }}"
                                            loading="lazy">
                                    @else
                                        <div class="news-card-placeholder">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="news-card-body">
                                    <div class="news-card-meta">
                                        <span><i class="fas fa-calendar-alt"></i> {{ $item->ngaydang->format('d/m/Y') }}</span>
                                        <span><i class="fas fa-eye"></i> {{ $item->luotxem }}</span>
                                    </div>
                                    <h3 class="news-card-title">{{ $item->tieude }}</h3>
                                    <p class="news-card-excerpt">{{ $item->tomtat ?? truncate_text(strip_tags($item->noidung), 100) }}</p>
                                    <span class="news-read-more">Đọc thêm <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </a>
                        </article>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $news->links() }}
            </div>
        @else
            <div class="empty-state text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <p class="text-muted">Chưa có tin tức nào.</p>
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
    .section-header {
        text-align: center;
    }
    
    .section-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .section-subtitle {
        font-size: 0.95rem;
    }
    
    .news-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s;
    }
    
    .news-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    
    .news-card-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }
    
    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .news-card-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .news-card-placeholder i {
        font-size: 2.5rem;
        color: #dee2e6;
    }
    
    .news-card-body {
        padding: 1rem;
    }
    
    .news-card-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #888;
        margin-bottom: 0.5rem;
    }
    
    .news-card-meta i {
        margin-right: 0.25rem;
    }
    
    .news-card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .news-card-excerpt {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .news-read-more {
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--primary-color, #ff5c8d);
    }
    
    .news-read-more i {
        font-size: 0.7rem;
        margin-left: 0.25rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.25rem;
        }
        
        .section-subtitle {
            font-size: 0.85rem;
        }
        
        .news-card-image {
            height: 150px;
        }
        
        .news-card-body {
            padding: 0.875rem;
        }
        
        .news-card-title {
            font-size: 0.9rem;
        }
        
        .news-card-excerpt {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .news-card-image {
            height: 140px;
        }
        
        .news-card-title {
            font-size: 0.85rem;
        }
        
        .news-card-meta {
            font-size: 0.7rem;
        }
    }
</style>
@endpush
@endsection
