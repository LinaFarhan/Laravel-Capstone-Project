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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            // اسم المتبرع
            $table->string('donor_name');

            // نوع التبرع (مثلاً: money, food, clothes)
            $table->string('type');

            // كمية التبرع
            $table->integer('quantity')->default(1);

            // حالة التبرع:

            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
