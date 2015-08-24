<?php 

namespace App\Http\Controllers\Traits\Info;

use App\Http\Requests\Certificado_de_pagos;
use DB;

trait CertificadoIca 
{
   
  /**
    * Muestra el formulario para generar el informe de certificado ica para administradores
    *
    * @param  Boolean   $outPut Esta variable sera false mientras no esten disponibles los formatos pdf y excel
    *         En el valor true, el boton del formulario será Descargar. Si es false, el boton cambia a generar
    * @param  Array     $formato Indica si esta disponible esta funcionalidad
    * @return View
    ***/ 
    public function form_certificado_ica_admin($outPut = false, $formato = array( 'pdf' => false, 'excel' => false ))
    {
        if( $formato['pdf'] || $formato['excel'] )
            return view('info.certificado_ica', compact('formato', 'outPut'));
        return view('info.certificado_ica_admin', compact('outPut'));

    }

   /**
    * Muestra el formulario para generar el informe de certificado ica para profesionales
    *
    * @param  Boolean   $outPut Esta variable sera false mientras no esten disponibles los formatos pdf y excel
    *         En el valor true, el boton del formulario será Descargar. Si es false, el boton cambia a generar
    * @param  Array     $formato Indica si esta disponible esta funcionalidad
    * @return View
    ***/ 
    public function form_certificado_ica($outPut = false, $formato = array( 'pdf' => false, 'excel' => false ))
    {
        if( $formato['pdf'] || $formato['excel'] )
            return view('info.certificado_ica', compact('formato', 'outPut'));
        return view('info.certificado_ica', compact('outPut'));

    }

  /**
    * Muestra el informe de certificado ica
    *
    * @param    Requests\Certificado_de_pagos $request  validación de los datos
    * @return   View
    */ 
    public function certificado_ica(Certificado_de_pagos $request)
    {
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }

        $headerTitle = "Certificado de Retención Industria y Comercio (ICA)";
        $fileTitle = "certificado_ica";
                
        $query = "EXECUTE certificado_ICA @fecha_inicial = '" . $input['fecha_inicio'] . "', @fecha_final = '" .$input['fecha_final']. "', @id_profesional = '" . $num_id . "'";

        try 
        {
            $info = DB::connection('sqlsrv_info_90')->select($query);
        }

        catch( \Exception $e )
        {
            flash()->overlay("Por favor disculpenos, intentelo mas tarde.", "Aplicación de Eusalud");
            return redirect('info/form_certificado_ica');
        }
        

        if (isset($info) && count($info) > 0) {
            
            $valor_en_letras = $this->numerotexto($info[0]->VALOR);
            $valor_retenido = $info[0]->VALOR;
            $valor_base = $info[0]->BASE;

            //dd("valor base: " . $valor_base . " Valor retenido: " . $valor_retenido);
        
            $html = view(
                'info.informe_ica_pdf', 
                compact(
                    'info', 
                    'input', 
                    'headerTitle', 
                    'valor_en_letras',
                    'valor_retenido',
                    'valor_base'
            ))->render();

            $filename = 'ICA_' . date('Ymd_H:i:s') . '.pdf';
            $pdf = \PDF::loadHtml( $html )->setPaper('a4')->setOrientation('landscape');
            return $pdf->download( $filename ); 
            
        }

        flash()->overlay(
            'No se encontraron resultados para los datos ingresados',
            'Aplicación de EuSalud' 
        );
        return redirect()->back();
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