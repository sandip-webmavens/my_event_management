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
        Schema::create('attendee_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tickets_id')->nullable()->constrained('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['p', 'a'])->default('a');
            $table->string('qr_codes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_lists');
    }
};
