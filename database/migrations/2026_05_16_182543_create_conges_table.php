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
        Schema::create('conges', function (Blueprint $table) {
    $table->id();

    $table->foreignId('employe_id')
          ->constrained('employes')
          ->onDelete('cascade');

    $table->string('type_conge');

    $table->date('date_debut');

    $table->date('date_fin');

    $table->text('motif')->nullable();

    $table->enum('statut', [
        'En attente',
        'Valide',
        'Refuse'
    ])->default('En attente');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
