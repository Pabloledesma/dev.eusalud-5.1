<?php

namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests;
use Vsmoraes\Pdf\PDF;
use DB;

trait PagoProveedores 
{
  /**
    * Muestra el formulario para generar el informe de Pago a proveedores
    *
    * @param  Boolean   $outPut Esta variable sera false mientras no esten disponibles los formatos pdf y excel
    *         En el valor true, el boton del formulario será Descargar. Si es false, el boton cambia a generar
    * @param  Array     $formato Indica si esta disponible esta funcionalidad
    * @return View
    */
    public function form_pago_proveedores($outPut = false, $formato = array( 'pdf' => true, 'excel' => false )) {
       
        return view('info.pago_proveedores', compact('formato', 'outPut'));
    }

   /**
     * Genera el certificado de pago a proveedores según el rango de fechas ingresadas en el formulario
     * 
     * @param 	Requests\Certificado_de_pagos $request  validación de los datos
     * @param   PDF $pdf  
     * @return 	View
     */
    public function pago_proveedores(Requests\Certificado_de_pagos $request, PDF $pdf) {
        
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
                'Ups! Disculpenos. Tenemos inconvenientes con el sistema. Por favor intentelo mas tarde',
                'Aplicación de EuSalud' 
            );
            return redirect('/');
        }

        if( isset($info) ){
            // si hay menos de 100 resultados le genera un pdf
            if( count($info) < 100 ){

                $html = view('info.informe', compact('info', 'input', 'headerTitle'))->render();
                return $pdf->load($html, array(0, 0, 1300, 800))
                            ->filename('informe_de_pago_a_proveedores_' . date('Y-m-d H:i:s') . '.pdf')
                            ->download();

            }

            // si hay mas de 100 resultados genera una vista html
            if ( count($info) > 100) {
                return view('info.informe', compact('info', 'headerTitle', 'input'));
            }
        }
        
        return view('info.sin_resultados', compact('input'));
    }

}
