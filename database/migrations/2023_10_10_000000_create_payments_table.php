<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('signature')->nullable();
            $table->decimal('amount', 10, 2)->nullable(); // Use decimal for precise amount
            $table->string('currency', 3)->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamps();

            // Add unique constraints to prevent duplicate entries
            $table->unique(['order_id', 'payment_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}