<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id('submission_id');
            $table->foreignId('assignment_id')->constrained('assignments', 'assignment_id')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->text('submission_text')->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->boolean('is_late')->default(false);
            $table->enum('status', ['Submitted', 'Resubmitted', 'Graded'])->default('Submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};