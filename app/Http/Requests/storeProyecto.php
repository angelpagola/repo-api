<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeProyecto extends FormRequest
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
            'titulo' => 'required|max:200',
            'resumen' => 'required|max:1000',
            'fecha_publicacion' => 'required|date',
            'estudiante_id' => 'required|integer|gt:0',
        ];
    }
}
