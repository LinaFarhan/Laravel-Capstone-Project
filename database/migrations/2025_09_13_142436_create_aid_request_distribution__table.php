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
//جدولوسيط بين الطلب والتوزيعات
    Schema::create('aid_request_distribution', function (Blueprint $table) {
        $table->id();
        $table->foreignId('aid_request_id')->constrained()->onDelete('cascade');
        $table->foreignId('distribution_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aid_request_distribution_');
    }
};
