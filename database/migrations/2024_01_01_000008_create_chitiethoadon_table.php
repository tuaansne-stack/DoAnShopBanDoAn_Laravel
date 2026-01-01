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
        Schema::create('chitiethoadon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoadon_id')->nullable()->constrained('hoadon')->onDelete('cascade');
            $table->foreignId('monan_id')->nullable()->constrained('monan')->onDelete('restrict');
            $table->integer('soluong')->nullable();
            $table->decimal('gia', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chitiethoadon');
    }
};

