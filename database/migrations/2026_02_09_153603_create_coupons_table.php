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
    Schema::create('coupons', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->enum('discount_type', ['percent', 'fixed']);
      $table->decimal('discount_value', 10, 2);
      $table->decimal('max_discount', 10, 2)->nullable();
      $table->integer('usage_limit')->nullable();
      $table->timestamp('expired_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('coupons');
  }
};
