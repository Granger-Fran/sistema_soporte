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
        Schema::table('notices', function (Blueprint $table) {
               $table->string('title')->nullable();   // lo agregas aquí directamente
        $table->text('content')->nullable();   // sin after
        $table->string('image')->nullable();   // sin after
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notices', function (Blueprint $table) {
              $table->dropColumn(['content', 'image']);
        });
    }
};
