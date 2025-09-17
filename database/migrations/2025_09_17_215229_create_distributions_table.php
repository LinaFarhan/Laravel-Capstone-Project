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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
    $table->foreignId('volunteer_id')->constrained('users');
    $table->foreignId('beneficiary_id')->constrained('users');
    $table->foreignId('donation_id')->constrained('donations');
    $table->enum('delivery_status', ['assigned', 'in_progress', 'delivered', 'cancelled']);
    $table->string('proof_file')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
