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
        Schema::create('ordens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_estado_orden');
            $table->string('nro_orden')->unique();
            $table->decimal('valor_pagar', 10, 2);
            $table->text('detalle');
            $table->timestamps();
            $table->boolean('estado')->default(true);

            // Agrega la clave externa utilizando la columna 'identificacion' en la tabla 'clientes'
            $table->foreign('id_cliente')->references('identificacion')->on('clientes');

            // Agrega la clave externa utilizando la columna 'id' en la tabla 'estado_ordens'
            $table->foreign('id_estado_orden')->references('id')->on('estado_ordens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens');
    }
};
