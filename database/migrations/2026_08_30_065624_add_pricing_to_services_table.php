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
            $table->boolean('pricing_enabled')->default(true)->after('is_active');
            $table->string('pricing_eyebrow')->nullable()->after('pricing_enabled');
            $table->string('pricing_eyebrow_ar')->nullable()->after('pricing_eyebrow');
            $table->string('pricing_title')->nullable()->after('pricing_eyebrow_ar');
            $table->string('pricing_title_ar')->nullable()->after('pricing_title');
            $table->string('pricing_subtitle')->nullable()->after('pricing_title_ar');
            $table->string('pricing_subtitle_ar')->nullable()->after('pricing_subtitle');
            $table->string('pricing_yearly_note')->nullable()->after('pricing_subtitle_ar');
            $table->string('pricing_yearly_note_ar')->nullable()->after('pricing_yearly_note');
            $table->text('pricing_footnote')->nullable()->after('pricing_yearly_note_ar');
            $table->text('pricing_footnote_ar')->nullable()->after('pricing_footnote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'pricing_enabled',
                'pricing_eyebrow',
                'pricing_eyebrow_ar',
                'pricing_title',
                'pricing_title_ar',
                'pricing_subtitle',
                'pricing_subtitle_ar',
                'pricing_yearly_note',
                'pricing_yearly_note_ar',
                'pricing_footnote',
                'pricing_footnote_ar',
            ]);
        });
    }
};
