<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Cliente",
 *     required={"identificacion", "nombres", "apellidos", "correo", "celular", "estado"},
 *     @OA\Property(property="identificacion", type="string", example="1234567890"),
 *     @OA\Property(property="nombres", type="string", example="José"),
 *     @OA\Property(property="apellidos", type="string", example="Sánchez Saltos"),
 *     @OA\Property(property="correo", type="string", format="email", example="josesansalt@gmail.com"),
 *     @OA\Property(property="celular", type="string", example="0983595470"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="fecha_creacion", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="fecha_actualizacion", type="string", format="date-time", readOnly=true),
 * )
 */
class Cliente extends Model
{
    protected $fillable = [
        'identificacion',
        'nombres',
        'apellidos',
        'correo',
        'celular',
        'estado',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->validate();
        });

        self::updating(function ($model) {
            $model->validate();
        });
    }

    public function validate()
    {
        $validator = Validator::make($this->attributes, [
            'identificacion' => [
                'required',
                Rule::unique('clientes')->ignore($this->id),
            ],
            'correo' => [
                'required',
                'email',
                Rule::unique('clientes')->ignore($this->id),
            ],
            'celular' => [
                'required',
                Rule::unique('clientes')->ignore($this->id),
            ],
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

}
