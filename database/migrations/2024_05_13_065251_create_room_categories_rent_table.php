<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_categories_rent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_category_id');
            $table->date('rent_date');
            $table->decimal('price', 10, 0);
            $table->decimal('discount', 10, 0)->default(0);
            $table->decimal('net_price', 10, 0);
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_categories_rent');
    }
};
