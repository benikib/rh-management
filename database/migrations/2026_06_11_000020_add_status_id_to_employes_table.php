<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employes', function (Blueprint $table) {
            // Add status_id if not exists
            if (!Schema::hasColumn('employes', 'status_id')) {
                $table->foreignId('status_id')->nullable()->constrained('employee_statuses')->after('statut');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employes', function (Blueprint $table) {
            if (Schema::hasColumn('employes', 'status_id')) {
                $table->dropForeignIdFor('EmployeeStatus');
                $table->dropColumn('status_id');
            }
        });
    }
};
