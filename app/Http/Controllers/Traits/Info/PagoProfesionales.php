<?php

namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests\Certificado_de_pagos;
use DB;


trait PagoProfesionales 
{
	/**
     * Muestra el formulario para generar el Certificado de pagos a profesionales de la salud 
     * Este formulario es para los administradores y asistentes de gerencia
     *
     * @param   Boolean $outPut     Esta variable sera false mientras no esten disponibles los formatos pdf y excel
     * @param   Array   $formato    Indica si esta disponible esta funcionalidad
     * @return View 
     */
    public function form_certificado_pagos_profesionales_admin($outPut = true, $formato = array( 'pdf' => true, 'excel' => false )) {
        return view('info.form_pagos_admin', compact('formato', 'outPut'));
    }

    /**
     * Muestra el formulario para generar el Certificado de pagos a profesionales de la salud para profesionales
     *
     * @param   Boolean $outPut     Esta variable sera false mientras no esten disponibles los formatos pdf y excel
     * @param   Array   $formato    Indica si esta disponible esta funcionalidad
     * @return View 
     */
    public function form_certificado_pagos_profesionales($outPut = true, $formato = array( 'pdf' => true, 'excel' => false )) {
        
        return view('info.form_pagos_profesionales', compact('formato', 'outPut'));
    }


     /**
     * Genera el certificado de pagos a profesionales de la salud segun los parametros establecidos en el formulario
     *
     * @param 	Requests\Certificado_de_pagos $request
     * @return 	Mixed view || xls || pdf
     */
    public function certificado_pagos_profesionales(Certificado_de_pagos $request) {
        
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }

        // Titulo de la vista
        $headerTitle = 'Certificado de pagos a profesionales de la salud';
        
        //Nombre del archivo
        $fileTitle = 'certificado_de_pagos_profesionales_';

        $query = "EXECUTE pago_profesionales @fecha_inicial = '" . $input['fecha_inicio'] . "', @fecha_final = '" .$input['fecha_final']. "', @id_profesional = '" . $num_id . "'";

        try {
            $info = DB::connection('sqlsrv_info_90')->select($query);
        }
        catch( \Exception $e ){
            flash()->overlay(
                'Ups!',
                'Disculpenos. Tenemos inconvenientes con el sistema. Por favor intentelo mas tarde',
                'error' 
            );
            return redirect('/');
        }

        if (isset($info) && count($info) > 0) {
            $html = view('info.informe_pagos_profesionales', compact('info', 'input', 'headerTitle'))->render();
            $filename = $fileTitle . date('Ymd_H:i:s') . '.pdf';
            $pdf = \PDF::loadHtml( $html )->setPaper('a4')->setOrientation('landscape');
            return $pdf->download( $filename );        
        }
        
        flash()->overlay(
            'Ups!',
            'No se encontraron resultados para los datos ingresados',
            'warning' 
        );
        return redirect()->back();

    }
}