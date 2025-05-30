<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membresia extends Model
{
    use HasFactory;

    protected $fillable = [
        'miembro_id', 'tipo', 'fecha_inicio', 'fecha_fin', 'estado'
    ];

    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}