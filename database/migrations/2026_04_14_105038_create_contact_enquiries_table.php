<?php
// database/migrations/xxxx_create_contact_enquiries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile', 20);
            $table->string('company')->nullable();
            $table->string('inquiry_type')->nullable();
            $table->text('message');
            $table->string('status')->default('new'); // new, read, replied
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_enquiries');
    }
};