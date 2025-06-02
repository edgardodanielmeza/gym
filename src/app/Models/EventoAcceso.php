<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoAcceso extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eventos_acceso';

    /**
     * Indicates if the model should be timestamped.
     * La tabla 'eventos_acceso' DDL original no tiene created_at/updated_at,
     * solo 'timestamp_evento'.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miembro_id',
        'dispositivo_id',
        'timestamp_evento',
        'tipo_evento', // ENUM mapeado a string
        'acceso_permitido',
        'motivo_denegacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'timestamp_evento' => 'datetime', // TIMESTAMP
        'acceso_permitido' => 'boolean',  // BOOLEAN
        // 'tipo_evento' se trata como string (ENUM).
    ];

    /**
     * Get the member associated with the access event.
     */
    public function miembro(): BelongsTo
    {
        return $this->belongsTo(Miembro::class, 'miembro_id');
    }

    /**
     * Get the access device associated with the access event.
     */
    public function dispositivo(): BelongsTo // Renombrado por brevedad
    {
        return $this->belongsTo(DispositivoAcceso::class, 'dispositivo_id');
    }
}
