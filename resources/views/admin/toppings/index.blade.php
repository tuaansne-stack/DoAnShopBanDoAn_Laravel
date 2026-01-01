@extends('admin.layouts.app')

@section('title', 'Quản lý Topping')

@section('content')
<div class="page-header">
    <h1 class="page-title">Quản lý Topping</h1>
    <a href="{{ route('admin.toppings.create') }}" class="btn btn-pink">
        <i class="fas fa-plus me-1"></i> Thêm topping mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <span>Danh sách Topping</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 70px;">Hình ảnh</th>
                        <th>Tên topping</th>
                        <th style="width: 120px;">Giá</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 100px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($toppings as $topping)
                        <tr>
                            <td>{{ $topping->id }}</td>
                            <td>
                                @if($topping->hinhanh)
                                    <img src="/storage/uploads/{{ $topping->hinhanh }}" alt="{{ $topping->tentopping }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-cookie text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $topping->tentopping }}</strong></td>
                            <td class="text-danger fw-bold">{{ number_format($topping->gia, 0, ',', '.') }} đ</td>
                            <td>
                                @if($topping->trangthai)
                                    <span class="badge bg-success">Đang bán</span>
                                @else
                                    <span class="badge bg-secondary">Ngừng bán</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.toppings.edit', $topping->id) }}" class="btn btn-action-edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.toppings.destroy', $topping->id) }}" method="POST" class="d-inline" data-confirm="Bạn có chắc muốn xóa topping này?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action-delete" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-cookie-bite fa-2x mb-2"></i>
                                <p class="mb-0">Chưa có topping nào.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($toppings->hasPages())
        <div class="card-footer bg-white">
            {{ $toppings->links('vendor.pagination.admin') }}
        </div>
    @endif
</div>
@endsection
