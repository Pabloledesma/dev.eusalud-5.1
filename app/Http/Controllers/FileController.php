<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Es responsable de administrar los archivos pdf, txt y csv
 */

class FileController extends Controller
{
    
	/**
	 * En esta Carpeta se almacenarán archivos para renombrar
	 *
	 * @var String $files
	 */
	protected $files;

	/**
	 * Archivos para imprimir
	 *
	 * @var String $toPrint
	 */
	protected $toPrint;
	
	public function __construct()
	{
		$this->files = public_path() . '/files';
		$this->toPrint = public_path() . '/print';
	}

    /**
     * Verifica y cuenta los archivos creados en el directorio suministado y retorna 
     * un arreglo con los nombres.
     *
     * @param 	String $files
     * @return  Array 
     */
    public function verificar()
    {
    	
    	$nombres = @scandir($this->files);
    	
    	

    	foreach($nombres as $nombre){
    		
    		if( $nombre == '.' || $nombre == '..' ) continue;

			$new_name = $this->toPrint . '/' . date('Y-m-d-H-m-s') . '_' . $nombre;

			rename(
    			$this->files . '/' . $nombre, 
    			$new_name
			);
    	}
    	
    	$mensaje = "";
		$filesToPrint = []; 
    	$print = @scandir($this->toPrint);
    	foreach( $print as $name )
    	{
    		if( $name == '.' || $name == '..' ) continue;
    		if( strpos('printed_', $name) == false ){
    			array_push($filesToPrint, public_path() . '/' . $name);
    		}
    	}
    	
    	if( count($filesToPrint) == 0 ){
    		$mensaje = "No hay archivos para imprimir"; 
    	}

    	
    	return view('files.verificar', compact('mensaje', 'filesToPrint'));  
    } 
}
