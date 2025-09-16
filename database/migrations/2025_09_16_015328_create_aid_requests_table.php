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

            // العلاقة مع المستخدم المستفيد
            $table->foreignId('beneficiary_id')->constrained('users')->onDelete('cascade');

            // نوع الطلب (مثلاً: medical, food, education ...)
              $table->enum('type', ['medical', 'financial', 'food', 'shelter']);
            // وصف الطلب
            $table->text('description');

            // حالة الطلب: pending / approved / denied
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');

            // ملف مرفق (مثلاً تقرير أو وثيقة)
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
