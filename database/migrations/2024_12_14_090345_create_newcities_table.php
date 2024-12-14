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
        Schema::create('newcities', function (Blueprint $table) {
            $table->id(); // Laravel's default primary key column
            $table->integer('CityId')->unique(); // CityId from the API response
            $table->string('CityName'); // CityName from the API response
            $table->timestamps(); // created_at and updated_at columns (if needed)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newcities');
    }
};
