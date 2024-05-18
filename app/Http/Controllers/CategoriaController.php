<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function get(){
        try{
            $categoria=Categoria::where('estado_registro','A')->get();
            if(!$categoria){
            return response(['error'=>'No hay Categoria(s) registradas']);
            }
            return response()->json(['data',$categoria],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }   
        
    }
    public function show($idCategoria){
        try{
            $categoria=Categoria::where('estado_registro','A')->find($idCategoria);
            if(!$categoria){
                return response(['error'=>'Categoria no existe']);
            }
            return response()->json(['data',$categoria],200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        } 
    }
    public function create(Request $request){
        DB::beginTransaction();
        try{
            $categoria= Categoria::create([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion
            ]);
            
            DB::commit();
            return response(['resp'=>'Categoria creada correctamente']);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        } 
    }
    public function update(Request $request, $idCategoria){
        DB::beginTransaction();
        try{
            $categoria=Categoria::where('estado_registro','A')->find($idCategoria);
            if(!$categoria){
                return response(['error'=>'Categoria no existe']);
            }
            $categoria->update([
                'nombre'=>$request->nombre,
                'descripcion'=>$request->descripcion
            ]);
            DB::commit();
            return response(['resp'=>'Categoria actualizada correctamente']);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        } 
    }
    public function delete($idCategoria){
        DB::beginTransaction();
        try{
            $categoria=Categoria::where('estado_registro','A')->find($idCategoria);
            if(!$categoria){
                return response()->json(['resp'=>'Categoria ya esta inhabilitado']);
            }
            $categoria->update([
                'estado_registro'=>'I'
            ]);
            DB::commit();
            return response()->json(['resp'=>'Categoria Inhabilitado']);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        } 
    }
}
