<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('calculation_method')->default('MWL'); // MWL, ISNA, Egypt, Makkah, Karachi, Tehran, Jafari
            $table->string('asr_method')->default('Standard');     // Standard (Shafi), Hanafi
            $table->json('adjustments')->nullable();                // {fajr: 0, dhuhr: 0, asr: 0, maghrib: 0, isha: 0}
            $table->json('iqamah_offsets')->nullable();             // {fajr: "+15", dhuhr: "+10", ...} minutes after adhan
            $table->json('iqamah_fixed')->nullable();               // {fajr: "05:30", dhuhr: "13:15", ...} fixed times
            $table->boolean('use_iqamah_fixed')->default(false);
            $table->string('jumuah_time')->nullable();              // e.g., "12:30"
            $table->string('jumuah_khutbah_time')->nullable();      // e.g., "12:00"
            $table->boolean('is_auto_calculated')->default(true);
            $table->timestamps();
        });

        Schema::create('prayer_times', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date')->unique();
            $table->time('fajr')->nullable();
            $table->time('sunrise')->nullable();
            $table->time('dhuhr')->nullable();
            $table->time('asr')->nullable();
            $table->time('maghrib')->nullable();
            $table->time('isha')->nullable();
            $table->time('iqamah_fajr')->nullable();
            $table->time('iqamah_dhuhr')->nullable();
            $table->time('iqamah_asr')->nullable();
            $table->time('iqamah_maghrib')->nullable();
            $table->time('iqamah_isha')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->boolean('is_ramadan')->default(false);
            $table->timestamps();

            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
        Schema::dropIfExists('prayer_settings');
    }
};
