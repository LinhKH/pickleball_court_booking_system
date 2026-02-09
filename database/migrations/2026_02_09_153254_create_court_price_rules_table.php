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
    Schema::create('court_price_rules', function (Blueprint $table) {
      $table->id();
      $table->foreignId('court_id')->constrained()->cascadeOnDelete();
      $table->tinyInteger('day_of_week')->nullable(); // 1 (Mon) - 7 (Sun)
      $table->time('start_time');
      $table->time('end_time');
      $table->decimal('price_per_hour', 10, 2);
      $table->enum('rule_type', ['day', 'night', 'peak', 'weekend', 'event']);
      $table->unsignedInteger('priority')->default(0);
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      $table->index(['court_id', 'day_of_week', 'priority']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('court_price_rules');
  }
};
