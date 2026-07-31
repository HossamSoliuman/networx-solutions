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
        Schema::table('services', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name');
            $table->string('excerpt_ar')->nullable()->after('excerpt');
            $table->text('description_ar')->nullable()->after('description');
            $table->text('benefits_ar')->nullable()->after('benefits');
            $table->json('details_ar')->nullable()->after('details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'name_ar',
                'excerpt_ar',
                'description_ar',
                'benefits_ar',
                'details_ar',
            ]);
        });
    }
};
