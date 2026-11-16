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
        Schema::table('slides', function (Blueprint $table) {
            $table->string('file_hash', 64)->nullable()->after('storage_path');

            $table->unique(
                ['case_id', 'file_hash'],
                'slides_case_file_hash_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropUnique('slides_case_file_hash_unique');
            $table->dropColumn('file_hash');
        });
    }
};
