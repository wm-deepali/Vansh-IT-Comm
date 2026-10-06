<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Section headings (eyebrow / title / subtitle / "view all" link) + show/hide toggle
        Schema::create('home_section_headings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // categories, featured_1, budget, guided, accessories, brands, refurbish, why_us, store_locations, faq ...
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('link_text')->nullable();
            $table->string('link_route')->nullable(); // named route e.g. shop
            $table->string('link_url')->nullable();   // fallback raw URL
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Hero slider
        Schema::create('home_hero_slides', function (Blueprint $table) {
            $table->id();
            // left side
            $table->string('badge_text')->nullable();
            $table->string('badge_icon')->nullable();          // fa-bolt
            $table->string('theme')->default('blue');          // blue, emerald, purple, amber, rose, indigo ...
            $table->string('title_line_1');
            $table->string('title_highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('btn_primary_text')->nullable();
            $table->string('btn_primary_icon')->nullable();
            $table->string('btn_primary_route')->nullable();
            $table->string('btn_primary_url')->nullable();
            $table->string('btn_secondary_text')->nullable();
            $table->string('btn_secondary_icon')->nullable();
            $table->string('btn_secondary_route')->nullable();
            $table->string('btn_secondary_url')->nullable();
            $table->string('link_text')->nullable();
            $table->string('link_route')->nullable();
            $table->string('link_url')->nullable();
            $table->json('trust_points')->nullable();          // [{"icon":"fa-circle-check","color":"text-emerald-400","text":"Up to 12-Mo Warranty"}]
            // right side product card
            $table->string('card_image')->nullable();
            $table->string('card_image_alt')->nullable();
            $table->string('card_top_badge')->nullable();      // "Best Seller • 64% OFF"
            $table->string('card_bottom_badge')->nullable();   // "20-Point Verified"
            $table->string('card_label')->nullable();          // "Enterprise Grade"
            $table->string('card_title')->nullable();
            $table->string('card_subtitle')->nullable();
            $table->string('card_old_price')->nullable();
            $table->string('card_price')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Small icon cards: trust strip + "Why choose us"
        Schema::create('home_features', function (Blueprint $table) {
            $table->id();
            $table->string('section');                         // trust_strip | why_us
            $table->string('icon');
            $table->string('color')->default('blue');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['section', 'is_active', 'sort_order']);
        });

        // 4. "Shop laptops by budget" cards
        Schema::create('home_budget_cards', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();               // Entry & Students
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('min_price')->nullable();
            $table->unsignedInteger('max_price')->nullable();
            $table->string('button_text')->default('View Products →');
            $table->string('gradient')->nullable();            // from-blue-900 to-slate-900
            $table->string('label_color')->nullable();         // text-emerald-400
            $table->string('button_color')->nullable();        // bg-blue-600
            $table->foreignId('category_id')->nullable();      // optional category filter
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Guided recommendation ("What's right for you?")
        Schema::create('home_guided_options', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('color')->default('blue');
            $table->string('badge')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('features')->nullable();              // ["<strong>8GB to 32GB</strong> RAM options", ...]
            $table->string('button_text');
            $table->string('button_route')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. How we refurbish (step number comes from sort_order / loop index)
        Schema::create('home_process_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('color')->default('blue');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Banner / CTA blocks: brand_philosophy, repair_cta, exchange_cta, final_cta
        Schema::create('home_cta_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('badge_text')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('btn_1_text')->nullable();
            $table->string('btn_1_icon')->nullable();
            $table->string('btn_1_route')->nullable();
            $table->string('btn_1_url')->nullable();
            $table->string('btn_2_text')->nullable();
            $table->string('btn_2_icon')->nullable();
            $table->string('btn_2_route')->nullable();
            $table->string('btn_2_url')->nullable();
            $table->string('btn_3_text')->nullable();
            $table->string('btn_3_icon')->nullable();
            $table->string('btn_3_route')->nullable();
            $table->string('btn_3_url')->nullable();
            // list content: philosophy points (icon/color/text), repair "common fast fixes" (icon/color/text/tag) ...
            $table->json('items')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Store locations / hubs
        Schema::create('home_store_locations', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('color')->default('blue');
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->json('details')->nullable();               // [{"icon":"fa-regular fa-clock","text":"Mon – Sat: 10:00 AM – 8:30 PM"}]
            $table->string('button_text')->nullable();
            $table->string('button_route')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_store_locations');
        Schema::dropIfExists('home_cta_blocks');
        Schema::dropIfExists('home_process_steps');
        Schema::dropIfExists('home_guided_options');
        Schema::dropIfExists('home_budget_cards');
        Schema::dropIfExists('home_features');
        Schema::dropIfExists('home_hero_slides');
        Schema::dropIfExists('home_section_headings');
    }
};