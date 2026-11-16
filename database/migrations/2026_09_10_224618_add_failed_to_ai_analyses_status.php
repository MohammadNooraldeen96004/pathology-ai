<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE ai_analyses
            MODIFY status ENUM(
                'pending',
                'processing',
                'completed',
                'failed'
            ) NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::table('ai_analyses')
            ->where('status', 'failed')
            ->update([
                'status' => 'pending',
            ]);

        DB::statement("
            ALTER TABLE ai_analyses
            MODIFY status ENUM(
                'pending',
                'processing',
                'completed'
            ) NOT NULL DEFAULT 'pending'
        ");
    }
};
