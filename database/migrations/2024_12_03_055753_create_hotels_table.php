<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Hotel name
            $table->string('location'); // Location (city, address, etc.)
            $table->integer('rating')->nullable(); // Rating (e.g., stars, out of 5)
            $table->decimal('price_per_night', 8, 2); // Price per night
            $table->text('description')->nullable(); // Description of the hotel
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
