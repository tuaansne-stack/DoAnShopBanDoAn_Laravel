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
        Schema::create('phuongthucthanhtoan', function (Blueprint $table) {
            $table->id();
            $table->string('ten_pttt', 100);
            $table->boolean('trangthai')->default(true)->comment('Trạng thái phương thức thanh toán: 1-Hoạt động, 0-Tạm khóa');
            $table->text('mota')->nullable()->comment('Mô tả chi tiết về phương thức thanh toán');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phuongthucthanhtoan');
    }
};

