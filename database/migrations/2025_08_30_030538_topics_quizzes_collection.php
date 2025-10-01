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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_subject_class_id')
                ->constrained('teacher_subject_class')
                ->cascadeOnDelete();
            $table->text('body');
            $table->dateTime('deadline');
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            // 1 to 1 relation with topic
            $table->foreignId('topic_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            // pivot teacher_subject_class
            $table->foreignId('teacher_subject_class_id')
                ->constrained('teacher_subject_class')
                ->cascadeOnDelete();
            $table->text('body')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('topics');
    }
};
