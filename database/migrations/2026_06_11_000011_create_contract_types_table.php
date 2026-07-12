<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // cdi, cdd, stagiaire, temporaire
            $table->string('label')->unique(); // CDI, CDD, Stagiaire, Temporaire
            $table->text('description')->nullable();
            $table->boolean('requires_end_date')->default(false); // CDD, stagiaire, temporaire ont une date de fin
            $table->timestamps();
        });

        // Insert default contract types
        DB::table('contract_types')->insert([
            ['code' => 'cdi', 'label' => 'CDI', 'description' => 'Contrat à durée indéterminée', 'requires_end_date' => false],
            ['code' => 'cdd', 'label' => 'CDD', 'description' => 'Contrat à durée déterminée', 'requires_end_date' => true],
            ['code' => 'stagiaire', 'label' => 'Stagiaire', 'description' => 'Contrat de stage', 'requires_end_date' => true],
            ['code' => 'temporaire', 'label' => 'Temporaire (Période d\'essai)', 'description' => 'Contrat temporaire période d\'essai', 'requires_end_date' => true],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_types');
    }
};
