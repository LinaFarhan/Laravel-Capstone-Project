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
        Schema::create('aid_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('beneficiary_id')->constrained('users');
    $table->enum('type', ['food', 'clothing', 'medical', 'financial', 'other']);
    $table->text('description');
    $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
    $table->string('document_url')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aid_requests');
    }
};
