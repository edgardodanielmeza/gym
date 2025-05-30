<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// Si este modelo fuera a ser usado para autenticación:
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

class UsuarioSistema extends Model // Cambiar a Authenticatable si es para auth
{
    use HasFactory; // Añadir Notifiable si es para auth

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios_sistema';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sucursal_id',
        'rol_id',
        'nombre_usuario',
        'nombre_completo',
        'email',
        'password', // Nombre cambiado desde password_hash en DDL
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token', // Si se usa autenticación de Laravel
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
        // 'email_verified_at' => 'datetime', // Común en modelos User para auth
        'password' => 'hashed', // Para auto-hash al asignar (Laravel 9+)
        // created_at y updated_at son casteados a datetime automáticamente.
    ];

    /**
     * Get the branch to which the system user belongs (if any).
     */
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    /**
     * Get the system role of the user.
     */
    public function rol(): BelongsTo // Renombrado de rolSistema a rol por brevedad
    {
        return $this->belongsTo(RolSistema::class, 'rol_id');
    }

    /**
     * Get the payments recorded by this system user.
     */
    public function pagos(): HasMany // Renombrado de pagosRegistrados a pagos
    {
        return $this->hasMany(Pago::class, 'usuario_sistema_id');
    }
}
