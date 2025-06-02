<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Factura extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'facturas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membresia_id',
        'numero_factura',
        'fecha_emision',
        'fecha_vencimiento',
        'monto_subtotal',
        'impuestos',
        'monto_total',
        'estado', // ENUM mapeado a string
        'notas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_emision' => 'date',         // DATE
        'fecha_vencimiento' => 'date',     // DATE
        'monto_subtotal' => 'decimal:2',   // DECIMAL(10,2)
        'impuestos' => 'decimal:2',        // DECIMAL(10,2)
        'monto_total' => 'decimal:2',      // DECIMAL(10,2)
        // 'estado' se trata como string (ENUM).
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the membership associated with the invoice.
     */
    public function membresia(): BelongsTo
    {
        return $this->belongsTo(Membresia::class, 'membresia_id');
    }

    /**
     * Get the payments for the invoice.
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'factura_id');
    }
}
