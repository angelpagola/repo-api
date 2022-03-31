<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\signupUsuario;
use App\Models\Estudiante;
use App\Models\TemaInteres;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
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

    public function signup(signupUsuario $request)
    {
        $estudiante = Estudiante::create([
            'uuid' => Str::uuid(),
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'linkedin' => $request->linkedin,
            'escuela_id' => $request->escuela_id,
        ]);

        $usuario = Usuario::create([
            'uuid' => Str::uuid(),
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password),
            'activo' => 1,
            'estudiante_id' => $estudiante->id
        ]);

        foreach ($request->tag_id as $tagid) {
            TemaInteres::create([
                'usuario_id' => $usuario->id,
                'tag_id' => $tagid
            ]);
        }

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Usuario Creado Correctamente'
        ], 200);
    }
}
