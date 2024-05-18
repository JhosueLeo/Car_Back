<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table='marca';
    protected $fillable=[
        'nombre',
        'descripcion',
        'estado_registro',
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public function vehiculo(){
        return $this->hasMany(Vehiculo::class);
    }
}
