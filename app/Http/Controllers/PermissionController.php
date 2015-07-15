<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    
    public function __construct()
    {
    	$this->middleware('role:presidente');
    }

    public function index()
    {
    	$permisos = Permission::all();
        return view('permission.index', compact('permisos'));
    }

    /**
     * Muestra el formulario para crear permisos
     */
    public function create()
     {
     	return 'Formulario para los permisos';
     }  

}
