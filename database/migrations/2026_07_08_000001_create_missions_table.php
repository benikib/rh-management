<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('lieu')->nullable();
            $table->string('motif')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->decimal('frais_montant', 10, 2)->default(0);
            $table->string('statut')->default('planifiee');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
