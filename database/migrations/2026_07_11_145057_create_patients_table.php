<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedTinyInteger('gender');
            $table->string('ssn')->nullable()->unique();
            $table->date('dob');
            $table->string('address');
            $table->string('suite_no')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('work_phone_no')->nullable();
            $table->string('phone_extension')->nullable();
            $table->string('home_phone_no')->nullable();
            $table->string('cell_phone_no');
            $table->string('emergency_contact')->nullable();
            $table->string('email')->nullable()->unique();
            $table->boolean('is_delivery_same_as_residential')->default(true);

            // delivery columns
            $table->string('d_suite')->nullable();
            $table->string('d_address')->nullable();
            $table->string('d_city')->nullable();
            $table->string('d_state')->nullable();
            $table->string('d_zip_code')->nullable();

            // foreign keys
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            // timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
