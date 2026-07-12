<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_position_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->foreignId('poste_id')->constrained('postes');
            $table->foreignId('departement_id')->constrained('departements');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('observations')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->enum('status', ['active', 'completed', 'transferred'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_position_history');
    }
};
