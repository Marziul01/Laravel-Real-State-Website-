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
        Schema::create('admin_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->tinyInteger('control_panel')->default(1);
            $table->tinyInteger('rent_property')->default(1);
            $table->tinyInteger('sell_property')->default(1);
            $table->tinyInteger('coupons')->default(1);
            $table->tinyInteger('payment_methods')->default(1);
            $table->tinyInteger('booking')->default(1);
            $table->tinyInteger('property_inquiries')->default(1);
            $table->tinyInteger('property_submissions')->default(1);
            $table->tinyInteger('services')->default(1);
            $table->tinyInteger('teams')->default(1);
            $table->tinyInteger('reviews')->default(1);
            $table->tinyInteger('user_management')->default(1);
            $table->tinyInteger('pages_management')->default(1);
            $table->tinyInteger('seo')->default(1);
            $table->tinyInteger('reports')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_accesses');
    }
};
