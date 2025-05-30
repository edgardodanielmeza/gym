<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventoAcceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'miembro_id', 'sucursal_id', 'dispositivo_acceso_id', 'fecha_hora', 'resultado'
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function dispositivo()
    {
        return $this->belongsTo(DispositivoAcceso::class, 'dispositivo_acceso_id');
    }
}