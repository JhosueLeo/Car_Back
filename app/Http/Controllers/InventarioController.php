<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function get(){
        try{
            $inventario=Inventario::with('producto')->where('estado_registro','A')->get();
            if(!$inventario){
                return response()->json(['resp'=>'Inventario no disponible']);
            }
            return response()->json(['resp'=>$inventario],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function show($idInventario){
        try{
            $inventario=Inventario::with('producto')->where('estado_registro','A')->find($idInventario);
            if(!$inventario){
                return response()->json(['resp'=>'Inventario no disponible']);
            }
            return response()->json(['resp'=>$inventario],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $inventario=Inventario::create([
                'producto_id'=>$request->producto_id,
                'cantidad'=>$request->cantidad
            ]);
            DB::commit();
            return response()->json(['resp'=>'Inventario creado correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function update(Request $request,$idInventario){
        DB::beginTransaction();
        try{
            $inventario=Inventario::where('estado_registro','A')->find($idInventario);
            if(!$inventario){
                return response()->json(['resp'=>'Inventario no disponible']);
            }
            $inventario->update([
                'producto_id'=>$request->producto_id,
                'cantidad'=>$request->cantidad
            ]);
            DB::commit();
            return response()->json(['resp'=>'Inventario actualizado correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function delete($idInventario){
        DB::beginTransaction();
        try{
            $inventario=Inventario::where('estado_registro','A')->find($idInventario);
            if(!$inventario){
                return response()->json(['resp'=>'Inventario ya esta inhabilitado']);
            }
            $inventario->update([
                'estado_registro'=>'I'
            ]);
            DB::commit();
            return response()->json(['resp'=>'Inventario inhabilitado correctamente'],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
}
