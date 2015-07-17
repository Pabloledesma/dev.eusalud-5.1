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
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem as File;


/**
 * Controla todos los informes y reportes
 *
 * @author Pablo Ledesma
 */
class InfoController extends Controller {

    /**
     * Convierte las vistas a pdf
     *
     * @var    Vsmoraes\Pdf\Pdf $pdf
     */  
    private $pdf;

    /**
     * Convierte las vistas a documentos de excel
     *
     * @var Maatwebsite\Excel\Excel $excel
     */
    private $excel;

    /**
      * Sistema de archivos
      *
      * @var Illuminate\Filesystem\Filesystem   $file
      */ 
    private $file;

    public function __construct(PDF $pdf, Excel $excel, File $file) 
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
        $this->excel = $excel;
        $this->file = $file;
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

    public function resolucion_4505()
    {
        return view('info.4505');
    }

    /**
     * Recibe archivos con extensión txt, xls y csv
     *
     * @param Request $request
     * @return response
     */
    public function post4505(Request $request)
    {
       
        $extension = $request->file('file')->getClientOriginalExtension();

        if( strtolower( $extension ) == 'txt' ){
            $file_name = date('Y-m-d_h:m:s') . "_texto." . $extension;
            $file_path = public_path() . '/files\/' . $file_name;
            if( $request->file('file')->move(public_path() . '/files\/', $file_name) ){

                $myfile = fopen($file_path, "r") or die("Unable to open file!");
                $content = fread($myfile, filesize($file_path));
                fclose($myfile);
                return $content;
            }
        }

        if( strtolower( $extension == 'xls' || $extension == 'xlsx' ) ){
            $file_name = date('Y-m-d_h_m_s') . "_excel." . $extension;
            $file_path = public_path() . '/files\/' . $file_name;
            if( $request->file('file')->move(public_path() . '/files\/', $file_name) ){

                $this->excel->load( $file_path, function($reader){
                    dd($reader->get());
                });
                
            }
        }

       
        
        
        return "sin archivo";
    }  

     
    /**
     * Genera el reporte del censo en formato xlsx
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
