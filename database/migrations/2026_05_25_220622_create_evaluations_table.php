<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {

            $table->id();

            $table->string('employe_matricule');

            $table->foreign('employe_matricule')
                  ->references('matricule')
                  ->on('employes')
                  ->cascadeOnDelete();

            $table->foreignId('evaluateur_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->date('date_evaluation');

            $table->decimal('note_totale', 5,2)->nullable();

            $table->text('commentaire')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};