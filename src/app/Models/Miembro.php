<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Miembro extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'miembros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sucursal_predeterminada_id',
        'numero_identificacion',
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'genero', // ENUM mapeado a string
        'direccion',
        'telefono',
        'email',
        'fecha_registro',
        'foto_perfil_url',
        'notas_adicionales',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date', // DATE
        'fecha_registro' => 'date',   // DATE
        'activo' => 'boolean',        // BOOLEAN
        // 'genero' se trata como string, que es el mapeo para ENUM.
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the default branch for the member.
     */
    public function sucursalPredeterminada(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_predeterminada_id');
    }

    /**
     * Get the memberships for the member.
     */
    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class, 'miembro_id');
    }

    /**
     * Get the access events for the member.
     */
    public function eventosAcceso(): HasMany
    {
        return $this->hasMany(EventoAcceso::class, 'miembro_id');
    }
}
