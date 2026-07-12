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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes')
                ->onDelete('cascade');

            $table->string('titre');
            $table->text('description')->nullable();

            $table->string('organisme_formation');

            $table->date('date_debut');
            $table->date('date_fin');

            $table->integer('duree_heures')->nullable();

            $table->string('certificat')->nullable();

            $table->decimal('cout', 10, 2)->nullable();

            $table->text('observations')->nullable();

            $table->enum('statut', ['Planifiée', 'En cours', 'Terminée', 'Annulée'])
                ->default('Planifiée');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
