<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('tags')->nullable()->after('slug');
            $table->unsignedTinyInteger('read_time')->nullable()->after('tags');
            $table->string('author_name')->nullable()->after('content');
            $table->string('author_role')->nullable()->after('author_name');
            $table->string('author_image')->nullable()->after('author_role');
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['tags', 'read_time', 'author_name', 'author_role', 'author_image']);
        });
    }
};