<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\User;
use App\Models\UsuarioRol;

class EmpleadoController extends Controller
{
    public function get(){
        try{
            $empleado=Empleado::with('persona')->where('estado_registro','A')->get();
            if(!$empleado){
                return response()->json(['resp'=>'Empleado no disponible'],200);
            }
            return response()->json(['resp'=>$empleado],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function show($idEmpleado){
        try{
            $empleado=Empleado::with('persona')->where('estado_registro','A')->find($idEmpleado);
            if(!$empleado){
                return response()->json(['resp'=>'Empleado no disponible'],200);
            }
            return response()->json(['resp'=>$empleado],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $existePersona = Persona::where('numero_documento', $request->numero_documento)->first();
            if ($existePersona) {
                $persona = Persona::updateOrcreate([
                    'numero_documento' => $request->numero_documento,
                ], [
                    'nombre' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'tipo_documento_id' => $request->tipo_documento_id,
                ]);
            } else {
                $persona = Persona::create([
                    'numero_documento' => $request->numero_documento,
                    'nombre' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'tipo_documento_id' => $request->tipo_documento_id,
                ]);
            }
            $empleado=Empleado::updateOrcreate([
                'persona_id'=>$persona->id
            ],[
                'cargo'=>$request->cargo
            ]);
            DB::commit();
            return response()->json(['resp'=>'Empleado creado Correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function update(Request $request,$idEmpleado){
        DB::beginTransaction();
        try{
            $empleado=Empleado::where('estado_registro','A')->find($idEmpleado);
            $persona=Persona::find($empleado->persona_id);
            $existePersona=Persona::where('numero_documento',$request->numero_documento)->where('id','!=',$persona->id)->first();
            if($existePersona){
                return response()->json(['error' => 'El número de documento ya está en uso por otra persona'], 200);
            }
            if(!$empleado){
                return response()->json(['resp'=>'Empleado no disponible'],200);
            }
            $persona->update([
                'numero_documento' => $request->numero_documento,
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'tipo_documento_id' => $request->tipo_documento_id,
            ]);
            $empleado->update([
                'cargo'=>$request->cargo,
            ]);
            DB::commit();
            return response()->json(['resp'=>'Empleado actualizado Correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function delete($idEmpleado){
        DB::beginTransaction();
        try{
            $empleado=Empleado::where('estado_registro','A')->find($idEmpleado);
            if(!$empleado){
                return response()->json(['resp'=>'Empleado no disponible'],200);
            }
            $empleado->update([
                'estado_registro'=>'I'
            ]);
            DB::commit();
            return response()->json(['resp'=>'Empleado Inhabilitado Correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function asignarRol(Request $request,$idEmpleado){
        DB::beginTransaction();
        try{
            $empleado=Empleado::where('estado_registro','A')->find($idEmpleado);
            if(!$empleado){
                return response()->json(['resp'=>'Empleado no disponible'],200);
            }
            
            $persona=Persona::find($empleado->persona_id);
            if (!$persona->numero_documento) {
                return response()->json(["error" => "El número de documento está ausente o es nulo"], 400);
            }
            
            $usuario=User::updateOrCreate([
                'empleado_id'=>$empleado->id
            ],[
                'username'=>$persona->numero_documento,
                'password'=>$persona->numero_documento
            ]);
            
            $rol=UsuarioRol::updateOrCreate([
                'usuario_id'=>$usuario->id
            ],[
                'rol_id'=>$request->rol_id
            ]);
            DB::commit();
            return response()->json(['resp'=>'Rol Asignado Correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
}
