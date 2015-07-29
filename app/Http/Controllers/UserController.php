<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Role;

class UserController extends Controller {

    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('acl');
    }
    
    /**
     * Muestra todos los usuarios
     * @return response
     */
    public function index() {

        $usuarios = User::all();
           
        return view('user.index', compact('usuarios'));
    }

    /**
     * Muestra formulario para registrar un usuario
     * @return response
     */
    public function form_register()
    {
        $roles = Role::all(); 
        return view('auth.register', compact('roles'));
    } 

    /**
     * Muestra el formulario de edición para el usuario seleccionado
     * @param integer $id
     * @return View
     */
    public function edit($id) {

        $user = User::findOrFail($id);
        $roles = Role::all();

        if( $user->role ){
            $role_id = $user->role->id;
        }

        $title = "Editando el usuario: ";
        $url = "usuarios/" . $id . "/update";
        $boton = "Editar";
        return view('user.edit', compact('user', 'title', 'url', 'boton', 'role_id', 'roles'));
    }

    /**
     * Valida los datos del formulario y Actualiza el usuario
     *
     * @param EditUserRequest $req
     * @param Integer $id
     * @return Response
     */
    public function update(EditUserRequest $req, $id) {
        $user = User::findOrFail($id);
        $input = $req->all();

        if( isset( $input['role_id'] ) ){
            $user->role()->associate($input['role_id']);
        }

        if (strlen($input['password']) > 0) {
            $input['password'] = bcrypt($input['password']);
        }

        // Si no se ingresa el password se remueve del arreglo
        if(strlen($input['password']) == 0){
            $input = array_slice($input, 0, 6);
        }

        $user->update($input);
        flash()->overlay('El usuario se actualizó correctamente', 'Buen trabajo!');
        return redirect('usuarios');
    }

    /**
     * Procesa la información necesaria para registrar un nuevo usuario
     *
     * @param Requests\Registrar_nuevo_usuario $request
     * @return redirect 
     */
    public function register(Requests\Registrar_nuevo_usuario $request) {
        $input = $request->all();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->num_id = $input['num_id'];
        $user->role_id = $input['role_id'];
        $user->password = bcrypt($input['password']);
        $user->save();

        flash()->overlay('El usuario '. $user->name .' fue registrado correctamente', 'Registro');
        
        return redirect('usuarios');
    }
    
    /**
     * Elimina el usuario seleccionado
     *
     * @param    integer $id 
     * @return   redirect
     */  
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        flash()->overlay('El usuario se elimino correctamente', 'Uno menos.');
        return redirect('usuarios');
    }

}
