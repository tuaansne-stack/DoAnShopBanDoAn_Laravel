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
        Schema::create('monan', function (Blueprint $table) {
            $table->id();
            $table->string('tenmon', 100);
            $table->text('mota')->nullable();
            $table->integer('gia');
            $table->integer('giacu')->nullable();
            $table->string('hinhanh', 255)->nullable();
            $table->foreignId('danhmuc_id')->nullable()->constrained('danhmuc')->onDelete('set null');
            $table->string('trangthai', 50)->default('Đang bán')->comment('Trạng thái món ăn (Đang bán, Hết hàng, Ngừng kinh doanh)');
            $table->boolean('noibat')->default(false)->comment('Đánh dấu món ăn nổi bật (0: Không, 1: Có)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monan');
    }
};

