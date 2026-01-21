<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add worker role to users table.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('guest','worker','admin') NOT NULL DEFAULT 'guest'");
    }

    /**
     * Revert to the previous role set.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','guest') NOT NULL DEFAULT 'guest'");
    }
};
