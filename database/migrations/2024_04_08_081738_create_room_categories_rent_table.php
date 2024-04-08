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
            $table->decimal('price', 5, 0);
            $table->decimal('discount', 2, 0);
            $table->decimal('created_by', 10, 0);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
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
