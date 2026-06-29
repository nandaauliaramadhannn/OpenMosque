<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('title');                    // Translatable
            $table->string('slug')->unique();
            $table->json('description')->nullable();  // Translatable
            $table->foreignUuid('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignUuid('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->json('location')->nullable();     // Translatable
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->integer('max_attendees')->nullable();
            $table->integer('current_attendees')->default(0);
            $table->boolean('registration_required')->default(false);
            $table->string('registration_url')->nullable();
            $table->json('speaker')->nullable();       // Translatable
            $table->timestamps();

            $table->index(['is_published', 'start_date']);
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['registered', 'confirmed', 'cancelled', 'attended'])->default('registered');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('events');
    }
};
