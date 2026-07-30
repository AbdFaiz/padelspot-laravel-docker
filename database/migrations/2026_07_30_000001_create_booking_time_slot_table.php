<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_time_slot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('time_slot_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->unique(['booking_id', 'time_slot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_time_slot');
    }
};
