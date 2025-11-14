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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->text('about_content')->nullable();
            $table->text('image')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('why_buy_1')->nullable();
            $table->string('why_buy_2')->nullable();
            $table->string('why_buy_3')->nullable();
            $table->string('why_buy_4')->nullable();
            $table->string('why_buy_5')->nullable();
            $table->string('why_buy_6')->nullable();
            $table->string('why_buy_7')->nullable();
            $table->string('why_buy_8')->nullable();
            $table->string('why_buy_9')->nullable();
            $table->string('why_sell_1')->nullable();
            $table->string('why_sell_2')->nullable();
            $table->string('why_sell_3')->nullable();
            $table->string('why_sell_4')->nullable();
            $table->string('why_sell_5')->nullable();
            $table->string('why_sell_6')->nullable();
            $table->string('why_sell_7')->nullable();
            $table->string('why_sell_8')->nullable();
            $table->string('why_sell_9')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
