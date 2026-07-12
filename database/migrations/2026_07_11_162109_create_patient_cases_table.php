<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_cases', function (Blueprint $table) {
            $table->id();

            // Required associations
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('case_type_id')->constrained('case_types')->restrictOnDelete();
            $table->foreignId('provider_id')->constrained('providers')->restrictOnDelete();

            // Optional association
            $table->foreignId('case_manager_id')->nullable()->constrained('case_managers')->nullOnDelete();

            // Required fixed field
            $table->unsignedTinyInteger('visit_type'); // 1 = IE, 2 = DU

            // Optional case fields
            $table->date('doa')->nullable();
            $table->string('insurance_name')->nullable();
            $table->string('claim_number')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('wcb_number')->nullable();
            $table->string('referring_office')->nullable();
            $table->string('attorney_name')->nullable();

            // Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'case_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_cases');
    }
};