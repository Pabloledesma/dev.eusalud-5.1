<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Es responsable de imprimir y renombrar los archivos txt depositados en la carpeta
 * seleccionada en la variable $files  
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
    	
    	// Agrupa los archivos que no se han impreso
    	$filesToPrint = [];
    	foreach($nombres as $nombre){

    		if( $nombre == '.' || $nombre == '..') 
    			continue;

			//$filesToPrint + $this->files . '/' . date('Y-m-d-H-m-s') . '_' . $nombre;
			if( stripos($nombre , 'ted_') == false )
				array_push($filesToPrint, $nombre);

    	}

    	// si hay archivos para imprimir, los imprime y los renombra
    	if( count($filesToPrint) > 0 ){

    		foreach( $filesToPrint as $nombre ){

    			$this->imprimir_txt( $this->files .'/'. $nombre );

    			$new_name = $this->files .'/printed_'. date('Y-m-d-H-m-s') . $nombre;

    			rename(
	     			$this->files . '/' . $nombre, 
	     			$new_name
			 	);
    		}
    		
    	}
	
    	return view('files.verificar', compact( 'filesToPrint'));  
    }

    /**
     * Imprime un archivo de texto en la impresora seleccionada. Si la impresora no es
     * suministrada, envia la impresión a la impresora instalada por defecto.
     *
     * @param String $archivo 	Ruta del archivo a imprimir
     * @param String $impresora	Nombre de la impresora
     */
    protected function imprimir_txt($archivo, $impresora = null)
	{
	 	if( $impresora != null ){
	 		return shell_exec('NOTEPAD /PT ' . $archivo . ' ' . $impresora);
	 	}

	 	return shell_exec('NOTEPAD /P ' . $archivo);
	}  
}
