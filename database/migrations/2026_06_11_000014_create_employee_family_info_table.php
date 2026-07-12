<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_family_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->foreignId('marital_status_id')->constrained('marital_statuses');
            $table->string('spouse_name')->nullable();
            $table->string('spouse_identity')->nullable(); // numero identite
            $table->date('marriage_date')->nullable();
            $table->string('marriage_certificate_path')->nullable();
            $table->integer('number_of_children')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_family_info');
    }
};
