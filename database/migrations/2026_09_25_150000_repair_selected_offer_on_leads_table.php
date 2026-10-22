<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('leads') || Schema::hasColumn('leads', 'selected_offer_id')) {
            return;
        }

        Schema::table('leads', function (Blueprint $table): void {
            $table->foreignId('selected_offer_id')
                ->nullable()
                ->after('model')
                ->constrained('offers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('leads') || ! Schema::hasColumn('leads', 'selected_offer_id')) {
            return;
        }

        Schema::table('leads', function (Blueprint $table): void {
            $table->dropForeign(['selected_offer_id']);
            $table->dropColumn('selected_offer_id');
        });
    }
};
