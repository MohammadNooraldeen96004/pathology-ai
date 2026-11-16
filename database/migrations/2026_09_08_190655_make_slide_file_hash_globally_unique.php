<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Keep case_id indexed for its foreign key
        |--------------------------------------------------------------------------
        */

        Schema::table('slides', function (Blueprint $table) {
            $table->index(
                'case_id',
                'slides_case_id_index'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Remove case-scoped duplicate rule
        |--------------------------------------------------------------------------
        */

        Schema::table('slides', function (Blueprint $table) {
            $table->dropUnique(
                'slides_case_file_hash_unique'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Make slide content hash globally unique
        |--------------------------------------------------------------------------
        */

        Schema::table('slides', function (Blueprint $table) {
            $table->unique(
                'file_hash',
                'slides_file_hash_unique'
            );
        });
    }


    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Remove global uniqueness
        |--------------------------------------------------------------------------
        */

        Schema::table('slides', function (Blueprint $table) {
            $table->dropUnique(
                'slides_file_hash_unique'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Restore case-scoped uniqueness
        |--------------------------------------------------------------------------
        */

        Schema::table('slides', function (Blueprint $table) {
            $table->unique(
                ['case_id', 'file_hash'],
                'slides_case_file_hash_unique'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Composite index can now support case_id FK again
        |--------------------------------------------------------------------------
        */

        Schema::table('slides', function (Blueprint $table) {
            $table->dropIndex(
                'slides_case_id_index'
            );
        });
    }
};
