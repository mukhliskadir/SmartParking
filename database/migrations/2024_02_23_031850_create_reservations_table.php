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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('parking_spot_id');
            $table->foreign('parking_spot_id')->references('id')->on('parking_spots')->onDelete('cascade');
            $table->string('car_model')->nullable();
            $table->string('car_plate')->nullable();
            $table->dateTime('reserved_at');
            $table->dateTime('reserved_until');
            $table->integer('duration');
            $table->enum('status', ['reserved', 'cancelled'])->default('reserved');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
