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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jamaah_id')->constrained('jamaah')->onDelete('cascade');
            $table->foreignId('travel_package_id')->constrained('travel_packages')->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'installment']);
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->date('due_date');
            $table->datetime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('receipt_path')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index('invoice_number');
            $table->index('status');
            $table->index(['jamaah_id', 'status']);
            $table->index('due_date');
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_package_id')->nullable()->constrained('travel_packages')->onDelete('set null');
            $table->string('category');
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->date('expense_date');
            $table->string('receipt_path')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index('category');
            $table->index('expense_date');
            $table->index('travel_package_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('payments');
    }
};