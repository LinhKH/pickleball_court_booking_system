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
    Schema::create('hour_packages', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedInteger('total_hours');
      $table->decimal('price', 10, 2);
      $table->unsignedInteger('expired_days');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('hour_packages');
  }
};
