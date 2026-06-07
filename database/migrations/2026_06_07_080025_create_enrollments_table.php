<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id('enrollment_id');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};