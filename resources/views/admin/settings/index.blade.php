@extends('admin.layouts.app')

@section('title', 'Cài đặt hệ thống')

@section('content')
<div class="page-header">
    <h1 class="page-title">Cài đặt hệ thống</h1>
</div>

<div class="card">
    <div class="card-body">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                    <i class="fas fa-cog me-1"></i> Thông tin chung
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#social" type="button">
                    <i class="fas fa-share-alt me-1"></i> Mạng xã hội
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment" type="button">
                    <i class="fas fa-credit-card me-1"></i> Thanh toán
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bank" type="button">
                    <i class="fas fa-university me-1"></i> Thông tin ngân hàng
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping" type="button">
                    <i class="fas fa-truck me-1"></i> Vận chuyển
                </button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content p-4" id="settingsTabsContent">
            
            <!-- Tab: Thông tin chung -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <form action="{{ route('admin.settings.general') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tên cửa hàng</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="shop_info" value="{{ $settings->shop_info ?? '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Mô tả cửa hàng</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="website_info" rows="3">{{ $settings->website_info ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Địa chỉ</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="address" rows="2">{{ $settings->address ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Hotline</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="hotline" value="{{ $settings->hotline ?? '' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="{{ $settings->email ?? '' }}">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu thông tin chung
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab: Mạng xã hội -->
            <div class="tab-pane fade" id="social" role="tabpanel">
                <form action="{{ route('admin.settings.social') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fab fa-facebook me-1"></i> Facebook</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="facebook" value="{{ $settings->facebook ?? '' }}" placeholder="https://facebook.com/yourpage">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fab fa-twitter me-1"></i> Twitter</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="twitter" value="{{ $settings->twitter ?? '' }}" placeholder="https://twitter.com/youraccount">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fab fa-instagram me-1"></i> Instagram</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="instagram" value="{{ $settings->instagram ?? '' }}" placeholder="https://instagram.com/youraccount">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fas fa-phone me-1"></i> Zalo</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="zalo" value="{{ $settings->zalo ?? '' }}" placeholder="Số điện thoại Zalo hoặc link Zalo">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fab fa-pinterest me-1"></i> Pinterest</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="pinterest" value="{{ $settings->pinterest ?? '' }}" placeholder="https://pinterest.com/yourprofile">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fab fa-linkedin me-1"></i> LinkedIn</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="linkedin" value="{{ $settings->linkedin ?? '' }}" placeholder="https://linkedin.com/in/yourprofile">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label"><i class="fab fa-tiktok me-1"></i> TikTok</label>
                        <div class="col-sm-9">
                            <input type="url" class="form-control" name="tiktok" value="{{ $settings->tiktok ?? '' }}" placeholder="https://tiktok.com/@youraccount">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu liên kết mạng xã hội
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab: Thanh toán -->
            <div class="tab-pane fade" id="payment" role="tabpanel">
                <form action="{{ route('admin.settings.payment') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Phương thức thanh toán hiện có</h5>
                    @if($paymentMethods->count() > 0)
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Tên phương thức</th>
                                        <th style="width: 35%;">Mô tả</th>
                                        <th style="width: 15%;">Trạng thái</th>
                                        <th style="width: 10%;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paymentMethods as $payment)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="payment_methods[{{ $payment->id }}][name]" value="{{ $payment->ten_pttt }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="payment_methods[{{ $payment->id }}][description]" rows="1">{{ $payment->mota ?? '' }}</textarea>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="payment_methods[{{ $payment->id }}][status]" value="1" {{ $payment->trangthai ? 'checked' : '' }}>
                                                    <label class="form-check-label">Kích hoạt</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="payment_methods[{{ $payment->id }}][delete]" value="1">
                                                    <label class="form-check-label text-danger">Xóa</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-3">Chưa có phương thức thanh toán nào.</div>
                    @endif

                    <h5 class="mb-3">Thêm phương thức thanh toán mới</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="new_payment[name]" placeholder="Tên phương thức thanh toán">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="new_payment[description]" placeholder="Mô tả ngắn">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="new_payment[status]" value="1" checked>
                                <label class="form-check-label">Kích hoạt</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu phương thức thanh toán
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab: Thông tin ngân hàng -->
            <div class="tab-pane fade" id="bank" role="tabpanel">
                <form action="{{ route('admin.settings.bank') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Thông tin ngân hàng hiện có</h5>
                    @if($bankInfo->count() > 0)
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên ngân hàng</th>
                                        <th>Mã VietQR</th>
                                        <th>Số tài khoản</th>
                                        <th>Chủ tài khoản</th>
                                        <th>Chi nhánh</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bankInfo as $bank)
                                        <tr>
                                            <td><input type="text" class="form-control" name="bank_info[{{ $bank->id }}][bank_name]" value="{{ $bank->ten_nganhang }}"></td>
                                            <td><input type="text" class="form-control" name="bank_info[{{ $bank->id }}][bank_code]" value="{{ $bank->ma_nganhang ?? '' }}"></td>
                                            <td><input type="text" class="form-control" name="bank_info[{{ $bank->id }}][account_number]" value="{{ $bank->so_taikhoan }}"></td>
                                            <td><input type="text" class="form-control" name="bank_info[{{ $bank->id }}][account_name]" value="{{ $bank->ten_chutaikhoan }}"></td>
                                            <td><input type="text" class="form-control" name="bank_info[{{ $bank->id }}][branch]" value="{{ $bank->chi_nhanh ?? '' }}"></td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="bank_info[{{ $bank->id }}][delete]" value="1">
                                                    <label class="form-check-label text-danger">Xóa</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-3">Chưa có thông tin ngân hàng nào.</div>
                    @endif

                    <h5 class="mb-3">Thêm thông tin ngân hàng mới</h5>
                    <div class="row mb-3">
                        <div class="col-md-2"><input type="text" class="form-control" name="new_bank[bank_name]" placeholder="Tên ngân hàng"></div>
                        <div class="col-md-2"><input type="text" class="form-control" name="new_bank[bank_code]" placeholder="Mã VietQR"></div>
                        <div class="col-md-3"><input type="text" class="form-control" name="new_bank[account_number]" placeholder="Số tài khoản"></div>
                        <div class="col-md-3"><input type="text" class="form-control" name="new_bank[account_name]" placeholder="Chủ tài khoản"></div>
                        <div class="col-md-2"><input type="text" class="form-control" name="new_bank[branch]" placeholder="Chi nhánh"></div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu thông tin ngân hàng
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab: Vận chuyển -->
            <div class="tab-pane fade" id="shipping" role="tabpanel">
                <form action="{{ route('admin.settings.shipping') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Phương thức vận chuyển hiện có</h5>
                    @if($shippingMethods->count() > 0)
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Tên phương thức</th>
                                        <th style="width: 20%;">Phí vận chuyển</th>
                                        <th style="width: 30%;">Mô tả</th>
                                        <th style="width: 20%;">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shippingMethods as $shipping)
                                        <tr>
                                            <td><input type="text" class="form-control" name="shipping_methods[{{ $shipping->id }}][name]" value="{{ $shipping->ten_ptvc }}"></td>
                                            <td><input type="number" class="form-control" name="shipping_methods[{{ $shipping->id }}][fee]" value="{{ $shipping->gia_vanchuyen }}" min="0" step="1000"></td>
                                            <td><textarea class="form-control" name="shipping_methods[{{ $shipping->id }}][description]" rows="1">{{ $shipping->mota ?? '' }}</textarea></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="shipping_methods[{{ $shipping->id }}][status]" value="1" {{ $shipping->trangthai ? 'checked' : '' }}>
                                                    <label class="form-check-label">Kích hoạt</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-3">Chưa có phương thức vận chuyển nào.</div>
                    @endif

                    <h5 class="mb-3">Thêm phương thức vận chuyển mới</h5>
                    <div class="row mb-3">
                        <div class="col-md-3"><input type="text" class="form-control" name="new_shipping[name]" placeholder="Tên phương thức vận chuyển"></div>
                        <div class="col-md-2"><input type="number" class="form-control" name="new_shipping[fee]" placeholder="Phí vận chuyển" min="0" step="1000"></div>
                        <div class="col-md-4"><input type="text" class="form-control" name="new_shipping[description]" placeholder="Mô tả ngắn"></div>
                        <div class="col-md-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="new_shipping[status]" value="1" checked>
                                <label class="form-check-label">Kích hoạt</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Lưu phương thức vận chuyển
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #666;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 15px;
        font-size: 0.85rem;
    }
    .nav-tabs .nav-link:hover {
        color: var(--primary-pink);
        border-color: transparent;
    }
    .nav-tabs .nav-link.active {
        color: #1976d2;
        border-bottom-color: #1976d2;
        background: transparent;
    }
    
    /* Logo & Favicon Preview Styles */
    .placeholder-box {
        padding: 30px 20px;
        background: #f8f9fa;
        border: 2px dashed #ddd;
        border-radius: 10px;
        min-height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .logo-preview-container,
    .favicon-preview-container {
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo-preview-container img,
    .favicon-preview-container img {
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 8px;
        background: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logo preview
    const logoInput = document.getElementById('logoInput');
    const logoPreview = document.getElementById('logoPreview');
    const logoPlaceholder = document.getElementById('logoPlaceholder');
    
    if (logoInput) {
        logoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    if (logoPreview) {
                        logoPreview.src = event.target.result;
                        logoPreview.classList.remove('d-none');
                    }
                    if (logoPlaceholder) {
                        logoPlaceholder.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    // Favicon preview
    const faviconInput = document.getElementById('faviconInput');
    const faviconPreview = document.getElementById('faviconPreview');
    const faviconPlaceholder = document.getElementById('faviconPlaceholder');
    
    if (faviconInput) {
        faviconInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    if (faviconPreview) {
                        faviconPreview.src = event.target.result;
                        faviconPreview.classList.remove('d-none');
                    }
                    if (faviconPlaceholder) {
                        faviconPlaceholder.classList.add('d-none');
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});
</script>
@endpush
