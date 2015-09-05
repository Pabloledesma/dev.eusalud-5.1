<?php

namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests\Certificado_de_pagos;
use DB;

trait PagoProveedores 
{
  /**
    * Muestra el formulario para generar el informe de Pago a proveedores para administradores
    *
    * @param  Boolean   $outPut Esta variable sera false mientras no esten disponibles los formatos pdf y excel
    *         En el valor true, el boton del formulario será Descargar. Si es false, el boton cambia a generar
    * @param  Array     $formato Indica si esta disponible esta funcionalidad
    * @return View
    */
    public function form_pago_proveedores_admin($outPut = false, $formato = array( 'pdf' => true, 'excel' => false )) {
       
        return view('info.form_pago_proveedores_admin', compact('formato', 'outPut'));
    }

    /**
    * Muestra el formulario para generar el informe de Pago a proveedores para Proveedores
    *
    * @param  Boolean   $outPut Esta variable sera false mientras no esten disponibles los formatos pdf y excel
    *         En el valor true, el boton del formulario será Descargar. Si es false, el boton cambia a generar
    * @param  Array     $formato Indica si esta disponible esta funcionalidad
    * @return View
    */
    public function form_pago_proveedores($outPut = false, $formato = array( 'pdf' => true, 'excel' => false )) {
       
        return view('info.form_pago_proveedores', compact('formato', 'outPut'));
    }

   /**
     * Genera el certificado de pago a proveedores según el rango de fechas ingresadas en el formulario
     * 
     * @param 	Requests\Certificado_de_pagos $request  validación de los datos
     * @param   PDF $pdf  
     * @return 	View
     */
    public function pago_proveedores(Certificado_de_pagos $request) {
        
        //Definición de entradas
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }
        
        // Titulo de la vista
        $headerTitle = 'Informe de pago a proveedores';
        
        $query = "EXECUTE pago_proveedores @fecha_inicial = '" . $input['fecha_inicio'] . "', @fecha_final = '" .$input['fecha_final']. "', @id_proveedor = '" . $num_id . "'";
       
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

        if( isset($info) && count($info) > 0 ){
            $filename = 'informe_de_pago_a_proveedores_' . date('Y-m-d H:i:s') . '.pdf';
            $html = view('info.informe_pagos_profesionales', compact('info', 'input', 'headerTitle'))->render();
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
