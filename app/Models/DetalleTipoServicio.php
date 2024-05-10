<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleTipoServicio extends Model
{
    protected $table='detalle_tipo_servicio';
    protected $fillable=[
        'servicio_id',
        'tipo_servicio_id',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden=[
        'created_at','updated_at','deleted_at'
    ];
    //pertenece a servicio
    public function servicio(){
        return $this->belongsTo(Servicio::class,'servicio_id');
    }
    //pertenece a tipo servicio
    public function tipo_servicio(){
        return $this->belognsTo(TipoServicio::class,'tipo_servicio_id');
    }
}
