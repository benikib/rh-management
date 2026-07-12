<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_history_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->enum('event_type', [
                'hired', 'promoted', 'transferred', 'demoted', 'formation', 
                'leave_medical', 'leave_extended', 'deceased', 'retired', 
                'dismissed', 'resigned', 'disciplinary', 'reactivated'
            ]);
            $table->date('event_date');
            $table->foreignId('status_id')->nullable()->constrained('employee_statuses');
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->index(['employe_id', 'event_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_history_logs');
    }
};
