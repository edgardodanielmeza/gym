<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sucursal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'horario_apertura',
        'horario_cierre',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'horario_apertura' => 'datetime:H:i:s', // Se almacena como TIME, castear a string o Carbon si se manipula
        // 'horario_cierre' => 'datetime:H:i:s', // Se almacena como TIME
        // Laravel por defecto no tiene un cast específico para TIME solo, lo tratará como string.
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the system users associated with the branch.
     */
    public function usuariosSistema(): HasMany
    {
        return $this->hasMany(UsuarioSistema::class, 'sucursal_id');
    }

    /**
     * Get the members associated with the branch as their default branch.
     */
    public function miembros(): HasMany
    {
        return $this->hasMany(Miembro::class, 'sucursal_predeterminada_id');
    }

    /**
     * Get the access devices associated with the branch.
     */
    public function dispositivosAcceso(): HasMany
    {
        return $this->hasMany(DispositivoAcceso::class, 'sucursal_id');
    }
}
