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
        Schema::create('employe_competences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes')
                ->onDelete('cascade');

            $table->foreignId('competence_id')
                ->constrained('competences')
                ->onDelete('cascade');

            $table->enum('niveau', ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'])
                ->default('Intermédiaire');

            $table->date('date_acquisition')->nullable();

            $table->timestamps();

            $table->unique(['employe_id', 'competence_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employe_competences');
    }
};
