@extends('layouts.app')

@section('title', $news->tieude)

@section('content')
<section class="news-detail-section py-4 py-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="news-article">
                    <!-- Back Link -->
                    <a href="{{ route('news.index') }}" class="back-link mb-3 d-inline-block">
                        <i class="fas fa-arrow-left"></i> Quay lại tin tức
                    </a>

                    <!-- Article Header -->
                    <header class="article-header">
                        <h1 class="article-title">{{ $news->tieude }}</h1>
                        <div class="article-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $news->ngaydang->format('d/m/Y') }}
                            </span>
                            @if($news->tacgia)
                                <span class="meta-item">
                                    <i class="fas fa-user"></i>
                                    {{ $news->tacgia }}
                                </span>
                            @endif
                            <span class="meta-item">
                                <i class="fas fa-eye"></i>
                                {{ $news->luotxem }} lượt xem
                            </span>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    @if($news->hinhanh)
                        <div class="article-image">
                            <img src="{{ asset('storage/uploads/' . $news->hinhanh) }}" 
                                alt="{{ $news->tieude }}">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        {!! $news->noidung !!}
                    </div>
                </article>

                <!-- Related News -->
                @if($relatedNews->count() > 0)
                    <div class="related-section mt-5">
                        <h4 class="related-title">Bài viết liên quan</h4>
                        <div class="row g-3">
                            @foreach($relatedNews as $related)
                                <div class="col-6 col-md-4">
                                    <a href="{{ route('news.show', $related->id) }}" class="related-card">
                                        @if($related->hinhanh)
                                            <div class="related-image">
                                                <img src="{{ asset('storage/uploads/' . $related->hinhanh) }}" 
                                                    alt="{{ $related->tieude }}">
                                            </div>
                                        @endif
                                        <div class="related-info">
                                            <h5>{{ $related->tieude }}</h5>
                                            <span>{{ $related->ngaydang->format('d/m/Y') }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .news-detail-section {
        background: #fafafa;
    }
    
    .news-article {
        max-width: 100%;
    }
    
    .back-link {
        font-size: 0.9rem;
        color: var(--primary-color, #ff5c8d);
        text-decoration: none;
    }
    
    .back-link:hover {
        text-decoration: underline;
    }
    
    .article-header {
        margin-bottom: 1.5rem;
    }
    
    .article-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #222;
        line-height: 1.3;
        margin-bottom: 1rem;
    }
    
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    
    .meta-item {
        font-size: 0.85rem;
        color: #777;
    }
    
    .meta-item i {
        margin-right: 0.35rem;
        color: var(--primary-color, #ff5c8d);
    }
    
    .article-image {
        margin-bottom: 1.5rem;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .article-image img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .article-content {
        font-size: 1rem;
        line-height: 1.85;
        color: #333;
    }
    
    .article-content p {
        margin-bottom: 1.25rem;
    }
    
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.25rem 0;
    }
    
    .article-content h2 {
        font-size: 1.4rem;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
        color: #222;
    }
    
    .article-content h3 {
        font-size: 1.2rem;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        color: #222;
    }
    
    .article-content ul, 
    .article-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }
    
    .article-content li {
        margin-bottom: 0.5rem;
    }
    
    .article-content blockquote {
        border-left: 3px solid var(--primary-color, #ff5c8d);
        padding-left: 1rem;
        margin: 1.5rem 0;
        color: #555;
        font-style: italic;
    }
    
    /* Related Section */
    .related-section {
        padding-top: 2rem;
        border-top: 1px solid #e0e0e0;
    }
    
    .related-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }
    
    .related-card {
        display: block;
        text-decoration: none;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    
    .related-card:hover h5 {
        color: var(--primary-color, #ff5c8d);
    }
    
    .related-image {
        height: 100px;
        overflow: hidden;
    }
    
    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .related-info {
        padding: 0.75rem;
    }
    
    .related-info h5 {
        font-size: 0.85rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 0.25rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .related-info span {
        font-size: 0.75rem;
        color: #888;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .article-title {
            font-size: 1.35rem;
        }
        
        .article-meta {
            gap: 0.75rem;
        }
        
        .meta-item {
            font-size: 0.8rem;
        }
        
        .article-content {
            font-size: 0.95rem;
            line-height: 1.75;
        }
        
        .related-image {
            height: 80px;
        }
        
        .related-info h5 {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .article-title {
            font-size: 1.2rem;
        }
        
        .article-meta {
            gap: 0.5rem;
            flex-direction: column;
        }
        
        .article-content {
            font-size: 0.9rem;
        }
        
        .article-content h2 {
            font-size: 1.15rem;
        }
        
        .article-content h3 {
            font-size: 1.05rem;
        }
    }
</style>
@endpush
@endsection
