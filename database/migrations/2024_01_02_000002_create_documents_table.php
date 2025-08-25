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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('cascade');
            $table->enum('type', ['ktp', 'passport', 'visa', 'vaccination_certificate', 'health_certificate', 'flight_ticket', 'other']);
            $table->string('title');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('mime_type');
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->text('notes')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index(['jamaah_id', 'type']);
            $table->index('status');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};