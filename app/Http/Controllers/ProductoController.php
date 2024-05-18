<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function get(){
        try{
            $producto=Producto::with('categoria')->where('estado_registro','A')->get();
            if(!$producto){
                return response()->json(['resp'=>'Producto no disponible']);
            }
            return response()->json(['resp'=>$producto],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }   
    }
    public function show($idProducto){
        try{
            $producto=Producto::with('categoria')->where('estado_registro','A')->find($idProducto);
            if(!$producto){
                return response()->json(['resp'=>'Producto no disponible']);
            }
            return response()->json(['resp'=>$producto],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }  
    }
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $producto=Producto::create([
                'nombre'=>$request->nombre,
                'marca'=>$request->marca,
                'descripcion'=>$request->descripcion,
                'precio'=>$request->precio,
                'tipo'=>$request->tipo,
                'categoria_id'=>$request->categoria_id
            ]);
            DB::commit();
            return response()->json(['resp'=>'Producto creado correctamente '],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        } 
    }
    public function update(Request $request,$idProducto){
        DB::beginTransaction();
        try{
            $producto=Producto::where('estado_registro','A')->find($idProducto);
            if(!$producto){
                return response()->json(['resp'=>'Producto no Disponible']);
            }
            $producto->update([
                'nombre'=>$request->nombre,
                'marca'=>$request->marca,
                'descripcion'=>$request->descripcion,
                'precio'=>$request->precio,
                'tipo'=>$request->tipo,
                'categoria_id'=>$request->categoria_id
            ]);
            DB::commit();
            return response()->json(['resp'=>'Producto actualizado correctamente '],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function delete($idProducto){
        DB::beginTransaction();
        try{
            $producto=Producto::where('estado_registro','A')->find($idProducto);
            if(!$producto){
                return response()->json(['resp'=>'Producto ya esta inhabilitado']);
            }
            $producto->update([
                'estado_registro'=>'I'
            ]);
            DB::commit();
            return response()->json(['resp'=>'Producto inhabilitado correctamente '],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
}
