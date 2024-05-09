<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';
    protected $fillable=[
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'tipo_documento_id',
        'numero_documento',
        'estado_registro'
    ];
    protected $primarykey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //pertenece a Tipo documento
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class,'tipo_documento_id');
    }
    //le da su id a Cliente
    public function cliente(){
        return $this->hasMany(Cliente::class);
    }
}
