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
        Schema::create('jamaah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan');
            $table->string('full_name');
            $table->enum('gender', ['male', 'female']);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('nationality')->default('Indonesia');
            $table->string('occupation')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('medical_notes')->nullable();
            $table->enum('status', ['registered', 'documents_pending', 'documents_complete', 'ready_to_depart', 'departed', 'returned'])->default('registered');
            $table->timestamps();
            
            // Indexes
            $table->index('nik');
            $table->index('status');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamaah');
    }
};