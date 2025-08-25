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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['hotel', 'apartment', 'residence']);
            $table->enum('location', ['makkah', 'madinah', 'jeddah', 'other']);
            $table->text('address');
            $table->integer('star_rating')->nullable();
            $table->text('facilities')->nullable();
            $table->decimal('distance_to_haram', 8, 2)->nullable()->comment('Distance in KM');
            $table->timestamps();
            
            // Indexes
            $table->index(['type', 'location']);
            $table->index('star_rating');
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->string('airline');
            $table->string('departure_airport');
            $table->string('arrival_airport');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
            $table->enum('type', ['departure', 'return']);
            $table->enum('status', ['scheduled', 'delayed', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();
            
            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index('departure_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
        Schema::dropIfExists('accommodations');
    }
};