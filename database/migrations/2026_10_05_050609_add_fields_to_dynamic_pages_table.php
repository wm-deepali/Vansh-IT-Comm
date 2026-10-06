<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dynamic_pages', function (Blueprint $table) {
            $table->boolean('show_in_policies')->default(false)->after('status');
            $table->unsignedInteger('sort_order')->default(0)->after('show_in_policies');
            $table->string('icon')->nullable()->after('sort_order');
            $table->string('badge')->nullable()->after('icon');
            $table->string('summary', 300)->nullable()->after('badge');
        });
    }

    public function down()
    {
        Schema::table('dynamic_pages', function (Blueprint $table) {
            $table->dropColumn(['show_in_policies', 'sort_order', 'icon', 'badge', 'summary']);
        });
    }
};