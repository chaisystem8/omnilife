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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->decimal('salarioDolares', 10, 2);
            $table->decimal('salarioPesos', 10, 2);
            $table->string('direccion');
            $table->string('estado');
            $table->string('ciudad');
            $table->string('celular');
            $table->string('correo');
            $table->boolean('activo')->default(true);
            $table->softDeletes(); // Habilitamos eliminación lógica
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
