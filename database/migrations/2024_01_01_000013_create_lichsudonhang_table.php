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
        Schema::create('lichsudonhang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoadon_id')->constrained('hoadon')->onDelete('cascade');
            $table->string('trang_thai_cu', 50)->nullable();
            $table->string('trang_thai_moi', 50);
            $table->dateTime('ngay_thay_doi')->useCurrent();
            $table->string('nguoi_thay_doi', 100)->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lichsudonhang');
    }
};

