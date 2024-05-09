<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table='vehiculo';
    protected $fillable=[
        'placa',
        'modelo',
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
}
