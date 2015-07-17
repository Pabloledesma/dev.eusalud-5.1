<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ruaf;

class RuafController extends Controller
{
    
    private $excel;

    public function __construct(Excel $excel)
    {
    	$this->excel = $excel;
    }

    /**
     * Muestra el formulario para subir el archivo
     *
     * @return resourse
     */
    public function import()
    {
    	
    	// prueba
    	$this->excel->load( public_path() . '/files\/' . "2015-07-17_02_07_44_excel.xls", function($reader){
                    $all_sheets = $reader->get()->toArray();
                    foreach( $all_sheets as $sheet ){
                    	
                    	foreach($sheet as $row){
                    		// Si tiene 60 columnas es el ruaf
                    		if(count($row) == 60){
                    			Ruaf::create([
                    				'id'	=> $row['id'],
                    				'numero_certificado'=> $row['numero_certificado'],
							        'departamento'=> $row['departamento'],
							        'municipio'=> $row['municipio'],
							        'area_nacimiento'=> $row['area_nacimiento'],
							        'inspeccion_corregimiento_o_caserio_nacimiento'=> $row[''],
							        'sitio_nacimiento'=> $row[''],
							        'codigo_institucion'=> $row[''],
							        'nombre_institucion'=> $row[''],
							        'sexo'=> $row[''],
							        'peso_gramos'=> $row[''],
							        'talla_centimetros'=> $row[''],
							        'fecha_nacimiento'=> $row[''],
							        'hora_nacimiento'=> $row[''],
							        'parto_atendido_por'=> $row[''],
							        'tiempo_de_gestacion'=> $row[''],
							        'numero_consultas_prenatales'=> $row[''],
							        'tipo_parto'=> $row[''],
							        'multiplicidad_embarazo'=> $row[''],
							        'apgar1'=> $row[''],
							        'apgar2'=> $row[''],
							        'grupo_sanguineo'=> $row[''],
							        'factor_rh'=> $row[''],
							        'pertenencia_etnica'=> $row[''],
							        'grupo_indigena'=> $row[''],
							        'nombres_madre'=> $row[''],
							        'apellidos_madre'=> $row[''],
							        'apellidos_madre'=> $row[''],
							        'tipo_documento_madre'=> $row[''],
							        'numero_documento_madre'=> $row[''],
							        'edad_madre'=> $row[''],
							        'estado_conyugal_madre'=> $row[''],
							        'nive_educativo_madre'=> $row[''],
							        'ultimo_año_aprovado_madre'=> $row[''],
							        'pais_residencia'=> $row[''],
							        'departamento_residencia'=> $row[''],
							        'municipio_residencia'=> $row[''],
							        'area_residencia'=> $row[''],
							        'localidad'=> $row[''],
							        'barrio'=> $row[''],
							        'direccion'=> $row[''],
							        'centro_poblado'=> $row[''],
							        'rural_disperso'=> $row[''],
							        'numero_hijos_nacidos_vivos'=> $row[''],
							        'fecha_anterior_hijo_nacido_vivo'=> $row[''],
							        'numero_embarazos'=> $row[''],
							        'regimen_seguridad'=> $row[''],
							        'tipo_administradora'=> $row[''],
							        'nombre_administradora'=> $row[''],
							        'edad_padre'=> $row[''],
							        'nivel_educativo_padre'=> $row[''],
							        'ultimo_ano_aprovado_padre'=> $row[''],
							        'nombres_y_apellidos_certificador'=> $row[''],
							        'numero_documento_certificador'=> $row[''],
							        'departamento_expedicion'=> $row[''],
							        'municipio_expedicion'=> $row[''],
							        'fecha_expedicion'=> $row[''],
							        'estado_certificado'
                    			]);
                    		}
                    	}
                    }
        });
    	return view('ruaf.4505');
    }

    /**
      * Valida la información y la almacena
      *
      * @param Request $request
      * @return Response
      */ 
    public function store(Request $request)
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
                    $all_rows = $reader->get();

                    foreach( $all_rows as $row ){
                    	dd($row['RUAF']);
                    }
                });
                
            }
        }
 
        return "sin archivo";
    } 
}
