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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('case_number')->unique(); // CASE-112
            $table->string('specialization')->nullable();
            $table->string('icd10')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('diff_diagnostic')->nullable();
            $table->text('grossing')->nullable();
            $table->text('micro_protocol')->nullable();
            $table->text('additional_info')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
