@props(['active' => 'profile'])

@php
    $user = auth()->user();
@endphp

<div class="card user-sidebar">
    <div class="card-body text-center py-4">
        <div class="avatar-wrapper mb-3 position-relative">
            @if(!empty($user->avatar))
                <img src="{{ asset('storage/uploads/' . $user->avatar) }}" 
                    class="rounded-circle avatar-image" 
                    style="width: 100px; height: 100px; object-fit: cover;" 
                    alt="Avatar">
            @else
                <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" 
                    style="width: 100px; height: 100px; font-size: 2.5rem;">
                    {{ strtoupper(substr($user->hoten, 0, 1)) }}
                </div>
            @endif
            @if($active === 'profile')
                <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                    data-bs-toggle="modal" data-bs-target="#avatarModal" 
                    style="width: 32px; height: 32px; padding: 0;">
                    <i class="fas fa-camera"></i>
                </button>
            @endif
        </div>
        <h5 class="mb-1">{{ $user->hoten }}</h5>
        <p class="text-muted small">{{ $user->email }}</p>
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ route('profile.index') }}" 
            class="list-group-item list-group-item-action {{ $active === 'profile' ? 'active' : '' }}">
            <i class="fas fa-user me-2"></i>Thông tin cá nhân
        </a>
        <a href="{{ route('orders.index') }}" 
            class="list-group-item list-group-item-action {{ $active === 'orders' ? 'active' : '' }}">
            <i class="fas fa-clipboard-list me-2"></i>Đơn hàng của tôi
        </a>
        <a href="{{ route('cart.index') }}" 
            class="list-group-item list-group-item-action {{ $active === 'cart' ? 'active' : '' }}">
            <i class="fas fa-shopping-cart me-2"></i>Giỏ hàng
        </a>
        <form method="POST" action="{{ route('logout') }}" class="list-group-item p-0">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action text-danger border-0 w-100 text-start">
                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
            </button>
        </form>
    </div>
</div>

