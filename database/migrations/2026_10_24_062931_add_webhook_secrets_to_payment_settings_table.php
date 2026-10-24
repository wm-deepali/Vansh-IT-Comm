<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('test_webhook_secret')->nullable()->after('test_key_secret');
            $table->string('live_webhook_secret')->nullable()->after('live_key_secret');
        });
    }

    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn(['test_webhook_secret', 'live_webhook_secret']);
        });
    }

};
