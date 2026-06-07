<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id('grade_id');
            $table->foreignId('submission_id')->constrained('submissions', 'submission_id')->onDelete('cascade');
            $table->decimal('marks_obtained', 5, 2);
            $table->string('grade', 5); // A / B / C / D / F
            $table->foreignId('graded_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamp('graded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};