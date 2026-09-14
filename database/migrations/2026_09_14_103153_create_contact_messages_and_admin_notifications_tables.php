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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no', 30)->unique();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 30)->nullable();
            $table->string('subject', 150);
            $table->string('issue_type', 50)->default('Technical Support');
            $table->text('description');
            $table->string('screenshot')->nullable();
            $table->string('status', 30)->default('new'); // new, seen, in_progress, fixed
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->default('contact_message');
            $table->string('title', 150);
            $table->text('message');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
        Schema::dropIfExists('contact_messages');
    }
};
