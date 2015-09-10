@extends('eusalud3')

@section('content')

	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Registro de nuevo usuario</div>
				<div class="panel-body">
                
					@include('partials.error')

					<form 
                        id="register_form" 
                        class="form-horizontal" 
                        role="form" 
                        method="POST" 
                        action="{{ url('register') }}"
                    >
                    {!! csrf_field() !!}

						<div class="form-group">
							<label class="col-lg-4 control-label">
                                Nombre
                            </label>
							<div class="col-lg-6">
								<input 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    id="name"
                                    value="{{ old('name') }}" 
                                >
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 control-label">
                                Correo
                            </label>
							<div class="col-lg-6">
								<input 
                                    type="email" 
                                    class="form-control" 
                                    name="email" 
                                    id="email" 
                                >
							</div>
						</div>
                                                
                        <div class="form-group">
							<label class="col-lg-4 control-label">
                                Número de identificación
                            </label>
							<div class="col-lg-6">
								<input 
                                    type="text" 
                                    class="form-control" 
                                    name="num_id" 
                                    id="num_id" 
                                    value="{{ old('num_id') }}" 
                                >
							</div>
						</div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">Rol</label>
                            <div class="col-lg-6">
                                <select name="role_id" id="role_id">
                                    @foreach( $roles as $r )
                                        <option value="{{$r->id}}">
                                            {{ $r->role_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

						<div class="form-group">
							<label class="col-lg-4 control-label">Clave</label>
							<div class="col-lg-6">
								<input 
                                    type="password" 
                                    class="form-control" 
                                    name="password" 
                                    id="password"
                                >
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 control-label">Confirme su clave</label>
							<div class="col-lg-6">
								<input 
                                    type="password" 
                                    class="form-control" 
                                    name="password_confirmation" 
                                    id="password_confirmation"
                                >
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-6 col-lg-offset-4">
                                <button type="submit" class="btn btn-green" id="submit">Registrar</button>
                                <a id="cancel_form" href="{{ url('usuarios') }}" class="btn btn-primary">Cancelar</a>						
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<script>

$(document).ready(function(){

    var form = $("#register_form");

    var validator = form.validate({
         rules: {
             name: {
                 required: true,
                 minlength: 3
             },
             email: {
                 required: true,
                 email: true
             },
             num_id: {
                 required: true,
                 minlength: 3,
                 number: true
             },
             password: {
                 required: true,
                 minlength: 6
             },
             password_confirmation: {
                 required: true,
                 minlength: 6,
                 equalTo: "#password"
             } 
         },
         messages: {
             name: {
                 required: "Por favor ingrese su nombre",
                 minlength: "El nombre debe contener minimo 2 caracteres"
             },
             email: {
                 required: "Por favor ingrese su correo",
                 email: "Correo invalido"
             },
             num_id: {
                 required: "Por favor ingrese su número de identificación",
                 minlength: "El número de identificación debe contener minimo 3 caracteres",
                 number: "Solo se admiten números en este campo."
             },
             password: {
                 required: "Por favor ingrese su clave",
                 minlength: "Su clave debe contener minimo 6 caracteres"
             },
             password_confirmation: {
                 required: "Por favor confirme su clave",
                 minlength: "La clave debe contener minimo 6 caracteres",
                 equalTo: "La clave no coincide"
             }
         }
     });

    jQuery.validator.setDefaults({
        debug: true,
        success: function(){
/*
            $.post(
                form.attr('action'),
                form.serialize(),
                function( result ){
                    console.log( result );
                    validator.resetForm();
                }    
            );
*/

        }
    });

    

     
});
   

</script>
    
@stop
