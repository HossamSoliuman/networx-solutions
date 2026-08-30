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
        Schema::create('service_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('icon')->default('star');
            $table->string('accent_color', 7)->default('#0045B3');
            $table->string('badge')->nullable();
            $table->string('badge_ar')->nullable();
            $table->string('capacity')->nullable();
            $table->string('capacity_ar')->nullable();
            $table->decimal('price_monthly', 10, 2)->nullable();
            $table->decimal('price_yearly', 10, 2)->nullable();
            $table->string('price_suffix', 8)->nullable();
            $table->string('currency', 8)->default('EGP');
            $table->boolean('is_custom_price')->default(false);
            $table->string('custom_price_label')->nullable();
            $table->string('custom_price_label_ar')->nullable();
            $table->text('features')->nullable();
            $table->text('features_ar')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_label_ar')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['service_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_plans');
    }
};
