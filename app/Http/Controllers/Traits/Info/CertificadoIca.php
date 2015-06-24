<?php 

namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests;
use DB;

trait CertificadoIca 
{
   
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

        /**
    * Convierte un valor numérico a letras
    * @param $numero decimal que se quiere convertir
    * @return String
    **/
   function numerotexto ($numero) { 
    // Primero tomamos el numero y le quitamos los caracteres especiales y extras 
    // Dejando solamente el punto "." que separa los decimales 
    // Si encuentra mas de un punto, devuelve error. 
    // NOTA: Para los paises en que el punto y la coma se usan de forma 
    // inversa, solo hay que cambiar la coma por punto en el array de "extras" 
    // y el punto por coma en el explode de $partes 
     
    $extras= array("/[\$]/","/ /","/,/","/-/"); 
    $limpio=preg_replace($extras,"",$numero); 
    $partes=explode(".",$limpio); 
    if (count($partes)>2) { 
        return "Error, el n&uacute;mero no es correcto"; 
        exit(); 
    } 
     
    // Ahora explotamos la parte del numero en elementos de un array que 
    // llamaremos $digitos, y contamos los grupos de tres digitos 
    // resultantes 
     
    $digitos_piezas=chunk_split ($partes[0],1,"#"); 
    $digitos_piezas=substr($digitos_piezas,0,strlen($digitos_piezas)-1); 
    $digitos=explode("#",$digitos_piezas); 
    $todos=count($digitos); 
    $grupos=ceil (count($digitos)/3); 
     
    // comenzamos a dar formato a cada grupo 
     
    $unidad = array   ('un','dos','tres','cuatro','cinco','seis','siete','ocho','nueve'); 
    $decenas = array ('diez','once','doce', 'trece','catorce','quince'); 
    $decena = array   ('dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa'); 
    $centena = array   ('ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos'); 
    $resto=$todos; 
     
    for ($i=1; $i<=$grupos; $i++) { 
         
        // Hacemos el grupo 
        if ($resto>=3) { 
            $corte=3; } else { 
            $corte=$resto; 
        } 
            $offset=(($i*3)-3)+$corte; 
            $offset=$offset*(-1); 
         
        // la siguiente seccion es una adaptacion de la contribucion de cofyman y JavierB 
         
        $num=implode("",array_slice ($digitos,$offset,$corte)); 
        $resultado[$i] = ""; 
        $cen = (int) ($num / 100);              //Cifra de las centenas 
        $doble = $num - ($cen*100);             //Cifras de las decenas y unidades 
        $dec = (int)($num / 10) - ($cen*10);    //Cifra de las decenas 
        $uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 
        if ($cen > 0) { 
           if ($num == 100) $resultado[$i] = "cien"; 
           else $resultado[$i] = $centena[$cen-1].' '; 
        }//end if 
        if ($doble>0) { 
           if ($doble == 20) { 
              $resultado[$i] .= " veinte"; 
           }elseif (($doble < 16) and ($doble>9)) { 
              $resultado[$i] .= $decenas[$doble-10]; 
           }else { 
              @$resultado[$i] .=' '. $decena[$dec-1]; 
           }//end if 
           if ($dec>2 and $uni<>0) $resultado[$i] .=' y '; 
           if (($uni>0) and ($doble>15) or ($dec==0)) { 
              if ($i==1 && $uni == 1) $resultado[$i].="uno"; 
              elseif ($i==2 && $num == 1) $resultado[$i].=""; 
              else $resultado[$i].=$unidad[$uni-1]; 
           } 
        } 

        // Le agregamos la terminacion del grupo 
        switch ($i) { 
            case 2: 
            $resultado[$i].= ($resultado[$i]=="") ? "" : " mil "; 
            break; 
            case 3: 
            $resultado[$i].= ($num==1) ? " mill&oacute;n " : " millones "; 
            break; 
        } 
        $resto-=$corte; 
    } 
     
    // Sacamos el resultado (primero invertimos el array) 
    $resultado_inv= array_reverse($resultado, TRUE); 
    $final=""; 
    foreach ($resultado_inv as $parte){ 
        $final.=$parte; 
    } 
    return $final . " pesos moneda corriente."; 
    }
    

}