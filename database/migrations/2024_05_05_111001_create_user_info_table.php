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
        Schema::create('user_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 10);
            $table->string('first_name', 100);
            $table->string('last_name');
            $table->text('address')->nullable();
            $table->string('postal_code', 30)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('user_info');
    }
};
