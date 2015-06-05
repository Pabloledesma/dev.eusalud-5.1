<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
//use Barryvdh\DomPDF\PDF;
use DB;
use Maatwebsite\Excel\Excel;
use Psy\Util\String;
use Vsmoraes\Pdf\Pdf;
use function view;

class InfoController extends Controller {

    private $pdf;
    private $excel; 

    public function __construct(Pdf $pdf, Excel $excel) {
        $this->middleware('auth');
        $this->pdf = $pdf;
        $this->excel = $excel;
    }

    /**
    * Muestra una lista con los formularios disponibles
    ***/
    public function index() {
        return view('info.index');
    }

    /*** TRAITS ***/
    use Traits\Info\CertificadoIca;

    /*
     * Muestra el formulario para generar el Certificado de pagos a profesionales de la salud
     * La variable $formato indica si esta disponible esta funcionalidad
     */
    public function form_certificado_pagos_profesionales() {
        $formato_de_salida = true; // Esta variable sera false mientras no esten disponibles los formatos pdf y excel
        $formato = array( 'pdf' => true, 'excel' => true );
        return view('info.certificado_pagos', compact('formato', 'formato_de_salida'));
    }

    /**
    * Muestra el formulario para generar el informe de Pago a proveedores
    * La variable $formato indica si esta disponible esta funcionalidad
    ***/
    public function form_pago_proveedores() {
        $formato_de_salida = true; // Esta variable sera false mientras no esten disponibles los formatos pdf y excel
        $formato = array( 'pdf' => true, 'excel' => false ); 
        return view('info.pago_proveedores', compact('formato', 'formato_de_salida'));
    }

    /**
    * Muestra el formulario para generar el informe de Pago a proveedores en excel
    ***/
    public function form_certificado_pagos_profesionales_excel()
    {
        return view('info.certificado_pagos_excel');
    }

    public function pago_proveedores(Requests\Certificado_de_pagos $request) {
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }
        $headerTitle = 'Informe de pago a proveedores';
        $query = "SELECT 
            dbo.MOVCONT3.DOCCOD, 
            dbo.MOVCONT3.MvCNro,            
            dbo.MOVCONT3.MvCFch, 
            dbo.MOVCONT2.MvCNat, 
            dbo.CUENTAS.CntInt, 
            dbo.MOVCONT2.CntCod, 
            dbo.CUENTAS.CntDsc, 
            dbo.MOVCONT2.TrcCod, 
            dbo.TERCEROS.TrcRazSoc, 
            dbo.MOVCONT2.MvCVlr, 
            dbo.MOVCONT2.MvCDocRf1, 
            dbo.MOVCONT2.MvCDocRf2, 
            dbo.MOVCONT2.MvCDet, 
            dbo.MOVCONT2.MvCBse, 
            dbo.MOVCONT2.MvCImpCod
        FROM 
            ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON 
            (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
            (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
            (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
            (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) 
            LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
            (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) 
            LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
        WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
        convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
        ((dbo.MOVCONT2.TrcCod)= '" . $num_id . "')) ORDER BY dbo.MOVCONT3.MvCFch";

        $info = DB::connection('sqlsrv_info')->select($query);



        if (isset($info) && count($info) > 0) {
            $html = view('info.informe', compact('info', 'input', 'headerTitle'))->render();
            return $this->pdf->load($html, array(0, 0, 1300, 800))
                            ->filename('informe_de_pago_a_proveedores_' . date('Y-m-d H:i:s') . '.pdf')
                            ->download();
        }
        return view('info.sin_resultados', compact('input'));
    }

    /**
    * Genera el certificado de pagos a profesionales de la salud segun los parametros establecidos en el formulario
    * @return xls || pdf
    ***/
    public function certificado_pagos_profesionales(Requests\Certificado_de_pagos $request) {
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }
        $headerTitle = 'Certificado de pagos a profesionales de la salud';
        $fileTitle = 'certificado_de_pagos_profesionales_';
        $query = "SELECT 
            dbo.MOVCONT3.DOCCOD, 
            dbo.MOVCONT3.MvCNro,            
            dbo.MOVCONT3.MvCFch, 
            dbo.MOVCONT2.MvCNat, 
            dbo.CUENTAS.CntInt, 
            dbo.MOVCONT2.CntCod, 
            dbo.CUENTAS.CntDsc, 
            dbo.MOVCONT2.TrcCod, 
            dbo.TERCEROS.TrcRazSoc, 
            dbo.MOVCONT2.MvCVlr, 
            dbo.MOVCONT2.MvCDocRf1, 
            dbo.MOVCONT2.MvCDocRf2, 
            dbo.MOVCONT2.MvCDet, 
            dbo.MOVCONT2.MvCBse, 
            dbo.MOVCONT2.MvCImpCod
        FROM 
            ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON 
            (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
            (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
            (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
            (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) 
            LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
            (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) 
            LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
        WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
        convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
        ((dbo.MOVCONT2.TrcCod)= '" . $num_id . "')) AND dbo.MOVCONT2.CntCod NOT LIKE '6%' ORDER BY dbo.MOVCONT3.MvCFch";

        $info = DB::connection('sqlsrv_info')->select($query);

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
    
    /**
     * Genera el reporte del censo en formato xlsx
     * 
     */
    public function censo()
    {
        $query = "SELECT MAEPAB.MPCodP, MAEPAB.MPNomP, MAEPAB.MPCLAPRO, MAEPAB.MPbodega, MAEPAB.MPMCDpto, MAEPAB.MPInFaPOS, MAEPAB.MPVigPres, '<<' AS SEPARADOR1, MAEPAB1.MPNumC, MAEPAB1.MPDisp, MAEPAB1.MPFchI, MAEPAB1.MPUced, MAEPAB1.MPUDoc, CAPBAS.MPNom1, CAPBAS.MPNom2, CAPBAS.MPApe1, CAPBAS.MPApe2, CAPBAS.MPFchN, CAPBAS.MPSexo, MAEPAB1.MPCtvIn, MAEPAB1.MPUdx, MAEDIA.DMNomb, MAEPAB1.MPActCam, '>>' AS SEPARADOR2, INGRESOS.IngNit, MAEEMP.MENOMB
FROM ((((MAEPAB INNER JOIN MAEPAB1 ON MAEPAB.MPCodP = MAEPAB1.MPCodP) LEFT JOIN CAPBAS ON (MAEPAB1.MPUDoc = CAPBAS.MPTDoc) AND (MAEPAB1.MPUced = CAPBAS.MPCedu)) LEFT JOIN MAEDIA ON MAEPAB1.MPUdx = MAEDIA.DMCodi) LEFT JOIN INGRESOS ON (MAEPAB1.MPCtvIn = INGRESOS.IngCsc) AND (MAEPAB1.MPUDoc = INGRESOS.MPTDoc) AND (MAEPAB1.MPUced = INGRESOS.MPCedu)) LEFT JOIN MAEEMP ON INGRESOS.IngNit = MAEEMP.MENNIT
WHERE (((MAEPAB1.MPActCam)='N'))
ORDER BY MAEPAB.MPCodP, MAEPAB1.MPNumC";
        $info = DB::connection('sqlsrv_censo')->select($query);
        if( isset($info) && count($info) > 0 ){
            $this->excel->create('censo' . date('Y-m-d_h:i:s_A'), function($excel) use($info) {
                $excel->sheet('Sheetname', function($sheet) use($info) {
                    $sheet->loadview('info.censo', compact('info'));
                    $sheet->setFontFamily('Comic Sans MS');
                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true
                        )
                    ));
                });
            })->download('xlsx');

        } else {
            return "no se encontraron resultados";
        }
    }
}
