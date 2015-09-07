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
                        v-on="submit: onSubmitForm"
                        >

						<div class="form-group">
							<label class="col-lg-4 control-label">Nombre</label>
							<div class="col-lg-6">
								<input 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    id="name" 
                                    value="{{ old('name') }}" 
                                    v-model="newUser.name"
                                >
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 control-label">Correo</label>
							<div class="col-lg-6">
								<input 
                                    type="email" 
                                    class="form-control" 
                                    name="email" id="email" 
                                    value="{{ old('email') }}" 
                                    v-model="newUser.email"
                                >
							</div>
						</div>
                                                
                        <div class="form-group">
							<label class="col-lg-4 control-label">Número de identificación</label>
							<div class="col-lg-6">
								<input 
                                    type="text" 
                                    class="form-control" 
                                    name="num_id" 
                                    id="num_id" 
                                    value="{{ old('num_id') }}" 
                                    v-model="newUser.num_id"
                                >
							</div>
						</div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">Rol</label>
                            <div class="col-lg-6">
                                <select name="role_id" id="role_id" v-model="newUser.role_id">
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
                                    v-model="newUser.password"
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
                                    v-model="newUser.password_confirmation"
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

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    new Vue({
        el:'#register_form',
        data: {
            newUser: {
                name: '',
                email: '',
                num_id: '',
                role_id: '',
                password: '',
                password_confirmation:''
            },

            submitted: false
        }, 

        methods: {
            onSubmitForm: function(e){
                e.preventDefault();

                var user = this.newUser,
                    href = document.querySelector('#cancel_form').getAttribute('href');
                    
                this.newUser = { 
                    name: '',
                    email: '',
                    num_id: '',
                    role_id: '',
                    password: '',
                    password_confirmation:''
                };

                this.submitted = true;
                this.$http.post('register', user);
                location.replace(href);

            }
        }
    });

     //Validación de formularios
     
     $().ready(function(){
         $("#register_form").validate({
             rules: {
                 name: {
                     required: true,
                     minlength: 2
                 },
                 email: {
                     required: true,
                     email: true
                 },
                 num_id: {
                     required: true,
                     minlength: 3
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
                     minlength: "El número de identificación debe contener minimo 8 caracteres"
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
     });
    
     

</script>
    
@stop
