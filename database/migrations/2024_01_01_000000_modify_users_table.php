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
        // Drop the default users table if it exists and create user table
        Schema::dropIfExists('users');
        
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('hoten', 100);
            $table->string('email', 100)->nullable()->unique();
            $table->string('sdt', 15)->nullable();
            $table->string('password');
            $table->string('avatar', 255)->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('trangthai', 50)->default('Hoạt động')->comment('Trạng thái tài khoản (Hoạt động, Khóa)');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
        
        // Recreate default users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
};

