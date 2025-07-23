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
        Schema::table('users', function (Blueprint $table) {
         // Agrega el apellido después de name
         $table->string('last_name')->after('name');

         // Departamento después de last_name
         $table->string('department')->nullable()->after('last_name');

         // Teléfono después de department
         $table->string('phone')->nullable()->after('department');

         // Rol después de password
         $table->string('role')->default('user')->after('password');

         // Estado (activo) después de role
         $table->boolean('active')->default(1)->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
         // Eliminar los campos si se revierte la migración
            $table->dropColumn([
                'last_name',
                'department',
                'phone',
                'role',
                'active',
                
                
            ]);
            
        });
    }
};
