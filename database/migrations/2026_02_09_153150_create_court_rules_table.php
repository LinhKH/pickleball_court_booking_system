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
    Schema::create('court_rules', function (Blueprint $table) {
      $table->id();
      $table->foreignId('court_id')->constrained()->cascadeOnDelete();
      $table->unsignedInteger('min_booking_minutes')->default(60);
      $table->unsignedInteger('max_booking_minutes')->default(180);
      $table->unsignedInteger('hold_minutes')->default(10);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('court_rules');
  }
};
