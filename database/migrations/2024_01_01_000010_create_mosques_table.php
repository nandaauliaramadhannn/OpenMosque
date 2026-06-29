<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mosques', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name');                   // Translatable
            $table->json('description')->nullable(); // Translatable
            $table->json('mission')->nullable();     // Translatable
            $table->json('vision')->nullable();      // Translatable
            $table->json('history')->nullable();     // Translatable
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable(); // {facebook, twitter, instagram, youtube, tiktok}
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('country_code', 5)->default('US');
            $table->string('currency', 5)->default('USD');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mosques');
    }
};
