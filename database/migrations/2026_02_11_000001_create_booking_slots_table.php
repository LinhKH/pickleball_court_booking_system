<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//🔒 Chốt cứng: 1 slot chỉ thuộc 1 booking
return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('booking_slots', function (Blueprint $table) {
      $table->id();
      $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
      $table->foreignId('court_slot_id')->constrained()->cascadeOnDelete();
      $table->decimal('price', 10, 2);

      $table->unique('court_slot_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('booking_slots');
  }
};
