@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')

<!-- Giới thiệu tổng quan -->
<section class="about-overview py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('assets/images/about-main.png') }}" alt="Giới thiệu về {{ $settings->shop_info ?? 'Food Shop' }}" class="img-fluid rounded">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Chào mừng đến với {{ $settings->shop_info ?? 'Food Shop' }}</h2>
                <p class="lead">{{ $settings->website_info ?? 'Chúng tôi cung cấp các món ăn chất lượng cao với giá cả hợp lý.' }}</p>
                <p>Food Shop tự hào là một trong những cửa hàng ẩm thực hàng đầu, chuyên cung cấp các món ăn ngon, đa dạng với nguyên liệu tươi ngon và chất lượng. Chúng tôi luôn đặt sự hài lòng của khách hàng lên hàng đầu và không ngừng nâng cao chất lượng dịch vụ.</p>
                <p>Với đội ngũ đầu bếp giàu kinh nghiệm, chúng tôi cam kết mang đến cho bạn những trải nghiệm ẩm thực tuyệt vời nhất!</p>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3 bg-light-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-utensils text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Món ăn đa dạng</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3 bg-light-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-truck text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Giao hàng nhanh chóng</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3 bg-light-blue rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-certificate text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Chất lượng đảm bảo</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box me-3 bg-light-pink rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-comments text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Hỗ trợ 24/7</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Các mục giới thiệu chi tiết -->
<div class="container py-5">
    @if($aboutSections->count() == 0)
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <p>Nội dung giới thiệu đang được cập nhật. Vui lòng quay lại sau!</p>
                </div>
            </div>
        </div>
    @else
        @php
            $count = 0;
        @endphp
        @foreach($aboutSections as $item)
            @php
                $count++;
                $reverse_layout = ($count % 2 == 0);
            @endphp
            <section class="about-section py-5">
                <div class="row align-items-center {{ $reverse_layout ? 'flex-row-reverse' : '' }}">
                    @if(!empty($item->hinhanh))
                        <div class="col-md-5 mb-4 mb-md-0">
                            <div class="about-image">
                                <img src="{{ asset('storage/uploads/' . $item->hinhanh) }}" alt="{{ $item->tieude }}" class="img-fluid rounded shadow">
                            </div>
                        </div>
                        <div class="col-md-7">
                    @else
                        <div class="col-12">
                    @endif
                        <div class="about-content">
                            <h2 class="section-title">{{ $item->tieude }}</h2>
                            <div class="content">
                                {!! $item->noidung !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if($count < $aboutSections->count())
                <hr class="my-4">
            @endif
        @endforeach
    @endif
</div>

@push('styles')
<style>
    .page-banner {
        background-color: #f8f9fa;
        position: relative;
    }

    .page-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="1" d="M0,96L80,112C160,128,320,160,480,160C640,160,800,128,960,128C1120,128,1280,160,1360,176L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>');
        background-size: cover;
        background-position: center;
    }

    .about-section {
        margin-bottom: 30px;
    }

    .section-title {
        color: #ff69b4;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 70px;
        height: 3px;
        background: linear-gradient(90deg, #ff69b4, #ff8da1);
    }

    .about-image img {
        transition: transform 0.5s ease;
    }

    .about-image:hover img {
        transform: scale(1.03);
    }

    .content {
        line-height: 1.8;
    }

    .bg-light-blue {
        background-color: #e3f2fd;
    }

    .bg-light-pink {
        background-color: #fce4ec;
    }
</style>
@endpush
@endsection
