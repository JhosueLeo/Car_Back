<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table='servicio';
    protected $fillable=[
        'cliente_id',
        'IGV',
        'sub_total',
        'precio_total',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //Pertenece a Cliente
    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    //Le da su id a servicio_producto
    public function servicio_producto(){
        return $this->hasMany(ServicioProducto::class);
    }
    //Le da su id a Detalle_Tipo_Servicio
    public function detalle_tipo_servicio(){
        return $this->hasMany(DetalleTipoServicio::class);
    }
}
