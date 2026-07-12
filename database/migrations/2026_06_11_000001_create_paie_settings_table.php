<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paie_settings', function (Blueprint $table) {
            $table->id();
            $table->string('calculation_method')->default('pro_rata');
            $table->integer('jours_travail_par_mois')->default(22);
            $table->integer('heures_par_jour')->default(8);
            $table->decimal('overtime_multiplier', 5, 2)->default(1.5);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paie_settings');
    }
};
