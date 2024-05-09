<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table='inventario';
    protected $fillable=[
        'producto_id',
        'cantidad',
        'estado_registro',
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //Pertenece a Producto
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
