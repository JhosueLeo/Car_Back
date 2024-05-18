<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    protected $table='usuario_rol';
    protected $fillable=[
        'rol_id',
        'usuario_id',
        'tipo_rol',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //pertenece a usuario
    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }
    //pertenece a rol
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
}
