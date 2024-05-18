<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table='rol';
    protected $fillable=[
        'nombre',
        'descripcion',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //le da su id a UserRol
    public function usuarioRol(){
        return $this->hasMany(UsuarioRol::class);
    }
}
