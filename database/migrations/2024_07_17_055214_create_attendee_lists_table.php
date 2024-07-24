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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tickets_id')->nullable();
            $table->foreign('tickets_id')->references('id')->on('tickets')->onUpdate('cascade')->onDelete('cascade');
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
