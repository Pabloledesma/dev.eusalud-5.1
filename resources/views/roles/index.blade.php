@extends('eusalud3')

@section('content')

<div class="row">
    <h1 class="page-header"><i class="fa fa-users fa-4"></i> Roles</h1>
    
</div>
          
    <div class="row">

        <div class="col-lg-12">
            <a class="btn btn-green" href="{{ url('roles/create') }}"><i class="fa fa-plus"></i> Crear Rol</a>
            <hr/>  
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Titulo</th>
                        <th>Slug</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    @foreach( $roles as $r )
                    <tr>
                        <td>{{ $r->role_title }}</td>
                        <td>{{ $r->role_slug }}</td>
                        <td><a href="{{ url('roles/'.$r->id.'/edit' ) }}"><i class="fa fa-pencil-square-o fa-2"></i></a></td>
                        <td><a href="{{ url('roles/'.$r->id.'/delete' ) }}" class="delete"><i class="fa fa-trash fa-2"></i></a></td>
                    </tr>
                    @endforeach

                </table> 
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
                text: "El rol ser&aacute; eliminado de la base de datos",   
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
                            text: "El rol est&aacute; a salvo <i class='fa fa-smile-o'></i>",
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