@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<!-- Nội dung trang liên hệ -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <!-- Thông tin liên hệ -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-header bg-gradient text-white">
                        <h5 class="mb-0">Thông tin liên hệ</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $settings->shop_info ?? 'Food Shop' }}</h5>
                        <p class="card-text">{{ $settings->website_info ?? '' }}</p>

                        <div class="contact-info mt-4">
                            @if(!empty($settings->address))
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-map-marker-alt fa-fw text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Địa chỉ:</h6>
                                        <p class="mb-0">{!! nl2br(e($settings->address)) !!}</p>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($settings->email))
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-envelope fa-fw text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Email:</h6>
                                        <p class="mb-0">{{ $settings->email }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($settings->hotline))
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-phone-alt fa-fw text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hotline:</h6>
                                        <p class="mb-0">{{ $settings->hotline }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-clock fa-fw text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Giờ làm việc:</h6>
                                    <p class="mb-0">Thứ 2 - Chủ nhật: 7:00 - 22:00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social-links mt-4">
                            <h6>Kết nối với chúng tôi:</h6>
                            <div class="d-flex mt-2">
                                @if(!empty($settings->facebook))
                                    <a href="{{ $settings->facebook }}" class="btn btn-outline-primary me-2" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                <a href="#" class="btn btn-outline-info me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger me-2">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-gradient text-white">
                        <h5 class="mb-0">Câu hỏi thường gặp</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <!-- FAQ Item 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                        Giờ mở cửa của cửa hàng là gì?
                                    </button>
                                </h2>
                                <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Cửa hàng chúng tôi mở cửa từ 7:00 sáng đến 22:00 tối, từ Thứ 2 đến Chủ nhật hàng tuần, kể cả ngày lễ.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                        Cửa hàng có giao hàng không?
                                    </button>
                                </h2>
                                <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Có, chúng tôi có dịch vụ giao hàng trong khu vực nội thành. Phí giao hàng sẽ phụ thuộc vào khoảng cách và phương thức vận chuyển bạn chọn. Đơn hàng trên 300,000đ sẽ được miễn phí giao hàng trong bán kính 5km.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                        Làm thế nào để đặt hàng trực tuyến?
                                    </button>
                                </h2>
                                <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Để đặt hàng trực tuyến, bạn chỉ cần:</p>
                                        <ol>
                                            <li>Duyệt qua các mục món ăn trên trang web của chúng tôi</li>
                                            <li>Thêm các món ăn bạn muốn vào giỏ hàng</li>
                                            <li>Tiến hành thanh toán và điền thông tin giao hàng</li>
                                            <li>Chọn phương thức thanh toán và hoàn tất đơn hàng</li>
                                        </ol>
                                        <p>Sau khi đặt hàng, bạn sẽ nhận được email xác nhận và thông tin về thời gian giao hàng dự kiến.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 4 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                        Cửa hàng có nhận đặt tiệc không?
                                    </button>
                                </h2>
                                <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Có, chúng tôi có dịch vụ đặt tiệc cho các sự kiện như sinh nhật, họp mặt gia đình, hội nghị công ty, v.v. Vui lòng liên hệ trực tiếp với chúng tôi qua số điện thoại hoặc email để được tư vấn chi tiết về menu và báo giá.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 5 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqHeading5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                        Làm thế nào để hủy hoặc thay đổi đơn hàng?
                                    </button>
                                </h2>
                                <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Để hủy hoặc thay đổi đơn hàng, bạn cần liên hệ với chúng tôi càng sớm càng tốt. Đơn hàng chỉ có thể được hủy hoặc thay đổi khi chưa bắt đầu chuẩn bị. Vui lòng gọi số hotline của chúng tôi để được hỗ trợ nhanh nhất.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Liên hệ trực tiếp -->
                        <div class="direct-contact mt-4">
                            <h5 class="border-bottom pb-2">Liên hệ trực tiếp với chúng tôi</h5>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-phone-alt fa-fw text-primary me-2"></i>
                                        <div>
                                            <p class="mb-0">Gọi ngay: {{ $settings->hotline ?? '0123456789' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-envelope fa-fw text-primary me-2"></i>
                                        <div>
                                            <p class="mb-0">Email: {{ $settings->email ?? 'info@foodshop.com' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2">Đội ngũ hỗ trợ khách hàng của chúng tôi luôn sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Google Map -->
<section class="map-section my-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6963433041785!2d105.84094801482347!3d21.00708998601256!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac76ccab6dd7%3A0x55e92a5b07a97a03!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIEjDoCBO4buZaQ!5e0!3m2!1svi!2s!4v1685251684751!5m2!1svi!2s"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
