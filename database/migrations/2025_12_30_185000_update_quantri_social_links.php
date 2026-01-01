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
        Schema::table('quantri', function (Blueprint $table) {
            // Remove old columns
            if (Schema::hasColumn('quantri', 'khuyenmai')) {
                $table->dropColumn('khuyenmai');
            }
            if (Schema::hasColumn('quantri', 'taikhoan')) {
                $table->dropColumn('taikhoan');
            }
            if (Schema::hasColumn('quantri', 'matkhau')) {
                $table->dropColumn('matkhau');
            }
            
            // Add social media columns
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('instagram')->nullable()->after('twitter');
            $table->string('zalo')->nullable()->after('instagram');
            $table->string('pinterest')->nullable()->after('zalo');
            $table->string('linkedin')->nullable()->after('pinterest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quantri', function (Blueprint $table) {
            // Re-add removed columns
            $table->string('khuyenmai')->nullable();
            $table->string('taikhoan')->nullable();
            $table->string('matkhau')->nullable();
            
            // Remove social media columns
            $table->dropColumn(['twitter', 'instagram', 'zalo', 'pinterest', 'linkedin']);
        });
    }
};
