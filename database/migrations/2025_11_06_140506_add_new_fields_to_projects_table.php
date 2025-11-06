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
            $table->json('additional_housing_types')->nullable()->after('housing_type');
            $table->integer('f1_count')->default(0)->after('housing_type');
            $table->integer('f2_count')->default(0)->after('f1_count');
            $table->integer('f3_count')->default(0)->after('f2_count');
            $table->integer('f4_count')->default(0)->after('f3_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['additional_housing_types', 'f1_count', 'f2_count', 'f3_count', 'f4_count']);
        });
    }
};
