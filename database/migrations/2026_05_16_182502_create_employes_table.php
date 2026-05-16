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
        Schema::create('employes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('departement_id')
          ->constrained('departements')
          ->onDelete('cascade');

    $table->foreignId('poste_id')
          ->constrained('postes')
          ->onDelete('cascade');

    $table->string('matricule')->unique();

    $table->string('nom');
    $table->string('postnom');
    $table->string('prenom');

    $table->enum('sexe', ['Masculin', 'Feminin']);

    $table->date('date_naissance')->nullable();

    $table->string('telephone')->nullable();

    $table->string('email')->unique();

    $table->text('adresse')->nullable();

    $table->string('photo')->nullable();

    $table->date('date_embauche');

    $table->decimal('salaire_base', 10, 2);

    $table->enum('statut', ['Actif', 'Inactif'])
          ->default('Actif');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
