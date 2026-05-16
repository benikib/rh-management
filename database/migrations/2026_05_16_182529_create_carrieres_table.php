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
       Schema::create('carrieres', function (Blueprint $table) {
    $table->id();

    $table->foreignId('employe_id')
          ->constrained('employes')
          ->onDelete('cascade');

    $table->foreignId('ancien_poste_id')
          ->nullable()
          ->constrained('postes')
          ->nullOnDelete();

    $table->foreignId('nouveau_poste_id')
          ->constrained('postes')
          ->onDelete('cascade');

    $table->enum('type_mouvement', [
        'Promotion',
        'Mutation'
    ]);

    $table->date('date_changement');

    $table->text('commentaire')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrieres');
    }
};
