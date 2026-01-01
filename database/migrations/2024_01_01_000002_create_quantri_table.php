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
        Schema::create('quantri', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->text('website_info')->nullable();
            $table->text('shop_info')->nullable();
            $table->string('khuyenmai', 11)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('hotline', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quantri');
    }
};

