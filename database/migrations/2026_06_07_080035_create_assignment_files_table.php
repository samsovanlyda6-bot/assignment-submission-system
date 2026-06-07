<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_files', function (Blueprint $table) {
            $table->id('file_id');
            $table->foreignId('assignment_id')->constrained('assignments', 'assignment_id')->onDelete('cascade');
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_files');
    }
};