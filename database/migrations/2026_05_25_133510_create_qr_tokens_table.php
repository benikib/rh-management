<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->enum('type', ['arrivee', 'depart']);
            $table->date('date_validite');
            $table->dateTime('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamps();
            
            $table->index(['type', 'date_validite']);
            $table->index('token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_tokens');
    }
};