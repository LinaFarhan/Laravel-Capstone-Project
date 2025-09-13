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
//جدول التوزيعات
    Schema::create('distributions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('volunteer_id')->constrained('users')->onDelete('cascade');
        $table->string('title');
        $table->string('location');
        $table->dateTime('distribution_date');
        $table->enum('status', ['scheduled', 'in_progress', 'completed'])->default('scheduled');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions_');
    }
};
