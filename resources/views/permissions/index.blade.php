@extends('eusalud3')

@section('content')

    <div class="row">
        <h1 class="page-header"><i class="fa fa-unlock fa-4"></i> Permisos</h1>
          
    </div>
          
    <div class="row" id="permisos">
        <div class="col-lg-12">
            <a class="btn btn-green" href="{{ url('permisos/create') }}"><i class="fa fa-plus"></i> Crear permiso</a>
            <hr/>

            <input type="text" class="form-control" placeholder="Filtrar por ..." v-model="search">
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                	<tr>
                		<th>
                            <a 
                                href="#" 
                                v-on="click: sortBy('permission_title')" 
                                v-class="active: sortkey == 'permission_title'"
                            >
                                Titulo
                            </a>
                        </th>
                        <th>
                            <a 
                                href="#" 
                                v-on="click: sortBy('permission_slug')" 
                                v-class="active: sortkey == 'permission_slug'"
                            >
                                Slug
                            </a>
                        </th>
                		<th>
                            <a 
                                href="#" 
                                v-on="click: sortBy('permission_description')" 
                                v-class="active: sortkey == 'permission_description'"
                            > 
                                Descripción
                            </th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                	</tr>
                    
                    <tr v-repeat="permisos | filterBy search | orderBy sortkey reverse">
                        <td>@{{ permission_title }}</td>
                        <td>@{{ permission_slug }}</td>
                        <td>@{{ permission_description }}</td>
                        <td>
                            <a  
                                href="{{ url('permisos') }}@{{ '/' + id + '/edit'}}" 
                            >
                                <i class="fa fa-pencil-square-o fa-2"></i>
                            </a>
                        </td>
                        <td>
                            <a 
                                href="{{ url('permisos') }}@{{ '/'+ id + '/delete'}}" 
                                class="delete"
                                v-on="click: confirmation( $event )" 
                            >
                                <i class="fa fa-trash fa-2" href="{{ url('permisos') }}@{{ '/'+ id + '/delete'}}"></i>
                            </a>
                        </td>
                    </tr>
                    

            	</table>
            </div>     
            
        </div>
   	</div>

<script>
    new Vue({
        el: '#permisos',

        data: {
            sortkey: '',
            reverse: false,
            search: ''
        },

        ready: function(){
            this.fetchPermisos();
        },

        methods: {
            fetchPermisos: function(){
                this.$http.get('get_all_permissions', function( permisos ){
                    this.$set('permisos', permisos);
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
                    text: "El permiso será eliminado de la base de datos",   
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
                                text: "El permiso está a salvo <i class='fa fa-smile-o'></i>",
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