<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function get()
    {
        try {
            $cliente = Cliente::with('persona','vehiculo')->where('estado_registro', 'A')->get();
            if (!$cliente) {
                return response()->json(['resp' => 'No existe clientes en la Base de Datos ']);
            }
            return response()->json(['resp' => $cliente], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function show($idCliente)
    {
        try {
            $cliente = Cliente::with('persona','vehiculo')->where('estado_registro', 'A')->find($idCliente);
            if (!$cliente) {
                return response()->json(['resp' => 'No existe cliente en la Base de Datos ']);
            }
            return response()->json(['resp' => $cliente], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $existePersona = Persona::where('numero_documento', $request->numero_documento)->first();
            // return response()->json([$existePersona],200);
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
            $vehiculo = Vehiculo::updateOrCreate([
                'placa' => $request->placa
            ], [
                'modelo' => $request->modelo,
                'marca_id' => $request->marca_id
            ]);
            Cliente::updateOrCreate([
                'persona_id' => $persona->id,
                'vehiculo_id' => $vehiculo->id
            ]);
            DB::commit();
            return response()->json(['resp' => 'cliente creada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $idCliente)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::where('estado_registro', 'A')->find($idCliente);
            $persona = Persona::find($cliente->persona_id);
            $vehiculo = Vehiculo::find($cliente->vehiculo_id);
            $existePersona = Persona::where('numero_documento', $request->numero_documento)
                ->where('id', '!=', $persona->id)
                ->first();
            if ($existePersona) {
                return response()->json(['error' => 'El número de documento ya está en uso por otra persona'], 200);
            }
            $persona->update([
                'numero_documento' => $request->numero_documento,
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'tipo_documento_id' => $request->tipo_documento_id,
            ]);
            $vehiculo->update([
                'placa' => $request->placa,
                'modelo' => $request->modelo,
                'marca_id' => $request->marca_id
            ]);
            $cliente->update([
                'persona_id' => $persona->id,
                'vehiculo_id' => $vehiculo->id
            ]);
            DB::commit();
            return response()->json(['resp' => 'cliente actualizado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
    public function delete($idCliente)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::where('estado_registro', 'A')->find($idCliente);
            if (!$cliente) {
                return response()->json(['resp' => 'Cliente ya se encuentra inhabilitado']);
            }
            $cliente->update([
                'estado_registro' => 'I'
            ]);
            DB::commit();
            return response()->json(['resp' => 'cliente  inhabilitado correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Algo salió mal", "message" => $e->getMessage()], 500);
        }
    }
}
