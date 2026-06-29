<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('title');                    // Translatable
            $table->string('slug')->unique();
            $table->json('body')->nullable();         // Translatable
            $table->string('template')->default('default'); // default, full-width, sidebar
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('show_in_menu')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('meta_title')->nullable();   // Translatable
            $table->json('meta_description')->nullable(); // Translatable
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
