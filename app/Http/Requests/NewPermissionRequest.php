<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewPermissionRequest extends Request
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
            'permission_title' => 'required|min:3',
            'permission_slug'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'permission_title.required' => 'El titulo del permiso es requerido.',
            'permission_title.min'      => 'El titulo del permiso debe tener minimo 3 caracteres',
            'permission_slug'           => 'El alias es requerido'
        ];
    } 
}
