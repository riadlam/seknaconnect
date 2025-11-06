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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('bedrooms')->nullable(); // Can be numbers or "studio"
            $table->integer('bathrooms')->nullable();
            $table->enum('rent_or_buy', ['rent', 'buy'])->nullable();
            $table->json('payment_plan')->nullable(); // For robust payment plan data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['bedrooms', 'bathrooms', 'rent_or_buy', 'payment_plan']);
        });
    }
};
