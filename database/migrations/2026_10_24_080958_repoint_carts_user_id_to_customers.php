<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_user_id_foreign');
        });

        // Clear values that don't match a customer, or the new constraint will fail
        DB::table('carts')
            ->whereNotNull('user_id')
            ->whereNotIn('user_id', DB::table('customers')->select('id'))
            ->update(['user_id' => null]);

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('customers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }
};