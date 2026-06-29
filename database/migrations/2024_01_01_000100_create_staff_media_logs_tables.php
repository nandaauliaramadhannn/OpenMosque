<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name');                     // Translatable
            $table->json('role_title');               // Translatable (Imam, Muezzin, etc.)
            $table->json('bio')->nullable();          // Translatable
            $table->string('photo_path')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');
            $table->string('path');
            $table->string('disk')->default('public');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->json('alt_text')->nullable();     // Translatable
            $table->json('caption')->nullable();      // Translatable
            $table->string('collection')->default('general'); // gallery, document, general, slider
            $table->nullableUuidMorphs('mediable');    // Polymorphic: model_type + model_id
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('collection');
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');                 // created, updated, deleted, login, logout
            $table->string('model_type')->nullable();
            $table->uuid('model_id')->nullable();
            $table->string('description')->nullable();
            $table->json('changes')->nullable();      // {before: {...}, after: {...}}
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('media');
        Schema::dropIfExists('staff');
    }
};
