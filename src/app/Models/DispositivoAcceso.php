<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DispositivoAcceso extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dispositivos_acceso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sucursal_id',
        'nombre_dispositivo',
        'tipo_dispositivo', // ENUM mapeado a string
        'ubicacion_descripcion',
        'direccion_ip',
        'mac_address',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean', // BOOLEAN
        // 'tipo_dispositivo' se trata como string (ENUM).
        // 'direccion_ip' (IP) y 'mac_address' (MAC) se tratan como string.
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the branch to which the access device belongs.
     */
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    /**
     * Get the access events for the device.
     */
    public function eventosAcceso(): HasMany
    {
        return $this->hasMany(EventoAcceso::class, 'dispositivo_id');
    }
}
