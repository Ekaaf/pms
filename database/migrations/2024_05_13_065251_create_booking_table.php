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
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('user_id', 10, 0);
            $table->decimal('room_id', 10, 0);
            $table->timestamp('from_date');
            $table->timestamp('to_date');
            $table->decimal('people_adult', 1, 0)->nullable();
            $table->decimal('people_child', 1, 0)->nullable();
            $table->timestamp('checked_in_time')->nullable();
            $table->timestamp('checked_out_time')->nullable();
            $table->decimal('unit_price', 10, 0)->nullable();
            $table->decimal('discount', 10, 0)->nullable();
            $table->decimal('total_price', 10, 0)->nullable();
            $table->decimal('vat', 10, 0)->nullable();
            $table->decimal('created_by', 10, 0)->nullable();
            $table->timestamps();
            $table->integer('billing_id')->nullable();
            $table->string('booking_type', 20)->nullable();
            $table->integer('room_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking');
    }
};
