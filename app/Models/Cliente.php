<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table='cliente';
    protected $fillable=[
        'persona_id',
        'vehiculo_id',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //Pertenece a Persona
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id');
    }
    //Pertenece a  Vehiculo
    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class,'vehiculo_id');
    }
    //le da su id a servicio
    public function servicio(){
        return $this->hasMany(Servicio::class);
    }

}
