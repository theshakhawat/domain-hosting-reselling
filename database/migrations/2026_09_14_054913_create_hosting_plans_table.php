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
        Schema::create('hosting_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category', 30); // shared, cloud, vps, bdix
            $table->string('tagline')->nullable();
            $table->integer('monthly_price')->default(0);
            $table->integer('yearly_price')->default(0);
            $table->string('badge')->nullable(); // e.g. RECOMMENDED, MOST POPULAR
            $table->json('features')->nullable(); // array of features
            $table->string('websites')->nullable();
            $table->string('storage')->nullable();
            $table->string('bandwidth')->nullable();
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category', 'is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_plans');
    }
};
