<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // mis_a_pied, disponibilite, suspension, revocation, deces, retraite
            $table->string('label')->unique(); // Mis à pied disciplinaire, etc
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('employee_statuses')->insert([
            ['code' => 'mis_a_pied', 'label' => 'Mis à pied disciplinaire', 'description' => 'Statut disciplinaire'],
            ['code' => 'disponibilite', 'label' => 'Mis en disponibilité', 'description' => 'Employé en disponibilité'],
            ['code' => 'suspension', 'label' => 'Suspension', 'description' => 'Employé suspendu'],
            ['code' => 'revocation', 'label' => 'Révocation', 'description' => 'Employé révoqué'],
            ['code' => 'deces', 'label' => 'Décédé', 'description' => 'Employé décédé'],
            ['code' => 'retraite', 'label' => 'Retraité', 'description' => 'Employé à la retraite'],
            ['code' => 'actif', 'label' => 'Actif', 'description' => 'Employé actif'],
            ['code' => 'formation', 'label' => 'En formation', 'description' => 'Employé en formation'],
            ['code' => 'maladie', 'label' => 'Arrêt maladie', 'description' => 'Employé en arrêt maladie'],
            ['code' => 'demission', 'label' => 'Démission', 'description' => 'Employé ayant démissionné'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_statuses');
    }
};
