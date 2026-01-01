<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChitiethoadonToppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitiethoadon_topping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chitiethoadon_id');
            $table->unsignedBigInteger('topping_id');
            $table->integer('soluong')->default(1);
            $table->decimal('gia', 12, 0)->default(0);
            $table->foreign('chitiethoadon_id')->references('id')->on('chitiethoadon')->onDelete('cascade');
            $table->foreign('topping_id')->references('id')->on('topping')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chitiethoadon_topping');
    }
}
