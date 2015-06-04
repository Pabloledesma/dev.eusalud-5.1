<?php namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests;
use DB;

trait CertificadoIca {
   
    /**
    * Muestra el formulario para generar el informe de certificado ica
    ***/ 
    public function form_certificado_ica()
    {
        $formato_de_salida = false; // Esta variable sera false mientras no esten disponibles los formatos pdf y excel
        $formato = array( 'pdf' => false, 'excel' => false );
        return view('info.certificado_ica', compact('formato', 'formato_de_salida'));
    }

     /**
    * Muestra el informe de certificado ica
    ***/ 
    public function certificado_ica(Requests\Certificado_de_pagos $request)
    {
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }

        $headerTitle = "CERTIFICADO DE RETENCION INDUSTRIA Y COMERCIO (ICA)";
        $fileTitle = "certificado_de_retencion_industria_y_comercio_ica";

        $query3 = "SELECT 
            dbo.MOVCONT3.MvCFch, 
            dbo.MOVCONT3.MvCEst, 
            '====' AS Expr1, 
            dbo.MOVCONT2.CntCod, 
            dbo.CUENTAS.CntDsc, 
            dbo.MOVCONT2.TrcCod, 
            dbo.TERCEROS.TrcRazSoc, 
            dbo.MOVCONT2.MvCVlr, 
            dbo.MOVCONT2.MvCDocRf1, 
            dbo.MOVCONT2.MvCDocRf2, 
            dbo.MOVCONT2.MvCNat, 
            dbo.MOVCONT2.MvCDet, 
            dbo.MOVCONT2.MvCBse, 
            dbo.MOVCONT2.MvCImpCod, 
            dbo.MOVCONT2.MvCCFch, 
            dbo.MOVCONT2.MvCMes, 
            dbo.MOVCONT2.MvCAnio, 
            dbo.MOVCONT2.MvCSedOrg
            FROM ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD) AND 
                (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
                (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto)) 
                LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig) AND 
                (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod)) LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
            WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
                    convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
                    ((dbo.MOVCONT2.CntCod) Like '2368%') AND ((dbo.MOVCONT2.TrcCod)='".$num_id."'))";
        
        $query2 = "SELECT 
	dbo.MOVCONT2.CntCod, 
	dbo.CUENTAS.CntDsc, 
	dbo.MOVCONT2.TrcCod, 
	dbo.TERCEROS.TrcRazSoc, 
	dbo.MOVCONT2.MvCNat, 
	Sum(dbo.MOVCONT2.MvCVlr) AS SumaDeMvCVlr, 
	Sum(dbo.MOVCONT2.MvCBse) AS SumaDeMvCBse
	FROM ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
		(dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
		(dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
		(dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
	WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '". $input['fecha_inicio'] ."' ,101) And convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N')
			and ((dbo.MOVCONT2.CntCod) Like '2368%') AND ((dbo.MOVCONT2.TrcCod)='".$num_id."'))
			GROUP BY dbo.MOVCONT2.CntCod, dbo.MOVCONT2.MvCNat, dbo.CUENTAS.CntDsc, dbo.MOVCONT2.TrcCod, dbo.TERCEROS.TrcRazSoc
			ORDER BY dbo.MOVCONT2.CntCod DESC";

        $query = "SELECT 
                Sum( CASE WHEN mvcnat='D' THEN -1*(MvCVlr) ELSE MvCVlr END ) AS VALOR, 
                Sum( CASE WHEN mvcnat='D' THEN -1*(MvCbse) ELSE MvCbse END ) AS BASE
            FROM ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
                (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
                (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
                (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) LEFT JOIN dbo.CUENTAS ON 
                (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
                (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) 
                LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
            WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
                convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
                ((dbo.MOVCONT2.CntCod) Like '2368%') AND ((dbo.MOVCONT2.TrcCod)='".$num_id."'))";

        $info = DB::connection('sqlsrv_info')->select($query2);
        $valor_base = DB::connection('sqlsrv_info')->select($query);
        //return $valor_base;
        if (isset($info, $valor_base) && count($info) > 0 && count($valor_base) > 0) {
            $valor_en_letras = $this->numerotexto( $valor_base[0]->VALOR );

//            PDF
//            $html = view('info.informe_ica_pdf', compact('info', 'input', 'headerTitle', 'valor_base', 'valor_en_letras'))->render();
//            return $this->pdf->load($html)
//                            ->filename($fileTitle . date('Y-m-d H:i:s') . '.pdf')
//                            
//                            ->download();
            
            //HTML
            return view('info.informe_ica_pdf', compact('info', 'input', 'headerTitle', 'valor_base', 'valor_en_letras'));
            
            
            //EXCEL
//            $this->excel->create('informe_ica', function($excel) use($info, $input, $headerTitle, $valor_base, $valor_en_letras) {
//                $excel->sheet('Sheetname', function($sheet) use($info, $input, $headerTitle, $valor_base, $valor_en_letras) {
//                    $sheet->mergeCells('A1:K1');
//                    $sheet->mergeCells('A2:K2');
//                    $sheet->mergeCells('A3:K3');
//                    $data = [];
//
//                    /*** Cabecera ***/
//
//                    array_push($data, array('Clínica EuSalud'));
//                    array_push($data, array('Certificado de pagos a profesionales de la salud'));
//                    array_push($data, array('Tercero', 'Nombre del Tercero'));
//                    array_push($data, array( $info[0]->TrcCod, $info[0]->TrcRazSoc));
//                });
//            })->download('xlsx');
        }
 
        return view('info.sin_resultados', compact('headerTitle'));
    }

}