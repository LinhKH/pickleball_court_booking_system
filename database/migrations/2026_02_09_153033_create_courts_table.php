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
    Schema::create('courts', function (Blueprint $table) {
      $table->id();
      $table->foreignId('owner_id')->constrained('users');
      $table->string('name');
      $table->text('description')->nullable();
      $table->string('address');
      $table->decimal('lat', 10, 7)->nullable();
      $table->decimal('lng', 10, 7)->nullable();
      $table->time('open_time');
      $table->time('close_time');
      $table->enum('status', ['pending', 'active', 'closed'])->default('pending');
      $table->timestamps();

      $table->index(['owner_id', 'status']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('courts');
  }
};
