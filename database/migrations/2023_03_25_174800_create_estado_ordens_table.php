<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estado_ordens', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('detalle');
        });

        // Insertar registros iniciales
        DB::table('estado_ordens')->insert([
            ['nombre' => 'FACTURADO', 'detalle' => 'La orden ha sido facturada'],
            ['nombre' => 'ENTREGADO', 'detalle' => 'La orden ha sido entregada'],
            ['nombre' => 'ANULADO', 'detalle' => 'La orden ha sido anulada'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_ordens');
    }
};
