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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('stock_quantity');
            $table->integer('distributed_quantity')->default(0);
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available');
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('stock_quantity');
        });

        Schema::create('equipment_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('distributed_at');
            $table->text('notes')->nullable();
            $table->foreignId('distributed_by')->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index(['jamaah_id', 'equipment_id']);
            $table->index('distributed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_distributions');
        Schema::dropIfExists('equipment');
    }
};