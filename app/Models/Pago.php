<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'membresia_id', 'fecha_pago', 'monto', 'metodo_pago', 'estado'
    ];

    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }
}