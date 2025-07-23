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
        Schema::create('tickets', function (Blueprint $table) {
            
            $table->id(); // ID principal

            // Asunto del ticket
            $table->string('title');

            // Descripción detallada del problema
            $table->text('description');

            // Departamento (se tomará automáticamente del usuario)
            $table->string('department');

            // Prioridad: alta, media, baja
            $table->string('priority');

            // Ruta del archivo adjunto (imagen, PDF, etc.)
            $table->string('attachment')->nullable();

            // Tiempo estimado de solución (lo define el técnico)
            $table->string('estimated_time')->nullable();

            // Respuesta del técnico (opcional)
            $table->text('response')->nullable();

            // Estado del ticket (default: pending)
            $table->string('status')->default('pending');

            // ID del usuario que crea el ticket (cliente)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ID del técnico asignado (opcional)
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
