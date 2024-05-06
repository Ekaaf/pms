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
        Schema::create('room_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->string('size');
            $table->decimal('people_adult', 2, 0);
            $table->decimal('people_child', 2, 0)->default(0);
            $table->text('description');
            $table->text('package')->nullable();
            $table->text('facilities');
            $table->smallInteger('created_by');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->string('bed');
            $table->string('check_in', 50);
            $table->string('check_out', 50);
            $table->text('check_in_instruction')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->decimal('price', 10, 0);
            $table->decimal('discount', 10, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_categories');
    }
};
