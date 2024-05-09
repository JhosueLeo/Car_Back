<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table='tipo_servicio';
    protected $fillable=[
        'nombre',
        'precio',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //le da su id a detalle tipo servicio
    public function detalle_tipo_servicio(){
        return $this->hasMany(DetalleTipoServicio::class);
    }
}
