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
        Schema::create('travel_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('duration_days');
            $table->date('departure_date');
            $table->date('return_date');
            $table->integer('capacity');
            $table->integer('registered_count')->default(0);
            $table->enum('status', ['draft', 'open', 'full', 'closed', 'completed'])->default('draft');
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('departure_date');
            $table->index(['status', 'departure_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_packages');
    }
};