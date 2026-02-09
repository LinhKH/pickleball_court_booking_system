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
    Schema::create('cancellation_policies', function (Blueprint $table) {
      $table->id();
      $table->foreignId('court_id')->constrained()->cascadeOnDelete();
      $table->unsignedInteger('before_hours');
      $table->unsignedInteger('refund_percent'); // 100, 50, 0
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cancellation_policies');
  }
};
