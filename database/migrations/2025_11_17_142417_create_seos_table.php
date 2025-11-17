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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->string('gtm_id')->nullable();     // Google Tag Manager ID
            $table->string('ga4_id')->nullable();
            $table->string('meta_pixel_id')->nullable(); // Meta Pixel ID
            $table->string('meta_access_token')->nullable();
            $table->string('meta_test_event_code')->nullable(); // optional for testing
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
