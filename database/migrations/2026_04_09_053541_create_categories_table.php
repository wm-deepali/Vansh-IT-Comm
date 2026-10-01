<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sub_title')->nullable();      // card description on storefront
            $table->string('icon', 60)->nullable();       // Font Awesome class, e.g. fa-laptop

            // Hierarchy
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // Media
            $table->string('image')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Flags
            $table->boolean('status')->default(1);
            $table->boolean('is_popular')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('show_in_navbar')->default(0);

            // Meta
            $table->integer('sort_order')->default(0);
            $table->string('added_by')->default('admin');

            $table->boolean('is_sub_category')->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Indexes for the storefront queries
            $table->index(['status', 'parent_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};