<?php
// database/migrations/xxxx_create_exchange_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single-row table: all page texts
        Schema::create('exchange_pages', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();

            $table->string('steps_badge')->nullable();
            $table->string('steps_title')->nullable();

            $table->string('calc_badge')->nullable();
            $table->string('calc_title')->nullable();
            $table->text('calc_subtitle')->nullable();
            $table->string('calc_button_text')->nullable();

            $table->string('result_badge')->nullable();
            $table->text('result_text')->nullable();          // supports {brand} {model}
            $table->string('result_shop_text')->nullable();
            $table->string('result_pickup_text')->nullable();

            $table->timestamps();
        });

        // "How it works" timeline cards
        Schema::create('exchange_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('color')->default('blue');          // blue / emerald ...
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Form dropdown options + pricing data
        // type = category | condition | age | charger
        // category  -> base_min / base_max
        // condition -> min_multiplier / max_multiplier
        Schema::create('exchange_options', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('label');
            $table->string('value');
            $table->unsignedInteger('base_min')->nullable();
            $table->unsignedInteger('base_max')->nullable();
            $table->decimal('min_multiplier', 5, 2)->default(1);
            $table->decimal('max_multiplier', 5, 2)->default(1);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index('type');
        });

        // Brand bonus rules (keyword found in brand name -> add amount). First match wins by sort_order.
        Schema::create('exchange_brand_rules', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->unsignedInteger('add_min')->default(0);
            $table->unsignedInteger('add_max')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Every valuation requested from the calculator
        Schema::create('exchange_requests', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('brand');
            $table->string('model');
            $table->string('condition');
            $table->string('age')->nullable();
            $table->string('specs')->nullable();
            $table->string('charger')->nullable();
            $table->unsignedInteger('estimated_min')->default(0);
            $table->unsignedInteger('estimated_max')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->string('status')->default('new'); // new, contacted, completed, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_requests');
        Schema::dropIfExists('exchange_brand_rules');
        Schema::dropIfExists('exchange_options');
        Schema::dropIfExists('exchange_steps');
        Schema::dropIfExists('exchange_pages');
    }
};