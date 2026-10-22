<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->foreignId('selected_offer_id')->nullable()->after('model')->constrained('offers')->nullOnDelete();
            $table->string('model')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->dropForeign(['selected_offer_id']);
            $table->dropColumn('selected_offer_id');
            $table->string('model')->nullable(false)->change();
        });
    }
};
