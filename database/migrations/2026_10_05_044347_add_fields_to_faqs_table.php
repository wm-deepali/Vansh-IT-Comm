<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('category')->nullable()->after('answer')->index();
            $table->unsignedInteger('sort_order')->default(0)->after('category');
        });
    }

    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['category', 'sort_order']);
        });
    }
};