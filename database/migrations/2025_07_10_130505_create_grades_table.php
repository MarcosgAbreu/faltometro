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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira para a matéria
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            $table->string('name'); // Ex: "P1"
            $table->decimal('weight', 5, 2); // Peso. Ex: 0.40 (40%). Precisão de 5 dígitos, 2 casas decimais.
            $table->decimal('value', 5, 2)->nullable(); // Nota. Ex: 7.50. Pode ser nula.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
