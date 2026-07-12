<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_monthly_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->foreignId('departement_id')->constrained('departements');
            $table->year('year');
            $table->unsignedTinyInteger('month');
            $table->decimal('performance_score', 5, 2)->nullable();
            $table->decimal('attendance_score', 5, 2)->nullable();
            $table->decimal('productivity_score', 5, 2)->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
            $table->unique(['employe_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_monthly_ratings');
    }
};
