<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pagos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'factura_id',
        'usuario_sistema_id',
        'fecha_pago',
        'monto_pagado',
        'metodo_pago', // ENUM mapeado a string
        'referencia_pago',
        'notas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_pago' => 'datetime',     // DATETIME
        'monto_pagado' => 'decimal:2', // DECIMAL(10,2)
        // 'metodo_pago' se trata como string (ENUM).
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the invoice to which the payment belongs.
     */
    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }

    /**
     * Get the system user who recorded the payment.
     */
    public function usuarioSistema(): BelongsTo // o renombrar a 'cajero' o 'registradoPor' si se prefiere
    {
        return $this->belongsTo(UsuarioSistema::class, 'usuario_sistema_id');
    }
}
