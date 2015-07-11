<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Maatwebsite\Excel\Excel;
use Vsmoraes\Pdf\PDF;
use App\Http\Controllers\Traits\Info\CertificadoIca;
use App\Http\Controllers\Traits\Info\PagoProveedores;
use App\Http\Controllers\Traits\Info\PagoProfesionales;


/**
 * Controla todos los informes y reportes
 *
 * @author Pablo Ledesma
 */
class InfoController extends Controller {

    /**
     * Convierte las vistas a pdf
     *
     * @param    Vsmoraes\Pdf\Pdf $pdf
     */  
    private $pdf;

    /**
     * Convierte las vistas a documentos de excel
     *
     * @param Maatwebsite\Excel\Excel $excel
     */
    private $excel; 

    public function __construct(PDF $pdf, Excel $excel) {
        $this->middleware('auth');
        $this->pdf = $pdf;
        $this->excel = $excel;
    }

    /**
    * Muestra una lista con los formularios disponibles
    *
    * @return Responce
    */
    public function index() {
        return view('info.index');
    }

    /*** TRAITS ***/

    use Traits\Info\CertificadoIca, 
        Traits\Info\PagoProveedores,
        Traits\Info\PagoProfesionales;

     
    /**
     * Genera el reporte del censo en formato xlsx (pendiente por crear proceso almacenado)
     * 
     * @return View
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
