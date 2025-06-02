<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMembresia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_membresia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_dias',
        'precio',
        'activa',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duracion_dias' => 'integer', // INT UNSIGNED
        'precio' => 'decimal:2',      // DECIMAL(10,2)
        'activa' => 'boolean',        // BOOLEAN
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the memberships of this type.
     */
    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class, 'tipo_membresia_id');
    }
}
