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
        Schema::create('jamaah_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('cascade');
            $table->foreignId('travel_package_id')->constrained('travel_packages')->onDelete('cascade');
            $table->foreignId('accommodation_id')->nullable()->constrained('accommodations')->onDelete('set null');
            $table->foreignId('departure_flight_id')->nullable()->constrained('flights')->onDelete('set null');
            $table->foreignId('return_flight_id')->nullable()->constrained('flights')->onDelete('set null');
            $table->string('room_number')->nullable();
            $table->string('seat_number_departure')->nullable();
            $table->string('seat_number_return')->nullable();
            $table->timestamps();
            
            // Unique constraint - one assignment per jamaah per package
            $table->unique(['jamaah_id', 'travel_package_id']);
            
            // Indexes
            $table->index('travel_package_id');
            $table->index('accommodation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamaah_assignments');
    }
};