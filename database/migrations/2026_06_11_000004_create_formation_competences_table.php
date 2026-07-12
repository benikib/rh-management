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
        Schema::create('formation_competences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('formation_id')
                ->constrained('formations')
                ->onDelete('cascade');

            $table->foreignId('competence_id')
                ->constrained('competences')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['formation_id', 'competence_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation_competences');
    }
};
