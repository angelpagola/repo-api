<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::get();
    }

    public function show($id)
    {
        return Usuario::find($id);
    }

    public function login(Request $request)
    {
        $callback = Usuario::query()
            ->where('usuario', $request->usuario)
            ->where('activo', true);
			
        $usuario = $callback->first();

        if ($usuario) {
            if (Hash::check($request->password, $usuario->password)) {
				return response()->json([
					'respuesta' => true,
					'mensaje' => $callback->select('id', 'usuario', 'estudiante_id')->with('estudiante:id,nombres,apellidos,avatar')->first()
				], 200);
			} else {
				return response()->json([
					'respuesta' => false,
					'mensaje' => 'Las credenciales proporcionados son erroneas.'
				], 200);
			}
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con estas credenciales en el sistema.'
            ], 200);
        }
    }
}
