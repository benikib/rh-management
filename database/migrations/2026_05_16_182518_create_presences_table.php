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
      Schema::create('presences', function (Blueprint $table) {
    $table->id();

    $table->foreignId('employe_id')
          ->constrained('employes')
          ->onDelete('cascade');

    $table->date('date_presence');

    $table->time('heure_arrivee')->nullable();

    $table->time('heure_depart')->nullable();

    $table->enum('statut', [
        'Present',
        'Absent',
        'Retard',
        'Conge'
    ]);

    $table->text('remarque')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
