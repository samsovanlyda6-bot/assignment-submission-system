<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->foreignId('submission_id')->constrained('submissions', 'submission_id')->onDelete('cascade');
            $table->string('action', 50); // Submitted / Updated / Graded
            $table->foreignId('performed_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamp('performed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_history');
    }
};