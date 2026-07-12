<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_dependents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->string('full_name');
            $table->enum('type', ['child', 'dependent'])->default('child');
            $table->date('birth_date')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('school_certificate_path')->nullable(); // attestation de scolarité
            $table->string('family_composition_document')->nullable(); // document composition familiale
            $table->boolean('is_student')->default(false);
            $table->boolean('is_schooled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_dependents');
    }
};
