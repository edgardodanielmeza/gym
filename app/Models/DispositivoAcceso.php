<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DispositivoAcceso extends Model
{
    use HasFactory;

    protected $fillable = ['sucursal_id', 'tipo', 'estado', 'ip_configuracion'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function eventosAcceso()
    {
        return $this->hasMany(EventoAcceso::class);
    }
}