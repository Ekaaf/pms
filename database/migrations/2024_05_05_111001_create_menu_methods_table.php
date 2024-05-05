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
        Schema::create('menu_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('menu_id');
            $table->smallInteger('type')->nullable();
            $table->string('path', 500)->nullable();
            $table->string('method_name', 500)->nullable();
            $table->smallInteger('default')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('menu_methods');
    }
};
