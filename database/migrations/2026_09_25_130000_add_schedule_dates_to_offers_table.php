<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table): void {
            if (! Schema::hasColumn('offers', 'starts_at')) {
                $table->date('starts_at')->nullable();
            }
            if (! Schema::hasColumn('offers', 'ends_at')) {
                $table->date('ends_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table): void {
            if (Schema::hasColumn('offers', 'starts_at')) $table->dropColumn('starts_at');
            if (Schema::hasColumn('offers', 'ends_at')) $table->dropColumn('ends_at');
        });
    }
};
