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
        Schema::table('users', function (Blueprint $table) {
      $table->enum('role', ['admin', 'volunteer', 'beneficiary'])->default('beneficiary');
    $table->string('phone')->nullable();
    $table->text('address')->nullable();
    $table->string('document_path')->nullable(); // للمستفيدين
        });
    }

    /**
     * Reverse the migrations.
     */
 public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'phone', 'address', 'document_path']);
    });
}
};
