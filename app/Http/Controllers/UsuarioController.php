<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\SignupUsuario;
use App\Models\Estudiante;
use App\Models\ProyectoImagen;
use App\Models\TemaInteres;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

    public function signup(Request $request)
    {
        $rules = [
            "nombres" => "required|max:40",
            "apellidos" => "required|max:40",
            "escuela_id" => "required|integer|gt:0",
            "username" => "required|unique:usuarios,usuario|max:25",
            "password" => "required|min:8",
            "correo" => "unique:estudiantes,correo|max:100",
            "telefono" => "unique:estudiantes,telefono|min:9",
            "linkedin" => "unique:estudiantes,linkedin|max:100",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'respuesta' => false,
                    'mensaje' => 'Error de validación',
                    'error' => $validator->errors(),
                ]
            ], 422);
        } else {
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
                'usuario' => $request->username,
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
            ], 201);
        }
    }

    public function show($id)
    {
        $usuario = Usuario::query()
            ->select('id', 'usuario', 'estudiante_id')
            ->with('estudiante:id,nombres,apellidos,correo,telefono,linkedin,escuela_id')
            ->find($id);

        if ($usuario)
            return response()->json(["respuesta" => true, "mensaje" => $usuario], 200);

        return response()->json(["respuesta" => false, "mensaje" => "No hay ningun usuario con este ID"], 204);
    }

    public function avatar($id)
    {
        $avatar = Usuario::query()
            ->select('id', 'estudiante_id')
            ->with('estudiante:id,avatar')
            ->find($id);

        if ($avatar)
            return response()->json(["respuesta" => true, "mensaje" => $avatar->estudiante->avatar], 200);

        return response()->json(["respuesta" => false, "mensaje" => "No hay ningun usuario con este ID"], 204);
    }

    public function interes($id)
    {
        $temas = Usuario::query()
            ->select('id')
            ->with('tag')
            ->find($id);

        if ($temas)
            return response()->json(["respuesta" => true, "mensaje" => $temas->tag], 200);

        return response()->json(["respuesta" => false, "mensaje" => "No hay ningun usuario con este ID"], 204);
    }

    public function avatarUpdate(Request $request)
    {
        $rules = [
            "avatar" => "required",
            "avatar.*" => "image|mimes:png,jpeg,jpg",
            "usuarioId" => "required|integer|gt:0",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'respuesta' => false,
                    'mensaje' => 'Error de validación',
                    'error' => $validator->errors(),
                ]
            ], 422);
        } else {
            $usuario = Usuario::query()->where('id', $request->usuarioId);

            if ($request->hasFile('avatar')) {
                $rutaCarpeta = 'public/storage/avatars/' . $usuario->id;

                //verificar si existe la carpeta public/storage/avatars, crear si no existe
                if (!Storage::exists($rutaCarpeta)) {
                    Storage::makeDirectory($rutaCarpeta);
                }

                $nombreArchivo = $request->file('avatar')->getClientOriginalName();
                if (!$nombreArchivo) {
                    $nombreArchivo = "Archivo adjunto";
                }

                $existe = Storage::disk('public')->exists('storage/avatars/' . $nombreArchivo);
                $num = 0;
                if ($existe) {
                    $aux = $nombreArchivo;
                    while ($existe) {
                        $num++;
                        $aux = $num . '_' . $aux;
                        $existe = Storage::disk('public')->exists('storage/avatars/' . $aux);
                        $aux = $nombreArchivo;
                    }
                    $nombreArchivo = $num . '_' . $nombreArchivo;
                }

                $url = 'storage/avatars/' . $usuario->id . '/';
                $request->file('avatar')->storeAs($rutaCarpeta, asset($url . $nombreArchivo));

                $estudiante = Estudiante::find($usuario->estudiante_id);

                $estudiante->update([
                    "avatar" => asset($url . $nombreArchivo)
                ]);

                return response()->json([
                    'respuesta' => true,
                    'mensaje' => 'Avatar del Usuario Editado Correctamente'
                ], 201);
            }
        }
    }
}
