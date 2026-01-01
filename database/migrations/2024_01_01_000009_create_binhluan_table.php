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
        Schema::create('binhluan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monan_id')->constrained('monan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->text('noidung')->nullable();
            $table->integer('danhgia');
            $table->dateTime('ngaytao')->useCurrent();
            $table->enum('trangthai', ['Chờ duyệt', 'Đã duyệt', 'Bị ẩn'])->default('Chờ duyệt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binhluan');
    }
};

