<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table='vehiculo';
    protected $fillable=[
        'placa',
        'modelo',
        'marca_id',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //le da su id a Cliente
    public function cliente(){
        return $this->hasMany(Cliente::class);
    }
    public function marca(){
        return $this->belongsTo(Marca::class,'marca_id','id');
    }
}
