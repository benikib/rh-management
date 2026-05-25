<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteres', function (Blueprint $table) {

            $table->id();

            $table->string('nom');

            $table->text('description')->nullable();

            $table->integer('note_max')->default(10);

            $table->decimal('ponderation', 5,2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteres');
    }
};