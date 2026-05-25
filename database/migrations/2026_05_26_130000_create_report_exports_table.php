<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_exports', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('report_type');
            $table->string('report_name');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->json('filters')->nullable();
            $table->unsignedBigInteger('employe_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->enum('status', ['generated', 'failed'])->default('generated');
            $table->timestamps();

            $table->foreign('employe_id')->references('id')->on('employes')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departements')->nullOnDelete();
            $table->foreign('direction_id')->references('id')->on('directions')->nullOnDelete();
            $table->foreign('generated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_exports');
    }
};
