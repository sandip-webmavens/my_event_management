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
        Schema::create('ticket_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('amount', 8, 2); // Assuming amount is in a currency format
            $table->string('payment_method'); // e.g., 'PayPal', 'Stripe'
            $table->string('transaction_id')->unique(); // Unique identifier for the payment transaction
            $table->timestamp('paid_at')->nullable(); // When the payment was completed
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_payments');
    }
};
