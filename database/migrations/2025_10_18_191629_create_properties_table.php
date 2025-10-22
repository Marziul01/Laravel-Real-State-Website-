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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('property_type_id')->nullable();
            $table->integer('realtor_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('price');
            $table->text('description')->nullable();
            $table->text('property_listing')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('space')->nullable();
            $table->integer('parking_space')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('property_area')->nullable();
            $table->string('house')->nullable();
            $table->string('city')->nullable();
            $table->string('road')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
