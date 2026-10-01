<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // Brand belongs to the product only (not to categories)
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('sku')->nullable();

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            // ── Electronics fields ──
            $table->string('condition', 50)->nullable();          // New / Refurbished / Open Box
            $table->string('warranty')->nullable();               // e.g. "12 Month Warranty"

            $table->longText('condition_details')->nullable();    // Condition & QC tab
            $table->longText('warranty_coverage')->nullable();    // Warranty & Coverage tab
            $table->longText('shipping_delivery')->nullable();    // Shipping & Delivery tab

            $table->json('key_specs')->nullable();                // [{label, value}, ...]

            // Trust & Services
            $table->boolean('warranty_backed')->default(true);
            $table->boolean('seven_day_returns')->default(true);
            $table->boolean('insured_transit')->default(true);
            $table->boolean('video_call_demo')->default(true);

            // ── Pricing ──
            $table->decimal('mrp', 12, 2)->default(0);

            $table->enum('discount_type', [
                'amount',
                'percentage'
            ])->default('amount');

            $table->decimal('discount', 12, 2)->default(0);

            $table->decimal('price', 12, 2)->default(0);

            // ── Inventory ──
            $table->integer('stock')->default(0);

            $table->integer('min_qty')->default(1);

            $table->string('delivery_time')->nullable();

            $table->boolean('quality')->default(false);

            $table->boolean('pan_india')->default(false);

            // ── SEO ──
            $table->string('meta_title')->nullable();

            $table->text('meta_description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};