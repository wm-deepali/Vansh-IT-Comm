<?php
// database/migrations/xxxx_create_repair_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single-row table: page texts
        Schema::create('repair_pages', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_primary_text')->nullable();
            $table->string('hero_secondary_text')->nullable();

            $table->string('booking_badge')->nullable();
            $table->string('booking_title')->nullable();
            $table->text('booking_description')->nullable();
            $table->string('booking_note')->nullable();

            $table->timestamps();
        });

        // "Laptop Repair Services", "Mobile Repair Services"
        Schema::create('repair_categories', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Service cards inside a category
        Schema::create('repair_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_category_id')->constrained('repair_categories')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('estimated_time')->nullable();
            $table->string('icon')->default('fa-solid fa-screwdriver-wrench');
            $table->string('color')->default('blue');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Booking form dropdown options: device_type / issue / service_mode
        Schema::create('repair_options', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('label');
            $table->string('value');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Submitted bookings
        Schema::create('repair_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->nullable()->unique();
            $table->string('name');
            $table->string('mobile', 20);
            $table->string('device_type')->nullable();
            $table->string('brand');
            $table->string('model')->nullable();
            $table->string('issue')->nullable();
            $table->string('service_mode')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('new'); // new, contacted, in_progress, completed, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_bookings');
        Schema::dropIfExists('repair_options');
        Schema::dropIfExists('repair_services');
        Schema::dropIfExists('repair_categories');
        Schema::dropIfExists('repair_pages');
    }
};