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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('event');

            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->boolean('all_day')->default(false);

            $table->string('color')->nullable();
            $table->string('status')->default('pending');

            $table->string('recurrence_rule')->nullable();
            $table->foreignId('parent_event_id')->nullable()->constrained('calendar_events')->nullOnDelete();

            $table->boolean('notification_enabled')->default(false);
            $table->integer('notification_minutes_before')->nullable();

            $table->boolean('is_shared')->default(false);
            $table->json('shared_with_users')->nullable();

            $table->string('location')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
