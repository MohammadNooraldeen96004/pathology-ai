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
        Schema::create('ai_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slide_id')
                ->unique()
                ->constrained('slides')
                ->cascadeOnDelete();
            $table->string('model_version')->nullable();
            $table->decimal('score', 5, 4)->nullable(); // مثال: 0.8750
            $table->string('prediction')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed'])->default('pending');
            $table->timestamp('analyzed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_analyses');
    }
};
