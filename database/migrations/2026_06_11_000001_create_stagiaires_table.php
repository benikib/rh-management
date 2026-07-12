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
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();

            $table->foreignId('departement_id')
                ->constrained('departements')
                ->onDelete('cascade');

            $table->string('nom');
            $table->string('postnom');
            $table->string('prenom');

            $table->enum('sexe', ['Masculin', 'Feminin']);

            $table->date('date_naissance')->nullable();

            $table->string('telephone')->nullable();

            $table->string('email')->nullable();

            $table->text('adresse')->nullable();

            $table->string('photo')->nullable();

            $table->string('universite');
            $table->string('specialite');

            $table->date('date_debut_stage');
            $table->date('date_fin_stage');

            $table->foreignId('encadrant_id')
                ->nullable()
                ->constrained('employes')
                ->onDelete('set null');

            $table->text('observations')->nullable();

            $table->enum('statut', ['En cours', 'Terminé', 'Suspendu'])
                ->default('En cours');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
