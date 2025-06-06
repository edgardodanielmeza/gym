<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membresia extends Model
{
    use HasFactory;

    const ESTADO_ACTIVA = 'Activa';
    const ESTADO_PENDIENTE = 'Pendiente';
    const ESTADO_VENCIDA = 'Vencida';
    const ESTADO_CANCELADA = 'Cancelada';
    // Considerar añadir 'Congelada' o 'Pausada' si es necesario en el futuro

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'membresias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miembro_id',
        'tipo_membresia_id',
        'fecha_inicio',
        'fecha_fin',
        'estado', // ENUM mapeado a string
        'precio_pagado',
        'notas',
        'renovacion_automatica',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',          // DATE
        'fecha_fin' => 'date',             // DATE
        'precio_pagado' => 'decimal:2',    // DECIMAL(10,2)
        'renovacion_automatica' => 'boolean', // BOOLEAN
        // 'estado' se trata como string (ENUM).
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the member that owns the membership.
     */
    public function miembro(): BelongsTo
    {
        return $this->belongsTo(Miembro::class, 'miembro_id');
    }

    /**
     * Get the type of the membership.
     */
    public function tipoMembresia(): BelongsTo
    {
        return $this->belongsTo(TipoMembresia::class, 'tipo_membresia_id');
    }

    /**
     * Get the invoices for the membership.
     */
    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class, 'membresia_id');
    }

    /**
     * Scope a query to only include active memberships.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', self::ESTADO_ACTIVA)
                     ->where('fecha_inicio', '<=', now())
                     ->where('fecha_fin', '>=', now());
    }

    /**
     * Check if the membership is currently active.
     * (Este es un accesor, no un scope, pero útil)
     *
     * @return bool
     */
    public function getEsActivaAttribute(): bool
    {
        return $this->estado === self::ESTADO_ACTIVA &&
               $this->fecha_inicio <= now() &&
               $this->fecha_fin >= now();
    }
}
