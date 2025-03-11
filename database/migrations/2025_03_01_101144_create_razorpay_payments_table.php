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
        Schema::create('razorpay_payments', function (Blueprint $table) {
            $table->id();
            $table->string('razorpay_payment_id')->unique();
            $table->string('razorpay_order_id');
            $table->string('razorpay_signature')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('trace_id')->nullable();
            $table->string('booking_id')->nullable();
            $table->string('hotel_code')->nullable();
            $table->string('hotel_name')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('error_message')->nullable();
            $table->json('booking_details')->nullable();
            $table->timestamps();
            
            // Indexes for faster lookup
            $table->index(['status', 'created_at']);
            $table->index('booking_id');
            $table->index('customer_email');
            $table->index('customer_phone');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('razorpay_payments');
    }
};