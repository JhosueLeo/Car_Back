<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioProducto extends Model
{
    protected $table='servicio_producto';
    protected $fillable=[
        'servicio_id',
        'producto_id',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //Pertenece A servicio
    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id');
    }
    //Pertenece A Producto
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
