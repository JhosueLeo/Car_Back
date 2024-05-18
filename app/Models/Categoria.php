<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';
    protected $fillable=[
        'nombre',
        'descripcion',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //Le da su id a Producto
    public function producto()
    {
        return $this->hasMany(Producto::class);
    }
}
