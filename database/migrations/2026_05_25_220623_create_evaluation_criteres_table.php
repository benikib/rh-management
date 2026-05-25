<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_criteres', function (Blueprint $table) {

            $table->id();

            $table->foreignId('evaluation_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('critere_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal('note', 5,2);

            $table->text('observation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteres');
    }
};