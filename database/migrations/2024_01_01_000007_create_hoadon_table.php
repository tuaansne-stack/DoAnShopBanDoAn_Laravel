<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hoadon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('restrict');
            $table->decimal('tongtien', 12, 2)->nullable();
            $table->text('ghichu')->nullable();
            $table->string('diachi_giaohang', 255);
            $table->enum('trangthai', ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Hoàn tất', 'Đã hủy'])->default('Chờ xác nhận');
            $table->dateTime('ngaylap')->useCurrent();
            $table->foreignId('pttt_id')->nullable()->constrained('phuongthucthanhtoan')->onDelete('restrict');
            $table->foreignId('ptvc_id')->nullable()->constrained('phuongthucvanchuyen')->onDelete('restrict');
            $table->boolean('dathanhtoan')->default(false)->comment('Trạng thái thanh toán (0: chưa thanh toán, 1: đã thanh toán)');
            $table->string('ma_giaodich', 100)->nullable()->comment('Mã giao dịch thanh toán');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadon');
    }
};

