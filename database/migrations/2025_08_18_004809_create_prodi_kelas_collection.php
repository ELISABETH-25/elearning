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
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kode');
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tingkat');
            $table->foreignId('prodi_id')->constrained()->cascadeOnDelete();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('kelas');
    }
};
