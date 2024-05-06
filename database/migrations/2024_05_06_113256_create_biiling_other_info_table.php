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
        Schema::create('biiling_other_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id');
            $table->string('identity', 20)->nullable();
            $table->date('dob')->nullable();
            $table->string('nationality', 30)->nullable();
            $table->string('estimated_arrival_time', 20)->nullable();
            $table->integer('created_by');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('identity_number', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biiling_other_info');
    }
};
