<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='producto';
    protected $fillable=[
        'nombre',
        'marca',
        'descripcion',
        'precio',
        'tipo',
        'categoria_id',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //Pertenece a Categoria
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    //Le da su id a Inventario
    public function inventario(){
        return $this->hasMany(Inventario::class);
    }
    //le da su id  a Servicio Producto
    public function servicio_producto(){
        return $this->hasMany(ServicioProducto::class);
    }
}
