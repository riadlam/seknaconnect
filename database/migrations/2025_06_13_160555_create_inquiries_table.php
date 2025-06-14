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
    Schema::create('inquiries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->string('name');   // name of the person who inquired
        $table->string('email');
        $table->text('message');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
