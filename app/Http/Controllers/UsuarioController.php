<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Tag;
use App\Models\TemaInteres;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    // TODO: Ok
    public function login(Request $request)
    {
        $callback = Usuario::query()
            ->where('usuario', $request->usuario)
            ->where('activo', true);

        $usuario = $callback->first();

        if (!$usuario) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario activo con estas credenciales en el sistema.'
            ]);
        }

        if (!Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Las credenciales proporcionados son erroneas.'
            ]);
        }

        return response()->json([
            'respuesta' => true,
            'mensaje' => $callback->select('id', 'usuario', 'avatar', 'estudiante_id')->with('estudiante:id,nombres,apellidos')->first()
        ]);
    }

    // TODO: Ok
    public function signup(Request $request)
    {
        $rules = [
            "nombres" => "required|max:40",
            "apellidos" => "required|max:40",
            "escuela_id" => "required|integer|gt:0",
            "username" => "required|unique:usuarios,usuario|max:25|min:5",
            "password" => "required|min:8",
            "correo" => "nullable|unique:estudiantes,correo|max:100",
            "telefono" => "nullable|unique:estudiantes,telefono|max:9|min:9",
            "linkedin" => "nullable|url|unique:estudiantes,linkedin|max:100",
            'tags' => 'required|array|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error de validación', 'error' => $validator->errors()
            ]);
        }

        $estudiante = Estudiante::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'linkedin' => $request->linkedin,
            'escuela_id' => $request->escuela_id,
        ]);

        $nombre_usuario = strtolower($request->username);
        $nombre_usuario = str_replace(" ", "_", $nombre_usuario);
        $nombre_usuario = str_replace(".", "", $nombre_usuario);
        $nombre_usuario = str_replace("/", "", $nombre_usuario);
        $nombre_usuario = str_replace("=", "", $nombre_usuario);

        $usuario = Usuario::create([
            'uuid' => Str::uuid(),
            'usuario' => $nombre_usuario,
            'password' => Hash::make($request->password),
            'activo' => true,
            'estudiante_id' => $estudiante->id
        ]);

        $usuario->intereses()->attach($request->tags);

        return response()->json([
            'respuesta' => true,
            'mensaje' => Usuario::query()
                ->select("id", "usuario", "estudiante_id", "avatar")
                ->with('estudiante:id,nombres,apellidos')->find($usuario->id)
        ], 201);
    }

    // TODO: Ok
    public function usuarioUpdate(Request $request, $usuario_id)
    {
        $usuario = Usuario::find($usuario_id);

        if (!$usuario) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este id en el sistema.'
            ]);
        }

        $rules = [
            "nombres" => "required|max:40",
            "apellidos" => "required|max:40",
            "escuela_id" => "required|integer|gt:0",
            "correo" => "nullable|max:100|unique:estudiantes,correo," . $usuario->estudiante_id,
            "telefono" => "nullable|min:9|unique:estudiantes,telefono," . $usuario->estudiante_id,
            "linkedin" => "nullable|max:100|unique:estudiantes,linkedin," . $usuario->estudiante_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error de validación', 'error' => $validator->errors()
            ]);
        }

        $estudiante = Estudiante::find($usuario->estudiante_id);

        $estudiante->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'linkedin' => $request->linkedin,
            'escuela_id' => $request->escuela_id,
        ]);

        return response()->json([
            'respuesta' => true,
            'mensaje' => 'Datos de Usurio Editado Correctamente'
        ], 201);
    }

    // TODO: Ok
    public function show($usuario_id)
    {
        $usuario = Usuario::query()
            ->select('id', 'usuario', 'estudiante_id')
            ->with('estudiante:id,nombres,apellidos,correo,telefono,linkedin,escuela_id')
            ->find($usuario_id);

        if (!$usuario)
            return response()->json(["respuesta" => false, "mensaje" => "No hay ningun usuario con este ID"], 200);

        return response()->json(["respuesta" => true, "mensaje" => [
            "id" => $usuario->id,
            "estudiante_id" => $usuario->estudiante_id,
            "usuario" => $usuario->usuario,
            "nombres" => $usuario->estudiante->nombres,
            "apellidos" => $usuario->estudiante->apellidos,
            "escuela_id" => $usuario->estudiante->escuela_id,
            "correo" => $usuario->estudiante->correo,
            "telefono" => $usuario->estudiante->telefono,
            "linkedin" => $usuario->estudiante->linkedin,
        ]]);
    }

    // TODO: Ok
    public function avatar($usuario_id)
    {
        $avatar = Usuario::query()
            ->select('avatar')
            ->find($usuario_id);

        if ($avatar)
            return response()->json(["respuesta" => true, "mensaje" => $avatar->avatar]);

        return response()->json(["respuesta" => false, "mensaje" => "No hay ningún usuario con este ID"]);
    }

    // TODO: Ok
    public function interes($usuario_id)
    {
        $temas = Usuario::query()
            ->select('id')
            ->with('intereses')
            ->find($usuario_id);

        if ($temas)
            return response()->json(["respuesta" => true, "mensaje" => $temas->intereses]);

        return response()->json(["respuesta" => false, "mensaje" => "No hay ningun usuario con este ID"], 204);
    }

    // TODO: Ok
    public function avatarUpdate(Request $request, $usuario_id)
    {
        $usuario = Usuario::find($usuario_id);

        if (!$usuario) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún usuario con este id en el sistema.'
            ]);
        }

        $rules = [
            "avatar" => "required",
            "avatar.*" => "image|mimes:png,jpeg,jpg",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error de validación ',
                'error' => $validator->errors(),
            ]);
        }

        $rutaCarpeta = 'public/avatars';

        //verificar si existe la carpeta public/storage/avatars, crear si no existe
        if (!Storage::exists($rutaCarpeta)) {
            Storage::makeDirectory($rutaCarpeta);
        }

        $nombreArchivo = 'repotweb_avatar_' . $usuario->id . '_' . time() . rand(1, 99) . '.' . $request->file('avatar')->getClientOriginalExtension();

        $url = 'storage/avatars/';
        $request->file('avatar')->storeAs($rutaCarpeta, $nombreArchivo);

        $link_avatar = asset($url . $nombreArchivo);

        $usuario->update([
            "avatar" => $link_avatar
        ]);

        return response()->json([
            'respuesta' => true,
            'mensaje' => $link_avatar
        ], 201);
    }

    // TODO: Ok
    public function interesDelete($tag_id)
    {
        $interes = TemaInteres::query()
            ->find($tag_id);

        if ($interes) {
            $interes->delete();
            return response()->json([
                'respuesta' => true,
                'mensaje' => 'Este tema ya no es del interes del usuario.'
            ], 201);
        } else {
            return response()->json([
                'respuesta' => false,
                'mensaje' => 'No existe ningún temas de interes.'
            ], 200);
        }
    }
}
