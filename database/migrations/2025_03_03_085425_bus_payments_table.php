<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BusPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buspayments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('payment_id')->unique();
            $table->string('trace_id');
            $table->decimal('amount', 10, 2);
            $table->json('passenger_data');
            $table->string('boarding_point');
            $table->string('dropping_point');
            $table->string('seat_number');
            $table->string('status');
            $table->json('payment_response')->nullable();
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
        Schema::dropIfExists('payments');
    }
}