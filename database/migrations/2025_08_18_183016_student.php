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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id');
            $table->string('domisili');
            $table->string('nis', 10)->nullable();
            $table->string('phone', 12);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->string('wali');
            $table->string('alamat');
            $table->date('angkatan')->nullable();
            $table->string('agama');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
