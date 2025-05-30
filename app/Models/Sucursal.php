<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'direccion', 'telefono', 'email', 'horario_apertura', 'horario_cierre'
    ];

    public function dispositivos()
    {
        return $this->hasMany(DispositivoAcceso::class);
    }

    public function miembros()
    {
        return $this->hasMany(Miembro::class);
    }

    public function eventosAcceso()
    {
        return $this->hasMany(EventoAcceso::class);
    }
}