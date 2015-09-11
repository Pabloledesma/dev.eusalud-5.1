@extends('eusalud3')

@section('content')

<div class="row">
    <h1 class="page-header"><i class="fa fa-users fa-4"></i> Roles</h1>
    
</div>
          
    <div class="row" id="roles">

        <div class="col-lg-12">
            <a class="btn btn-green" href="{{ url('roles/create') }}"><i class="fa fa-plus"></i> Crear Rol</a>
            <hr/>

             <input type="text" class="form-control" placeholder="Filtrar por ..." v-model="search">

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                       <th><a href="#" v-on="click: sortBy('role_title')" v-class="active: sortkey == 'role_title'">Titulo</a></th>
                        <th><a href="#" v-on="click: sortBy('role_slug')" v-class="active: sortkey == 'role_slug'">Slug</a></th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    
                    <tr v-repeat="roles | filterBy search | orderBy sortkey reverse">
                        <td>@{{ role_title }}</td>
                        <td>@{{ role_slug }}</td>
                        <td>
                        <a  
                            href="{{ url('roles') }}@{{ '/' + id + '/edit'}}" 
                        >
                            <i class="fa fa-pencil-square-o fa-2"></i>
                        </a>
                    </td>
                    <td>
                        <a 
                            href="{{ url('roles') }}@{{ '/'+ id + '/delete'}}" 
                            class="delete"
                            v-on="click: confirmation( $event )" 
                        >
                            <i class="fa fa-trash fa-2" href="{{ url('roles') }}@{{ '/'+ id + '/delete'}}"></i>
                        </a>
                    </td>
                    </tr>
                   

                </table> 
            </div>   
        </div>
        
   	</div>

<script>

    new Vue({
        el: '#roles',

        data: {
            sortkey: '',
            reverse: false,
            search: ''
        },

        ready: function(){
            this.fetchRoles();
        },

        methods: {
            fetchRoles: function(){
                this.$http.get('all_roles', function( roles ){
                    this.$set('roles', roles);
                });
            }, 

            sortBy: function(key){
                this.reverse = (this.sortkey == key) ? !this.reverse : false;
                this.sortkey = key;
            },

            confirmation: function( e ){
                e.preventDefault();
                var href = e.srcElement.attributes.href.textContent;
                
                swal({   
                    title: "Esta seguro/a?",   
                    text: "El rol será eliminado de la base de datos",   
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
                            console.log(isConfirm);
                                location.replace(href);
                        } else {     
                            swal({
                                title: "Cancelado", 
                                text: "El rol est&aacute; a salvo <i class='fa fa-smile-o'></i>",
                                type: "error",
                                html: true 
                            });   
                        } 
                    }
                );
            }//confirmation            
        }
    });
    
</script>

@stop