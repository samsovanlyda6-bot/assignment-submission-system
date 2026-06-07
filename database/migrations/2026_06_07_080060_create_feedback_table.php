<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->foreignId('submission_id')->constrained('submissions', 'submission_id')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};