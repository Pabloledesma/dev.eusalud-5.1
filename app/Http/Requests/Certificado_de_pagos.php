<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class Certificado_de_pagos extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
       
        return true;
    }

    /**
     * Reglas de validación para el certificado de pagos

     *
     * @return array
     */
    public function rules() {
        $rules = array(
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_final' => 'required|after:fecha_inicio|date_format:Y-m-d'
        );
       
        return $rules;
    }

    /*
     * Mensages personalizados
     * @return array
     */

    public function messages() {

        return [

            'fehca_inicio.required'     => 'Debe ingresar la fecha inicial',
            'fecha_inicio.date_format'  => 'El formato de la fecha debe ser yyyy-mm-dd. Verifique.',
            'fecha_final.required'      => 'Debe diligenciar la fecha final',
            'fecha_final.date_format'   => 'El formato de la fecha debe ser yyyy-mm-dd. Verifique.',
            'fecha_final.after'         => 'La fecha final debe ser mayor que la fecha inicial.'
        ];
    }

}
