<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_order_id')->constrained(table: 'event_orders')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // PayPal, Stripe, etc.
            $table->string('transaction_id')->unique(); // Payment gateway transaction ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
