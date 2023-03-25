<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Orden",
 *     required={"id_cliente", "id_estado_orden", "nro_orden", "valor_pagar", "detalle", "estado"},
 *     @OA\Property(property="id_cliente", type="string", example="1234567890"),
 *     @OA\Property(property="id_estado_orden", type="integer", example=1),
 *     @OA\Property(property="nro_orden", type="string", example="O12345"),
 *     @OA\Property(property="valor_pagar", type="number", format="float", example=100.50),
 *     @OA\Property(property="detalle", type="string", example="Descripción de la orden"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="fecha_creacion", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="fecha_actualizacion", type="string", format="date-time", readOnly=true),
 * )
 */
class Orden extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'id_estado_orden',
        'nro_orden',
        'valor_pagar',
        'detalle',
        'estado',
    ];
}
