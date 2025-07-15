<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira para conectar a falta à matéria
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            $table->date('absence_date'); // A data em que a falta ocorreu
            $table->unsignedInteger('quantity')->default(1); // Quantas faltas? Geralmente 1 ou 2 (para aulas duplas)
            $table->string('description')->nullable(); // Uma descrição opcional (ex: "Prova surpresa")

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
