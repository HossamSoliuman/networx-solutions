<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var array<string, array<string, mixed>> $translations */
        $translations = require database_path('seeders/data/service-translations.php');

        foreach ($translations as $slug => $translation) {
            DB::table('services')
                ->where('slug', $slug)
                ->update([
                    'name_ar' => $translation['name'] ?? null,
                    'excerpt_ar' => $translation['excerpt'] ?? null,
                    'description_ar' => $translation['description'] ?? null,
                    'benefits_ar' => implode("\n", $translation['benefits'] ?? []),
                    'details_ar' => json_encode([
                        'statement' => $translation['statement'] ?? null,
                        'service_items' => $translation['service_items'] ?? [],
                        'reasons' => $translation['reasons'] ?? [],
                    ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('services')->update([
            'name_ar' => null,
            'excerpt_ar' => null,
            'description_ar' => null,
            'benefits_ar' => null,
            'details_ar' => null,
        ]);
    }
};
