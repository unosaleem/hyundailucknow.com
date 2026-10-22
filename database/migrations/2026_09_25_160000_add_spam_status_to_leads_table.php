<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Status is intentionally a string so existing installations remain portable
        // across SQLite/MySQL and can add future workflow states without enum changes.
        Schema::table('leads', function (Blueprint $table): void {
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->dropIndex(['leads_status_created_at_index']);
        });
    }
};
