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
        Schema::table('tintuc', function (Blueprint $table) {
            if (!Schema::hasColumn('tintuc', 'noibat')) {
                $table->boolean('noibat')->default(0)->after('trangthai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tintuc', function (Blueprint $table) {
            if (Schema::hasColumn('tintuc', 'noibat')) {
                $table->dropColumn('noibat');
            }
        });
    }
};
