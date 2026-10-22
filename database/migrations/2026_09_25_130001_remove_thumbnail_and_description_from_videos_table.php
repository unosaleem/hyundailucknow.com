<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $columns = array_filter(['thumbnail', 'description'], fn (string $column): bool => Schema::hasColumn('videos', $column));

        if ($columns) {
            Schema::table('videos', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table): void {
            if (! Schema::hasColumn('videos', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('url');
            }
            if (! Schema::hasColumn('videos', 'description')) {
                $table->text('description')->nullable()->after('thumbnail');
            }
        });
    }
};
