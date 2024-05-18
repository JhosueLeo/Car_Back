<?php

namespace App\Http\Controllers;

use App\Models\DetalleTipoServicio;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\ServicioProducto;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    public function get(){
        try{
            $servicio=Servicio::with('cliente.persona','cliente.vehiculo')->where('estado_registro','A')->get();
            if(!$servicio){
                return response()->json(['resp'=>'Servicio no disponible'],200);
            }
            return response()->json(['resp'=>$servicio],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function show($idServicio){
        try{
            $servicio=Servicio::with('cliente.persona','cliente.vehiculo')->where('estado_registro','A')->find($idServicio);
            if(!$servicio){
                return response()->json(['resp'=>'Servicio no disponible'],200);
            }
            return response()->json(['resp'=>$servicio],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $servicio=Servicio::Create([
                'cliente_id'=>$request->cliente_id,
                'IGV'=>$request->IGV,
                'sub_total'=>$request->sub_total,
                'precio_total'=>$request->precio_total
            ]);
            $producto = $request->producto_id ?? [];
            foreach($producto as $productos_id){
                ServicioProducto::create([
                    'servicio_id'=>$servicio->id,
                    'producto_id'=>$productos_id
                ]);
            }
            $detalle_tipo_servicio=$request->tipo_servicio_id ?? [];
            foreach($detalle_tipo_servicio as $detalle){
                DetalleTipoServicio::create([
                    'servicio_id'=>$servicio->id,
                    'tipo_servicio_id'=>$detalle
                ]);
            }
            DB::commit();
            return response()->json(['resp'=>'Servicio creado correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    
    public function update(Request $request,$idServicio){
        DB::beginTransaction();
        try{
            $servicio=Servicio::where('estado_registro','A')->find($idServicio);
            if(!$servicio){
                return response()->json(['resp'=>'Servicio no disponible']);
            }
            $servicio->update([
                'cliente_id'=>$request->cliente_id,
                'IGV'=>$request->IGV,
                'sub_total'=>$request->sub_total,
                'precio_total'=>$request->precio_total
            ]);
            
            $producto = $request->producto_id ?? [];
            $idsEliminar=ServicioProducto::where('servicio_id',$servicio->id)->whereNotIn('producto_id',array_column($producto,'producto_id'))->pluck('id');
            ServicioProducto::whereIn('id',$idsEliminar)->delete();
            foreach($producto as $productos_id){
                ServicioProducto::updateOrcreate([
                    'servicio_id'=>$servicio->id,
                    'producto_id'=>$productos_id
                ],[
                    'estado_registro'=>'A'
                ]);
            }
            $detalle_tipo_servicio=$request->tipo_servicio_id ?? [];
            $idsEliminarServicio=DetalleTipoServicio::where('servicio_id',$servicio->id)->whereNotIn('tipo_servicio_id',array_column($detalle_tipo_servicio,'tipo_servicio_id'))->pluck('id');
            DetalleTipoServicio::whereIn('id',$idsEliminarServicio)->delete();
            foreach($detalle_tipo_servicio as $detalle){
                DetalleTipoServicio::updateOrCreate([
                    'servicio_id'=>$servicio->id,
                    'tipo_servicio_id'=>$detalle
                ]);
            };
            DB::commit();
            return response()->json(['resp'=>'Servicio actualizado correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function delete($idServicio){
        DB::beginTransaction();
        try{
            $servicio=Servicio::where('estado_registro','A')->find($idServicio);
            if(!$servicio){
                return response()->json(['resp'=>'Servicio ya se encuentra inhabilitado'],200);
            }
            $servicio->update([
                'estado_registro'=>'I' 
            ]);
            DB::commit();
            return response()->json(['resp'=>'Servicio inhabilitado'],200);

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
}
