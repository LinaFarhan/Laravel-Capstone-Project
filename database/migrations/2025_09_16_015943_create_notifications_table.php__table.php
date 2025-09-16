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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // المستخدم الذي يستقبل الإشعار
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // نص الإشعار
            $table->text('message');

            // نوع الإشعار (مثلاً: info, warning, success, error)
            $table->string('type')->default('info');

            // حالة الإشعار: unread / read
            $table->enum('status', ['unread', 'read'])->default('unread');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
