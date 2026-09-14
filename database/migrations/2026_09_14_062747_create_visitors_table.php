<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->index();
            $table->string('session_id')->nullable()->index();
            $table->string('country')->default('Unknown');
            $table->string('country_code', 5)->default('XX');
            $table->string('city')->default('Unknown');
            $table->string('isp')->default('Unknown');
            $table->string('device_type', 20)->default('Desktop')->index();
            $table->string('operating_system', 50)->default('Unknown');
            $table->string('browser', 50)->default('Unknown');
            $table->string('screen_resolution', 30)->default('Unknown');
            $table->string('visited_route')->default('/')->index();
            $table->string('method', 10)->default('GET');
            $table->text('referrer')->nullable();
            $table->unsignedInteger('hits')->default(1);
            $table->timestamp('last_activity_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
