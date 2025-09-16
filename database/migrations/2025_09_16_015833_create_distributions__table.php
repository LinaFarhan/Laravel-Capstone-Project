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

            // المتطوع المسؤول عن التوزيع
            $table->foreignId('volunteer_id')->constrained('users')->onDelete('cascade');

            // المستفيد الذي يستلم المساعدة
            $table->foreignId('beneficiary_id')->constrained('users')->onDelete('cascade');

            // التبرع الموزع
            $table->foreignId('donation_id')->constrained('donations')->onDelete('cascade');

            // حالة التسليم: pending, delivered, failed
            $table->enum('delivery_status', ['pending', 'delivered', 'failed'])->default('pending');

            // ملف إثبات التسليم (صورة أو مستند)
            $table->string('proof_file')->nullable();

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
