<?php
// database/migrations/xxxx_create_about_page_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single-row table: all the page-level texts
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();

            // Who we are
            $table->string('who_badge')->nullable();
            $table->string('who_title')->nullable();
            $table->text('who_description')->nullable(); // paragraphs separated by a blank line
            $table->string('who_image')->nullable();

            // Testing section
            $table->string('testing_badge')->nullable();
            $table->string('testing_title')->nullable();
            $table->text('testing_description')->nullable();

            // Bottom banner of the testing section
            $table->string('banner_title')->nullable();
            $table->text('banner_text')->nullable();
            $table->string('banner_button_text')->nullable();
            $table->string('banner_button_url')->nullable();

            $table->timestamps();
        });

        // "20+ Diagnostic Checkpoints", "100% GST Invoice Compliant"
        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('label');
            $table->string('color')->default('blue');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Core Computing / Display & Optics / Power & Ports
        Schema::create('about_test_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->default('fa-solid fa-microchip');
            $table->string('color')->default('blue');
            $table->string('footer_icon')->nullable();
            $table->string('footer_label')->nullable();
            $table->string('footer_value')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Checklist lines inside each group
        Schema::create('about_test_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_test_group_id')->constrained('about_test_groups')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // No False Claims / Secure Packaging / Dedicated Support
        Schema::create('about_commitments', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('fa-solid fa-shield-halved');
            $table->string('color')->default('blue');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_commitments');
        Schema::dropIfExists('about_test_items');
        Schema::dropIfExists('about_test_groups');
        Schema::dropIfExists('about_stats');
        Schema::dropIfExists('about_pages');
    }
};