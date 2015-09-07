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
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>               
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Cedula</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                
                @foreach( $usuarios as $u )
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->num_id }}</td>
                    <td>{{ $u->role ? $u->role->role_title : '' }}</td>
                    <td><a href="{{ url('usuarios/'.$u->id.'/edit' ) }}"><i class="fa fa-pencil-square-o fa-2"></i></a></td>
                    <td><a href="{{ url('usuarios/'.$u->id.'/delete' ) }}" class="delete"><i class="fa fa-trash fa-2"></i></a></td>
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<script>
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

