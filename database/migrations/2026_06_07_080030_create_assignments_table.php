<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->decimal('total_marks', 5, 2);
            $table->datetime('start_date');
            $table->datetime('due_date');
            $table->boolean('allow_late_submission')->default(false);
            $table->foreignId('created_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->enum('status', ['Draft', 'Published', 'Closed'])->default('Draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};