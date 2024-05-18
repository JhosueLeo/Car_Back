<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'empleado_id',
        'username',
        'email_verified_at',
        'password',
        'estado_registro'
    ];

    protected $primaryKey = 'id';

    protected $hidden = [
        'password',
        'remember_token',
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function usuario_rol()
    {
        return $this->hasMany(UsuarioRol::class, 'usuario_id', 'id');
    }    

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'usuario_id', 'rol_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id');
    }
}
