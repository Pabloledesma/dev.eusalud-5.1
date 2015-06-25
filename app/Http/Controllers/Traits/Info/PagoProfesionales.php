<?php

namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests;
use Vsmoraes\Pdf\PDF;
use DB;

trait PagoProfesionales 
{
	/**
     * Muestra el formulario para generar el Certificado de pagos a profesionales de la salud
     *
     * @param   Boolean $outPut     Esta variable sera false mientras no esten disponibles los formatos pdf y excel
     * @param   Array   $formato    Indica si esta disponible esta funcionalidad
     * @return View 
     */
    public function form_certificado_pagos_profesionales($outPut = true, $formato = array( 'pdf' => true, 'excel' => false )) {
        
        return view('info.certificado_pagos', compact('formato', 'outPut'));
    }

     /**
     * Genera el certificado de pagos a profesionales de la salud segun los parametros establecidos en el formulario
     *
     * @param 	Requests\Certificado_de_pagos $request
     * @return 	Mixed view || xls || pdf
     */
    public function certificado_pagos_profesionales(Requests\Certificado_de_pagos $request) {
        
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

        $info = DB::connection('sqlsrv_info_90')->select($query);

        //Seleccion de formato
        if( $input['formato'] == 'pdf' ){

            if (isset($info) && count($info) > 0) {
            $html = view('info.informe', compact('info', 'input', 'headerTitle'))->render();
            return $this->pdf->load($html, array(0, 0, 1300, 800))
                            ->filename($fileTitle . date('Y-m-d H:i:s') . '.pdf')
                            ->download();
            }
        } else {

            $this->excel->create('Certificado de pagos a profesionales de la salud', function($excel) use($info, $input, $headerTitle) {
            $excel->sheet('Sheetname', function($sheet) use($info, $input, $headerTitle) {
                 
                /*

                Con esta opción renderiza el archivo de excel directamente desde el html
                
                $sheet->loadview('info.informe', compact('info', 'headerTitle', 'input'));
                $sheet->setFontFamily('Comic Sans MS');
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  12,
                        'bold'      =>  true
                    )
                ));
                */
                $sheet->mergeCells('A1:M1');
                $sheet->mergeCells('A2:M2');
                $sheet->setAutoSize(true);
                $data = [];

                /*** Cabecera ***/
                
                array_push($data, array('Clínica EuSalud'));
                array_push($data, array('Certificado de pagos a profesionales de la salud'));
                array_push($data, array('Tercero', 'Nombre del Tercero'));
                array_push($data, array( $info[0]->TrcCod, $info[0]->TrcRazSoc));
                array_push($data, array(
                    'Documento Contable',
                    'Numero de documento contable',
                    'Fecha',
                    'Naturaleza',
                    'Tipo de Cuenta',
                    'Cuenta',
                    'Nombre de cuenta',
                    'Valor',
                    'Referencia 1',
                    'Referencia 2',
                    'Detalle',
                    'Base',
                    'Impuesto',
                ));
                
                /*** Información ***/
                          
                    foreach( $info as $row ){
                        array_push($data, array(
                            $row->DOCCOD,
                            $row->MvCNro,
                            $row->MvCFch,
                            $row->MvCNat,
                            $row->CntInt,
                            $row->CntCod,
                            $row->CntDsc,
                            '$' . number_format( $row->MvCVlr ),
                            $row->MvCDocRf1,
                            $row->MvCDocRf2,
                            $row->MvCDet,
                            '$' . number_format( $row->MvCBse ),
                            $row->MvCImpCod,
                        ));
                    }
                               
                $sheet->fromArray($data, null, 'A1', false, false);
                
                /*** ESTILOS ***/
                
                $sheet->cells('A1:M1', function($cells) {

                    $cells->setFontColor('#ffffff');
                    $cells->setFontFamily('Calibri');
                    $cells->setFontSize(16);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('middle');
                    $cells->setBackground('#1E7F74');
                });
                $sheet->cells('A2:M2', function($cells) {

                    $cells->setFontColor('#ffffff');
                    $cells->setFontFamily('Calibri');
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('middle');
                    $cells->setBackground('#1E7F74');
                });

                $sheet->cells('A3:M3', function($cells) {
                    $cells->setFontColor('#000000');
                    $cells->setFontFamily('Calibri');
                    $cells->setFontSize(10);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('middle');
                    $cells->setBackground('#FFFFFF');
                  });
                });
            })->download('xlsx');

        } // fin de condicional de seleccion de formato

        
        return view('info.sin_resultados', compact('input', 'headerTitle'));
    }
}