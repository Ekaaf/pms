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
        Schema::create('billing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->decimal('total_price', 10, 0);
            $table->decimal('total_discount', 10, 0);
            $table->decimal('paid_amount', 10, 0);
            $table->decimal('due_amount', 10, 0);
            $table->decimal('total_vat', 10, 0);
            $table->decimal('price_with_vat', 10, 0);
            $table->decimal('adjustment', 10, 0)->default(0);
            $table->decimal('final_price', 10, 0);
            $table->integer('created_by');
            $table->decimal('payment_completed', 1, 0)->default(0);
            $table->timestamp('payment_completion_time')->nullable();
            $table->timestamp('created_at');
            $table->timestampTz('updated_at')->nullable();
            $table->text('adjustment_reason')->nullable();
            $table->string('booking_type', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing');
    }
};
