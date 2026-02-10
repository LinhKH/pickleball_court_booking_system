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
    Schema::create('court_units', function (Blueprint $table) {
      $table->id();
      $table->foreignId('court_id')->constrained()->cascadeOnDelete();
      $table->string('name'); // A, B, C
      $table->string('status')->default('active'); // active / inactive
      $table->timestamps();

      $table->unique(['court_id', 'name']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('court_units');
  }
};
