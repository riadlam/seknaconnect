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
        // First, we need to modify the column to allow NULL temporarily
        // because changing enum values requires dropping and recreating the column
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->change();
        });
        
        // Then modify it again to add the new enum value
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'professional', 'public'])
                  ->default('public')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum values
        // First, update any admin users to another role
        \DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'professional']);
            
        // Then modify the column to remove 'admin' from the enum
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->change();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['professional', 'public'])
                  ->default('public')
                  ->change();
        });
    }
};
