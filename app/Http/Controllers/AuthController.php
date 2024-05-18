<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // Obteniendo credenciales del request
        $credentials = $request->only('username', 'password');

        // Verificando si el usuario existe
        $user = User::with('persona.tipo_documento','empleado.persona', 'usuario_rol.rol','usuario_rol.usuario', 'roles')
            ->where('username', $request->username)
            ->where('estado_registro', 'A')
            ->first();
        
        if (!$user) {
            return response()->json(["error" => "El nombre de usuario no existe"], 400);
        }

        // Verificando si el usuario está bloqueado
        if (!$user) {
            return response()->json(['error' => 'Usuario bloqueado'], 402);
        }

        try {
            // Cambiando la duración del token
            $this->cambiarDuracionToken();

            // Intentando generar un token JWT
            if (!$token = FacadesJWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 403);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // Obteniendo el rol del usuario
        $rol = Rol::where('estado_registro', '!=', 'I')
            ->find($user->roles[0]->id);

        // Preparando la respuesta
        $response = [
            "id" => $user->id,
            "empleado_id" => $user->empleado_id,
            "username" => $user->username,
            "empleado" => $user->empleado,
            "user_rol" => $user->usuario_rol,
            "roles" => $user->roles,
            "token" => $token
        ];

        return response()->json($response);
    }

    private function cambiarDuracionToken()
    {
        $myTTL = 60 * 24 * 1; // En minutos
        FacadesJWTAuth::factory()->setTTL($myTTL);
    }
}
