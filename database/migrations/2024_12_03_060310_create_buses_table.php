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
        Schema::create('buses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('bus_number')->unique(); // Unique bus number or registration
            $table->string('route'); // Route name or number
            $table->string('origin')->index(); // Origin city or stop
            $table->string('destination')->index(); // Destination city or stop
            $table->time('departure_time'); // Departure time
            $table->time('arrival_time'); // Arrival time
            $table->integer('seating_capacity'); // Total seating capacity
            $table->decimal('price_per_seat', 8, 2); // Price per seat
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
