<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // single, married, divorced, widowed
            $table->string('label')->unique();
            $table->timestamps();
        });

        // Insert default marital statuses
        DB::table('marital_statuses')->insert([
            ['code' => 'single', 'label' => 'Célibataire'],
            ['code' => 'married', 'label' => 'Marié'],
            ['code' => 'divorced', 'label' => 'Divorcé'],
            ['code' => 'widowed', 'label' => 'Veuf(ve)'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('marital_statuses');
    }
};
