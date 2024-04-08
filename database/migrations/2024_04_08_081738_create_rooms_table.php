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
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('room_category_id', 10, 0);
            $table->string('room_number', 10);
            $table->string('room_status', 15);
            $table->decimal('status', 1, 0)->default(1);
            $table->decimal('housekeeping', 1, 0)->default(1);
            $table->decimal('created_by', 10, 0)->nullable();
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
        Schema::dropIfExists('rooms');
    }
};
