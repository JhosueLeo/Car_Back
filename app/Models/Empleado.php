<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table='empleado';
    protected $fillable=[
        'persona_id',
        'cargo',
        'estado_registro'
    ];
    protected $primaryKey='id';
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    //pertene a persona
    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }
    //le da el id a user
    public function usuario(){
        return $this->hasMany(User::class);
    }
}
