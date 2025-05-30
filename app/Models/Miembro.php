<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Miembro extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucursal_id', 'nombre', 'apellido', 'direccion',
        'telefono', 'email', 'fecha_nacimiento',
        'foto', 'codigo_acceso_hash', 'huella_digital'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function membresias()
    {
        return $this->hasMany(Membresia::class);
    }

    public function eventosAcceso()
    {
        return $this->hasMany(EventoAcceso::class);
    }
}