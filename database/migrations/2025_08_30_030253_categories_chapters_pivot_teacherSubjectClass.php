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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('subject_id')->nullable();
            $table->timestamps();
        });

        Schema::create('teacher_subject_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->foreignId('teacher_subject_class_id')
                ->constrained('teacher_subject_class')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('teacher_subject_class');
        Schema::dropIfExists('chapters');
    }
};
