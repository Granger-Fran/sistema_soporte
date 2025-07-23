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
        Schema::table('avisos', function (Blueprint $table) {
            $table->renameColumn('titulo', 'title');
            $table->renameColumn('contenido', 'content');
            $table->renameColumn('fecha_publicacion', 'published_at');
            $table->renameColumn('activo', 'is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
             $table->renameColumn('title', 'titulo');
            $table->renameColumn('content', 'contenido');
            $table->renameColumn('published_at', 'fecha_publicacion');
            $table->renameColumn('is_active', 'activo');
        });
    }
};
