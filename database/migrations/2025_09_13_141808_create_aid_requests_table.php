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
      //  جدول التبرعات

    Schema::create('aid_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('beneficiary_id')->constrained('users')->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->integer('quantity');
        $table->string('id_card_path'); //  بطاقة للمستفيد
        $table->string('address');  
        $table->string('city')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('rejection_reason')->nullable();
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
