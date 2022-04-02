<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class SignupUsuario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nombres" => "required|max:40",
            "apellidos" => "required|max:40",
            "escuela_id" => "required|integer|gt:0",
            "username" => "required|unique:usuarios,usuario|max:25",
            "password" => "required|min:8",
            "correo" => "unique:estudiantes,correo|max:100",
            "telefono" => "unique:estudiantes,telefono|min:9",
            "linkedin" => "unique:estudiantes,linkedin|max:100",
        ];
    }
}
