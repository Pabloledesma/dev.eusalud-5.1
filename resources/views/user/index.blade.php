@extends('eusalud3')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-user fa-4"></i> Usuarios</h1>
        </div>
        <hr/>

        <a class="btn btn-green" href="{{ url('registrar') }}"><i class="fa fa-plus"></i> Nuevo Usuario</a>
    </div>
    <hr/>            
    <div class="row" id="users">
        <div class="col-lg-12">

        <input type="text" class="form-control" placeholder="Filtrar por ..." v-model="search">

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>               
                        <th><a href="#" v-on="click: sortBy('name')" v-class="active: sortkey == 'name'">Nombre</a></th>
                        <th><a href="#" v-on="click: sortBy('email')" v-class="active: sortkey == 'email'">Correo</a></th>
                        <th><a href="#" v-on="click: sortBy('num_id')" v-class="active: sortkey == 'num_id'">Cedula</a></th>
                        
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                
                
                <tr v-repeat="usuarios | filterBy search | orderBy sortkey reverse">
                    <td>@{{ name }}</td>
                    <td>@{{ email }}</td>
                    <td>@{{ num_id }}</td>
                    <td>
                        <a href="{{ url('usuarios') }}@{{ '/' + id + '/edit'}}"><i class="fa fa-pencil-square-o fa-2"></i></a>
                    </td>
                    <td>
                        <a href="{{ url('usuarios') }}@{{ '/'+ id + '/delete'}}" class="delete"><i class="fa fa-trash fa-2"></i></a>
                    </td>
                </tr>
                
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    new Vue({
        el: '#users',

        data: {
            sortkey: '',
            reverse: false,
            search: ''
        },

        ready: function(){
            this.fetchUsers();
        },

        methods: {
            fetchUsers: function(){
                this.$http.get('all_users', function( usuarios ){
                    this.$set('usuarios', usuarios);
                });
            }, 

            sortBy: function(key){
                this.reverse = (this.sortkey == key) ? !this.reverse : false;
                this.sortkey = key;
            }
        }
    });

    $().ready(function(){
        $("a.delete").on('click', function(e){     
        
            e.preventDefault();
           var href = $(this).attr('href');
            swal({   
                title: "Esta seguro/a?",   
                text: "El usuario ser&aacute; eliminado de la base de datos",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Si, eliminelo!",   
                cancelButtonText: "No, cancelar por favor!",   
                closeOnConfirm: false,   
                closeOnCancel: false,
                html: true 
                }, 
                function(isConfirm){   
                    if (isConfirm) {     
                        location.replace(href);   
                    } else {     
                        swal({
                            title: "Cancelado", 
                            text: "El usuario est&aacute; a salvo <i class='fa fa-smile-o'></i>",
                            type: "error",
                            html: true 
                        });   
                    } 
                }
            );
        });
    });
    
</script>
@stop

